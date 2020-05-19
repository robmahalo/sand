// Licensed to the Software Freedom Conservancy (SFC) under one
// or more contributor license agreements.  See the NOTICE file
// distributed with this work for additional information
// regarding copyright ownership.  The SFC licenses this file
// to you under the Apache License, Version 2.0 (the
// "License"); you may not use this file except in compliance
// with the License.  You may obtain a copy of the License at
//
//   http://www.apache.org/licenses/LICENSE-2.0
//
// Unless required by applicable law or agreed to in writing,
// software distributed under the License is distributed on an
// "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
// KIND, either express or implied.  See the License for the
// specific language governing permissions and limitations
// under the License.

package org.openqa.selenium.grid;

import org.openqa.selenium.cli.CliCommand;
import org.openqa.selenium.cli.WrappedPrintWriter;

import java.io.File;
import java.io.PrintStream;
import java.io.PrintWriter;
import java.io.UncheckedIOException;
import java.net.MalformedURLException;
import java.net.URL;
import java.net.URLClassLoader;
import java.security.AccessController;
import java.security.PrivilegedAction;
import java.util.ArrayList;
import java.util.Comparator;
import java.util.List;
import java.util.ServiceLoader;
import java.util.Set;
import java.util.StringTokenizer;
import java.util.TreeSet;
import java.util.logging.Level;
import java.util.logging.Logger;

import static java.util.Comparator.comparing;

public class Main {

  private static final Logger LOG = Logger.getLogger(Main.class.getName());

  private final PrintStream out;
  private final PrintStream err;
  private final String[] args;

  public static void main(String[] args) throws Exception {
    new Main(System.out, System.err, args).go();
  }

  Main(PrintStream out, PrintStream err, String[] args) {
    // It's not private to make it visible for tests
    this.out = out;
    this.err = err;
    this.args = args;
  }

  void go() throws Exception {
    // It's not private to make it visible for tests
    if (args.length == 0) {
      new Help(loadCommands(Main.class.getClassLoader())).configure(out, err).run();
    } else {
      if ("--ext".equals(args[0])) {
        if (args.length > 1) {
          StringTokenizer tokenizer = new StringTokenizer(args[1], File.pathSeparator);
          List<File> jars = new ArrayList<>();
          while (tokenizer.hasMoreTokens()) {
            File file = new File(tokenizer.nextToken());
            if (file.exists()) {
              if (file.isDirectory()) {
                for (File subdirFile : file.listFiles()) {
                  if (subdirFile.isFile() && subdirFile.getName().endsWith(".jar")) {
                    jars.add(subdirFile);
                  }
                }
              } else {
                jars.add(file);
              }
            } else {
              LOG.warning("WARNING: Extension file or directory does not exist: " + file);
            }
          }

          URL[] jarUrls = jars.stream().map(file -> {
            try {
              return file.toURI().toURL();
            } catch (MalformedURLException e) {
              LOG.log(Level.SEVERE, "Unable to find JAR file " + file, e);
              throw new UncheckedIOException(e);
            }
          }).toArray(URL[]::new);

          URLClassLoader loader = AccessController.doPrivileged(
              (PrivilegedAction<URLClassLoader>) () ->
                  new URLClassLoader(jarUrls, Main.class.getClassLoader()));

          // Ensure that we use our freshly minted classloader by default.
          Thread.currentThread().setContextClassLoader(loader);

          if (args.length > 2) {
            String[] remainingArgs = new String[args.length - 2];
            System.arraycopy(args, 2, remainingArgs, 0, args.length - 2);
            launch(remainingArgs, loader);
          } else {
            new Help(loadCommands(loader)).configure(out, err).run();
          }
        } else {
          new Help(loadCommands(Main.class.getClassLoader())).configure(out, err).run();
        }

      } else {
        launch(args, Main.class.getClassLoader());
      }
    }
  }

  private static Set<CliCommand> loadCommands(ClassLoader loader) {
    Set<CliCommand> commands = new TreeSet<>(comparing(CliCommand::getName));
    ServiceLoader.load(CliCommand.class, loader).forEach(commands::add);
    return commands;
  }

  private void launch(String[] args, ClassLoader loader) throws Exception {
    String commandName = args[0];
    String[] remainingArgs = new String[args.length - 1];
    System.arraycopy(args, 1, remainingArgs, 0, args.length - 1);

    Set<CliCommand> commands = loadCommands(loader);

    CliCommand command = commands.parallelStream()
        .filter(cmd -> commandName.equals(cmd.getName()))
        .findFirst()
        .orElse(new Help(commands));

    command.configure(out, err, remainingArgs).run();
  }

  private static class Help implements CliCommand {

    private final Set<CliCommand> commands;

    public Help(Set<CliCommand> commands) {
      this.commands = commands;
    }

    @Override
    public String getName() {
      return "Selenium Server commands";
    }

    @Override
    public String getDescription() {
      return "A list of all the commands available. To use one, run `java -jar selenium.jar " +
             "commandName`.";
    }

    @Override
    public Executable configure(PrintStream out, PrintStream err, String... args) {
      return () -> {
        int longest = commands.stream()
                          .filter(CliCommand::isShown)
                          .map(CliCommand::getName)
                          .max(Comparator.comparingInt(String::length))
                          .map(String::length)
                          .orElse(0) + 2;  // two space padding either side

        PrintWriter outWriter = new WrappedPrintWriter(out, 72, 0);
        outWriter.append(getName()).append("\n\n");
        outWriter.append(getDescription()).append("\n").append("\n");

        int indent = Math.min(longest + 2, 25);
        String format = "  %-" + longest + "s";

        PrintWriter indented = new WrappedPrintWriter(out, 72, indent);
        commands.stream()
          .filter(CliCommand::isShown)
          .forEach(cmd -> indented.format(format, cmd.getName())
            .append(cmd.getDescription())
            .append("\n"));

        outWriter.write("\nFor each command, run with `--help` for command-specific help\n");
        outWriter.write("\nUse the `--ext` flag before the command name to specify an additional " +
                  "classpath to use with the server (for example, to provide additional " +
                  "commands, or to provide additional driver implementations). For example:\n");
        outWriter.write(String.format(
            "\n  java -jar selenium.jar --ext example.jar%sdir standalone --port 1234",
            File.pathSeparator));
        out.println("\n");
      };
    }
  }
}
