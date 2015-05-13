# PHP Qrcode Library (support laravel framework)


----------

## Introduction

This is package generate Qrcode using some services like google qrcode (currently, it only support google service). This package also support <b>attaching logo</b> into qrcode. In Laravel framework, it fully support for using facade, blade helper.

Reference https://developers.google.com/chart/infographics/docs/qr_code

## Installation

- This is require: php5-gd for write image.
~~~
      Debian: apt-get install php5-gd

      RedHat: yum install gd gd-devel php-gd
~~~

- Update require in `composer.json` file.
~~~
      "vcode/qrcode": "dev-master"
~~~
- You'll then need to run 
~~~
      composer update
~~~

- Or
~~~
      composer require "vcode/qrcode":"dev-master"
~~~

## LARAVEL USING

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

#### Using In Controller
~~~php

    $value = "https://github.com/tyanhly/vcode_qrcode";

    //or for fully options
    //$value = array(
    //    'chs' => "250x250",
    //    'cht' => "qr",
    //    'chl' => "https://github.com/tyanhly/vcode_qrcode"
    //    'chld'=> "H|1",         // H(QML)|1, H|2, H|3, H|4, H|10, H|40,
    //    'choe'=> "UTF-8"        // UTF-8, Shift_JIS, ISO-8859-1
    //);
    
    /**
     * @param array googleOption
     * @param string $destinate
     * @param string $logoPath
     * @param float $ratioOfLogoOnQrcode
     * @param int $qrCodeService
     */
    //Qrcode::storageImage(array googleOption, string $destinate, string $logoPath, float $ratioOfLogoOnQrcode, int $qrCodeService);
    Qrcode::storageImage($value, "/tmp/destination.png", "logo.png", 0.3);
    
    
    /**
     * @param array googleOption
     * @param int $qrCodeService
     */
    //Qrcode::render(array googleOption, int $qrCodeService);
    Qrcode::render($value);
    
    /**
     * @param array googleOption
     * @param string $logoPath
     * @param float $ratioOfLogoOnQrcode
     * @param int $qrCodeService
     */
    //Qrcode::renderBase64(array googleOption, string $logoPath, float $ratioOfLogoOnQrcode, int $qrCodeService);
    Qrcode::renderBase64($value, "logo.png");
    
    
    /**
     * @param array googleOption
     * @param string $logoPath
     * @param float $ratioOfLogoOnQrcode
     * @param int $qrCodeService
     */
    //Qrcode::renderBase64Dome(array googleOption, string $logoPath, float $ratioOfLogoOnQrcode, int $qrCodeService);
    Qrcode::renderBase64Dom($value, "logo.png");

~~~

#### Using the Blade helper

~~~html

@qrcode("https://github.com/tyanhly/vcode_qrcode")
@qrcodeBase64Dom("https://github.com/tyanhly/vcode_qrcode", "logo.png", 0.5)
<img src="data:image/png;base64,@qrcodeBase64("https://github.com/tyanhly/vcode_qrcode", "logo.png", 0.5)" />

~~~

## Using like php library

~~~php

    //Please, reference <this source>/example for more detail
    
    include 'vendor/autoload.php';
    $qrcode = new Vcode\Qrcode\Qrcode(array(
            'qrcode::google_config_default' => array(
                'chs' => "250x250",
                'cht' => "qr",
                'chld'=> "H|1",         // H(QML)|1, H|2, H|3, H|4, H|10, H|40,
                'choe'=> "UTF-8"        // UTF-8, Shift_JIS, ISO-8859-1
            ),
            'qrcode::template_simple' => './template',
            'qrcode::storage_dir'     => '/tmp'
        ));
    $value = "MECARD:N:Tung,Ly;ADR:124 Cao Xuan Duc 12w D8 HCM city;"
           . "TEL:+84906667100;EMAIL:tyanhly@gmail.com;;";
    //$qrcode->render($value);
    $qrcode->renderBase64Dom($value, "http://transcosmos.com/wp-content/uploads/2014/06/logo3.png", 0.7);
    
~~~

## Example
  
- https://github.com/tyanhly/vcode_qrcode/tree/master/example

## Change Log

#### v1.0.0

- First release

#### v1.0.1

- Base64 encoding
- Storage image

#### v1.1.0

- Logo attach
- Support like a library, not only for laravel. 
