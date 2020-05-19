<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('includes.head')
           <!-- Styles -->
           <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
                flex-direction: column;
            }

            .position-ref {
                position: relative;
            }

            .content {
                text-align: center;
                font-size: 20px;
            }

            .title {
                font-size: 74px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="title">
                {{ $error[0] }}
            </div>
            <div class="content">
                {{ $error[1] }}
            </div>
        </div>

        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
