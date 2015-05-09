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
        $this->prepareValueData($value);

        switch ($type) {

            case self::TYPE_GOOGLE:
                $result = GoogleQrcode::getQrcodeDom($value);
                break;

            default:
                $result = GoogleQrcode::getQrcodeDom($value);
                break;
        }
        echo $result;
    }

    /**
     *
     * @param string|array $value
     * @param number $type
     * @author Tung Ly
     */
    public function renderBase64Dom($value, $type = self::TYPE_GOOGLE)
    {
        $this->prepareValueData($value);

        switch ($type) {

            case self::TYPE_GOOGLE:
                $result = GoogleQrcode::getQrcodeBase64Dom($value);
                break;

            default:
                $result = GoogleQrcode::getQrcodeBase64Dom($value);
                break;
        }
        echo $result;
    }


    /**
     *
     * @param string|array $value
     * @param number $type
     * @author Tung Ly
     */
    public function renderBase64($value, $type = self::TYPE_GOOGLE)
    {
        $this->prepareValueData($value);

        switch ($type) {

            case self::TYPE_GOOGLE:
                $result = GoogleQrcode::getQrcodeBase64($value);
                break;

            default:
                $result = GoogleQrcode::getQrcodeBase64($value);
                break;
        }
        echo $result;
    }
    /**
     *
     * @param string|array $value
     * @param number $type
     * @author Tung Ly
     */
    public function storageImage($value, $destination = null, $type = self::TYPE_GOOGLE)
    {
        $this->prepareValueData($value);
        switch ($type) {

            case self::TYPE_GOOGLE:
                $result = GoogleQrcode::storageQrcodeImage($value, $destination);
                break;

            default:
                $result = GoogleQrcode::storageQrcodeImage($value, $destination);
                break;
        }
        return $result;
    }

    public function prepareValueData(&$value){

        if (is_string($value)) {
            $value = array(
                'chl' => $value
            );

        } elseif (! is_array($value)) {
            throw new QrcodeException(QrcodeException::PARAM_NOT_STRING_OR_ARRAY_ERROR);
        }
    }
}