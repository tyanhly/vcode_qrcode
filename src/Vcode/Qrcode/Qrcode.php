<?php

namespace Vcode\Qrcode;

use Illuminate\Support\Facades\Log;
/**
 *
 * @author Tung Ly
 */
class Qrcode
{

    const SERVICE_GOOGLE = 0x01;
    const LOGO_RATIO = 0.3;

    /**
     * keys:
     *     qrcode::template_simple
     *     qrcode::google_config_default
     *     qrcode::storage_dir
     *
     * please see src/config/config.php for more detail
     *
     * @var array
     */
    public static $config;

    /**
     *
     * @param $config
     * @author Tung Ly
     */
    public function __construct($config = null)
    {
        if($config){
            self::$config = $config;
        }else{
            throw new QrcodeException(QrcodeException::QRCODE_INIT_ERROR);
        }

    }

    /**
     *
     * @param string|array $value
     * @param number $type
     * @author Tung Ly
     */
    public function render($value, $type = self::SERVICE_GOOGLE)
    {
        $this->prepareValueData($value);

        switch ($type) {

            case self::SERVICE_GOOGLE:
                $result = GoogleQrcode::getQrcodeDom($value);
                break;

            default:
                $result = GoogleQrcode::getQrcodeDom($value);
                break;
        }
        echo $result;
    }

    /**
     * @param unknown $value
     * @param string $logoPath
     * @param float $ratio
     * @param number $type
     * @author Tung Ly
     */
    public function renderBase64Dom($value, $logoPath=null, $ratio = Qrcode::LOGO_RATIO, $type = self::SERVICE_GOOGLE)
    {
        $this->prepareValueData($value);

        switch ($type) {

            case self::SERVICE_GOOGLE:
                $result = GoogleQrcode::getQrcodeBase64Dom($value, $logoPath, $ratio);
                break;

            default:
                $result = GoogleQrcode::getQrcodeBase64Dom($value, $logoPath, $ratio);
                break;
        }
        echo $result;
    }


    /**
     * @param unknown $value
     * @param string $logoPath
     * @param float $ratio
     * @param number $type
     * @author Tung Ly
     */
    public function renderBase64($value, $logoPath=null, $ratio  = Qrcode::LOGO_RATIO,  $type = self::SERVICE_GOOGLE)
    {
        $this->prepareValueData($value);

        switch ($type) {

            case self::SERVICE_GOOGLE:
                $result = GoogleQrcode::getQrcodeBase64($value, $logoPath, $ratio);
                break;

            default:
                $result = GoogleQrcode::getQrcodeBase64($value, $logoPath, $ratio);
                break;
        }
        echo $result;
    }

    /**
     * @param unknown $value
     * @param string $destination
     * @param string $logoPath
     * @param float $ratio
     * @param number $type
     * @author Tung Ly
     */
    public function storageImage($value, $destination = null, $logoPath=null, $ratio = Qrcode::LOGO_RATIO, $type = self::SERVICE_GOOGLE)
    {
        $this->prepareValueData($value);
        switch ($type) {

            case self::SERVICE_GOOGLE:
                GoogleQrcode::storageQrcodeImage($value, $destination, $logoPath, $ratio);
                break;

            default:
                GoogleQrcode::storageQrcodeImage($value, $destination, $logoPath, $ratio);
                break;
        }
    }

    /**
     * @param unknown $value
     * @throws QrcodeException
     * @author Tung Ly
     */
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