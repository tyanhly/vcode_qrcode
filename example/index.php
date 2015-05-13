<?php
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
$value = "MECARD:N:Tung,Ly;ADR:124 Cao Xuan Duc;"
       . "TEL:+84906667100;EMAIL:tyanhly@gmail.com;;";
$qrcode->render($value);
$qrcode->renderBase64Dom($value, "http://transcosmos.com/wp-content/uploads/2014/06/logo3.png", 0.7);
