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
     * @param array $input
     * @param string $destination
     * @param string $logoPath
     * @param float $ratio
     * @author Tung Ly
     */
    public static function storageQrcodeImage($input, $destination = null, $logoPath = null, $ratio = Qrcode::LOGO_RATIO)
    {
        $qrcodeUrl = self::getUrl($input);
        $qrcodeImage = new Image($qrcodeUrl);

        if (! $destination) {
            QrcodeUtil::mkdir(Qrcode::$config['qrcode::storage_dir']);
            $destination = QrCode::$config['qrcode::storage_dir'] . "/qrcode.png";
        }
        if (! $logoPath) {
            $qrcodeImage->storageImageTo($destination);
        } else {
            $logoImage = new Image($logoPath);
            $qrcodeImage->mergeInCenter($logoImage, $ratio);
            $qrcodeImage->copyImageFromTmpTo($destination);
        }
    }

    /**
     *
     * Create base64 image data
     * @param array $input
     * @param string $logoPath
     * @param float $ratio
     * @return string
     * @author Tung Ly
     */
    public static function getQrcodeBase64($input, $logoPath = null, $ratio = Qrcode::LOGO_RATIO)
    {
        $qrcodeUrl = self::getUrl($input);
        $qrcodeImage = new Image($qrcodeUrl);

        if (! $logoPath) {
            return $qrcodeImage->getBase64();
        } else {
            $logoImage = new Image($logoPath);
            $qrcodeImage->mergeInCenter($logoImage, $ratio);
            $result = $qrcodeImage->getBase64();
            return $result;
        }
    }

    /**
     *
     * Create qrcode html dom data which src is base64 encode data
     * @param array $input
     * @param string $logoPath
     * @param float $ratio
     * @return string
     * @author Tung Ly
     */
    public static function getQrcodeBase64Dom($input, $logoPath = null, $ratio = Qrcode::LOGO_RATIO)
    {
        $qrcodeUrl = self::getUrl($input);
        $qrcodeImage = new Image($qrcodeUrl);
        $src = "data:image/png;base64," ;
        if (! $logoPath) {
            $src .= $qrcodeImage->getBase64();
        } else {
            $logoImage = new Image($logoPath);
            $qrcodeImage->mergeInCenter($logoImage, $ratio);
            $src .= $qrcodeImage->getBase64();
        }

        $html = file_get_contents(QrCode::$config['qrcode::template_simple']);
        $html = str_replace("%%URI_IMG_QRCODE%%", $src, $html);
        return $html;
    }

    /**
     *
     * Create qrcode html dom data
     * @param array $input
     * @return string
     * @author Tung Ly
     */
    public static function getQrcodeDom($input)
    {
        $url = self::getUrl($input);
        $html = file_get_contents(QrCode::$config['qrcode::template_simple']);
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
        $config = QrCode::$config['qrcode::google_config_default'];
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

}