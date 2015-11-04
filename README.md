# 2D-Gate 繁化姬 詞語模組

2D-Gate 繁化姬：https://sctctw.2d-gate.org

這個倉庫是「2D-Gate 繁化姬」中所使用的部分模組，你可以提交新的模組或是修正現有的模組。


## 環境要求

PHP >= 5.6 推薦 PHP 7


## 如何測試模組


### 使用現有的伺服器環境測試

將 `test.php` 中的 `$testMod`, `$to`, `$text` 改為相應的情境後訪問該 PHP 檔案即可查看轉換後的文字。
```php
<?php

// the module we want to test
$testMod = 'OnePiece';
// target locale: sc/tc/hk/tw
$to = 'tw';

// the input text
$text = '海贼王路飞 海贼王路飞 海贼王路飞 海贼王路飞 海贼王路飞';

// do test
require 'test.require.php';
```

以下是測試結果
```php
array(3) {
  ["sc"]=>
  string(63) "海贼王路飞 海贼王路飞 海贼王路飞 海贼王路飞 海贼王路飞"
  ["tc"]=>
  string(63) "海賊王路飛 海賊王路飛 海賊王路飛 海賊王路飛 海賊王路飛"
  ["src"]=>
  string(63) "海贼王路飞 海贼王路飞 海贼王路飞 海贼王路飞 海贼王路飞"
}
array(3) {
  ["load_or_not"]=>
  bool(true)
  ["loop_or_not"]=>
  bool(false)
  ["conversion_table"]=>
  &array(16) {
    ...
  }
}
string(63) "海賊王魯夫 海賊王魯夫 海賊王魯夫 海賊王魯夫 海賊王魯夫"
```

* 第一個 `array(3)` 中僅為單純把文字轉換為繁簡。
* 第二個 `array(3)` 中可以看到模組到底有沒有被啟用。
* 最後一個 `string(...)` 為經過模組處理後的文字。


### 使用 PHP 內建的網頁伺服器來測試

1. 開啟 `cmd`
1. 將工作目錄切換到倉庫的目錄中
1. 執行 `php -S localhost:12345`
1. 使用瀏覽器訪問 `localhost:12345/test.php`


## 開放原始碼專案

* [Wikimedia 繁簡轉換表 (Wikimedia Foundation)](http://git.wikimedia.org/blob/mediawiki%2Fcore.git/HEAD/includes%2FZhConversion.php)


## The MIT License (MIT)

Copyright (c) 2015 小斐@2D-Gate

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
