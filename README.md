# Qrcode for Laravel


----------

## Introduction

This is package generate Qrcode using some services like google qrcode. 
This job help your server don't care about performance to create qr_code - just let service provider care it for us. 
Reference https://developers.google.com/chart/infographics/docs/qr_code

## Installation


Edit require in `composer.json` file.

~~~
"vcode/qrcode": "dev-master"
~~~

You'll then need to run `composer update` 

File: `app/config/app.php` 
Provider:
~~~php
'providers' => array(

    'Vcode\Qrcode\QrcodeServiceProvider',

)
~~~
Facade
~~~php
'aliases' => array(

    'Qrcode' => 'Vcode\Qrcode\Facades\Qrcode',

)
~~~

Create configuration file using artisan

~~~
$ php artisan config:publish vcode/qrcode
~~~

## Rendering
~~~php

Qrcode::render("https://github.com/tyanhly/laravel_qrcode")

Qrcode::render(array(
    'chs' => "250x250",
    'cht' => "qr",
    'chl' => "https://github.com/tyanhly/laravel_qrcode"
    'chld'=> "H|1",         // H(QML)|1, H|2, H|3, H|4, H|10, H|40,
    'choe'=> "UTF-8"        // UTF-8, Shift_JIS, ISO-8859-1
));
~~~

## Using the Blade helper

~~~html
@qrcode("https://github.com/tyanhly/laravel_qrcode");
~~~

## Change Log

#### v0.1.0

- First release