<?php

namespace Vcode\Qrcode;

/**
 * reference https://developers.google.com/chart/infographics/docs/qr_codes
 * @author tungly
 */
class GoogleQrcode
{


    /**
     * @param array $input
     * @param string $logoUrl
     * @return string
     * @author Tung Ly
     */
    public static function createDomQrcode ($input) {
        $url = self::getUrl($input);
        $html = file_get_contents(QrCode::$app['config']['qrcode::template_simple']);
        $html = str_replace("%%URI_IMG_QRCODE%%", $url, $html);
        return $html;
    }

    /**
     * @param array $input
     * @throws QrcodeException
     * @return string
     * @author Tung Ly
     */
    public static function getUrl($input){
        $config = QrCode::$app['config']['qrcode::google_config_default'];
        if(!isset($input['chl'])){
            throw new QrcodeException(QrcodeException::DONT_HAVE_CHL);
        }
        $info = array(
            'chs' => isset($input['chs'])?$input['chs'] : $config['chs'],
            'cht' => isset($input['cht'])?$input['cht'] : $config['cht'],
            'chld'=> isset($input['chld'])?$input['chld'] : $config['chld'],
            'choe'=> isset($input['choe'])?$input['choe'] : $config['choe'],
            'chl' => $input['chl'],
        );

        $params = http_build_query($info);
        $url = "https://chart.googleapis.com/chart?$params" ;
        return $url;
    }

}