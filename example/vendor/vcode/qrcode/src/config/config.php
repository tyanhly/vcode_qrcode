<?php

return array(
    'google_config_default' => array(
        'chs' => "250x250",
        'cht' => "qr",
        'chld'=> "H|1",         // H(QML)|1, H|2, H|3, H|4, H|10, H|40,
        'choe'=> "UTF-8"        // UTF-8, Shift_JIS, ISO-8859-1
    ),
    'template_simple' =>dirname(__DIR__) . '/template/simple.tpl',


    'storage_dir' => app_path('storage') . '/vcode/qrcode',
);