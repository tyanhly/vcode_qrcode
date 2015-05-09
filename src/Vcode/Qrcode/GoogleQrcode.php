<?php
namespace Vcode\Qrcode;

/**
 * reference https://developers.google.com/chart/infographics/docs/qr_codes
 *
 * @author tungly
 */
class GoogleQrcode
{

    /**
     *
     * @param array $input
     * @param string $filePath
     * @return string
     * @author Tung Ly
     */
    public static function storageQrcodeImage($input, $destination = null)
    {
        if (! $destination) {
            QrcodeUtil::mkdir(Qrcode::$app['config']['qrcode::storage_dir']);
            $destination = QrCode::$app['config']['qrcode::storage_dir'] . "/qrcode.png";
        }
        $result = file_put_contents($destination, self::getQrCodeImageContent($input));
        return $result;
    }

    /**
     * Create base64 image data
     *
     * @param array $input
     * @return string
     * @author Tung Ly
     */
    public static function getQrcodeBase64($input)
    {
        $content = self::getQrCodeImageContent($input);
        return base64_encode($content);
    }


    /**
     * Create qrcode html dom data which src is base64 encode data
     * @param array $input
     * @return string
     * @author Tung Ly
     */
    public static function getQrcodeBase64Dom($input)
    {
        $content = self::getQrCodeImageContent($input);
        $src = "data:image/png;base64," . base64_encode($content);

        $html = file_get_contents(QrCode::$app['config']['qrcode::template_simple']);
        $html = str_replace("%%URI_IMG_QRCODE%%", $src, $html);
        return $html;
    }


    /**
     * Create qrcode html dom data
     * @param array $input
     * @return string
     * @author Tung Ly
     */
    public static function getQrcodeDom($input)
    {
        $url = self::getUrl($input);
        $html = file_get_contents(QrCode::$app['config']['qrcode::template_simple']);
        $html = str_replace("%%URI_IMG_QRCODE%%", $url, $html);
        return $html;
    }

    /**
     *
     * @param array $input
     * @throws QrcodeException
     * @return string
     * @author Tung Ly
     */
    public static function getUrl($input)
    {
        $config = QrCode::$app['config']['qrcode::google_config_default'];
        if (! isset($input['chl'])) {
            throw new QrcodeException(QrcodeException::DONT_HAVE_CHL_ERROR);
        }
        $info = array(
            'chs' => isset($input['chs']) ? $input['chs'] : $config['chs'],
            'cht' => isset($input['cht']) ? $input['cht'] : $config['cht'],
            'chld' => isset($input['chld']) ? $input['chld'] : $config['chld'],
            'choe' => isset($input['choe']) ? $input['choe'] : $config['choe'],
            'chl' => $input['chl']
        );

        $params = http_build_query($info);
        $url = "https://chart.googleapis.com/chart?$params";
        return $url;
    }

    /**
     * @param array $input
     * @throws QrcodeException
     * @return string
     * @author Tung Ly
     */
    public static function getQrCodeImageContent($input)
    {
        $url = self::getUrl($input);
        $size = getimagesize($url);
        if ($size) {
            return file_get_contents($url);
        }
        throw new QrcodeException(QrcodeException::CANNOT_GET_IMAGE_FROM_GOOGLE_ERROR);
    }
}