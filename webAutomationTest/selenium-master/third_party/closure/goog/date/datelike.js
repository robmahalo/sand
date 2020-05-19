// Copyright 2010 The Closure Library Authors. All Rights Reserved.
//
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at
//
//      http://www.apache.org/licenses/LICENSE-2.0
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS-IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.

/**
 * @fileoverview Typedefs for working with dates.
 *
 * @author nicksantos@google.com (Nick Santos)
 */

goog.provide('goog.date.DateLike');

goog.forwardDeclare('goog.date.Date');  // circular reference


/**
 * @typedef {(Date|goog.date.Date)}
 */
goog.date.DateLike;
