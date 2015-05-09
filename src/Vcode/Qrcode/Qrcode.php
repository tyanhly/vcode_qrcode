<?php

namespace Vcode\Qrcode;

class Qrcode
{

    const TYPE_GOOGLE = 0x01;

    /**
     * Laravel application
     *
     * @var \Illuminate\Foundation\Application
     */
    public static $app;

    /**
     *
     * @param \Illuminate\Foundation\Application $app
     * @author Tung Ly
     */
    public function __construct($app)
    {
        self::$app = $app;
    }

    /**
     *
     * @param string|array $value
     * @param number $type
     * @author Tung Ly
     */
    public function render($value, $type = self::TYPE_GOOGLE)
    {
        if (is_string($value)) {
            $value = array(
                'chl' => $value
            );
        } elseif (! is_array($value)) {
            throw new QrcodeException(QrcodeException::PARAM_NOT_STRING_OR_ARRAY_ERROR);
        }

        switch ($type) {

            case self::TYPE_GOOGLE:
                $result = GoogleQrcode::createDomQrcode($value);
                break;

            default:
                $result = GoogleQrcode::createDomQrcode($value);
                break;
        }
        echo $result;
    }
}