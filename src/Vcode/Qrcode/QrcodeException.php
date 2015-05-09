<?php

namespace Vcode\Qrcode;

class QrcodeException extends \Exception
{

    const DONT_KNOW_ERROR = 0xFFF;

    const DONT_HAVE_CHL_ERROR = 0x001;

    const PARAM_NOT_STRING_OR_ARRAY_ERROR = 0x002;

    /**
     * Error Messages
     * 
     * @var array $msg
     */
    public static $msgs = array(
        self::DONT_KNOW_ERROR => 'APP_DONT_KNOW_ERROR',
        self::DONT_HAVE_CHL_ERROR => 'DONT_HAVE_CHL_ERROR',
        self::PARAM_NOT_STRING_OR_ARRAY_ERROR => 'PARAM_NOT_STRING_OR_ARRAY_ERROR'
    );

    /**
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