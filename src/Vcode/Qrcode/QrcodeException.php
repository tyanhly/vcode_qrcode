<?php
namespace Vcode\Qrcode;

/**
 * @author Tung Ly
 */
class QrcodeException extends \Exception
{

    const DONT_HAVE_CHL_ERROR = 0x001;

    const CANNOT_CREATE_STORAGE_DIR_ERROR = 0x002;

    const PARAM_NOT_STRING_OR_ARRAY_ERROR = 0x003;

    const CANNOT_INIT_IMAGE = 0x004;

    const CANNOT_CREATE_TMP_IMAGE = 0x005;

    const QRCODE_INIT_ERROR = 0x006;

    const QRCODE_CANNOT_COPY = 0x007;

    const IMAGE_EXTENSION_NOT_SUPPORT = 0x101;

    const DONT_KNOW_ERROR = 0xFFF;

    /**
     * Error Messages
     *
     * @var array $msg
     */
    public static $msgs = array(
        self::DONT_HAVE_CHL_ERROR => 'DONT_HAVE_CHL_ERROR',
        self::PARAM_NOT_STRING_OR_ARRAY_ERROR => 'PARAM_NOT_STRING_OR_ARRAY_ERROR',
        self::CANNOT_CREATE_STORAGE_DIR_ERROR => 'CANNOT_CREATE_STORAGE_DIR_ERROR',
        self::CANNOT_INIT_IMAGE => 'CANNOT_INIT_IMAGE',
        self::CANNOT_CREATE_TMP_IMAGE => 'CANNOT_CREATE_TMP_IMAGE',
        self::QRCODE_INIT_ERROR => 'CANNOT_CREATE_TMP_IMAGE',
        self::QRCODE_CANNOT_COPY => 'QRCODE_CANNOT_COPY',

        self::IMAGE_EXTENSION_NOT_SUPPORT => 'IMAGE_EXTENSION_NOT_SUPPORT',

        self::DONT_KNOW_ERROR => 'APP_DONT_KNOW_ERROR'
    );

    /**
     * get Message from code
     *
     * @param number $code
     * @return string
     * @author Tung Ly
     */
    public static function getMsg($code)
    {
        if (array_key_exists($code, self::$msgs)) {
            return self::$msgs[$code];
        } else {
            return self::$msgs[self::DONT_KNOW_ERROR];
        }
    }

    /**
     *
     * @param number $code
     * @author Tung Ly
     */
    public function QrcodeException($code)
    {
        parent::__construct(CartException::getMsg($code), $code);
    }
}