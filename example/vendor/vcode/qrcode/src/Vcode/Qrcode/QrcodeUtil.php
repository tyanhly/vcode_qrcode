<?php

namespace Vcode\Qrcode;

/**
 * Util functions
 * @author Tung Ly
 */
class QrcodeUtil
{
    /**
     * @param unknown $path
     * @param number $mod
     * @param string $recusive
     * @throws QrcodeException
     * @author Tung Ly
     */
    public static function mkdir($path, $mod = 0755, $recusive = true){
        if(!is_dir($path) && !mkdir($path, $mod, $recusive)){
            throw new QrcodeException(QrcodeException::CANNOT_CREATE_STORAGE_DIR_ERROR);
        }
    }
}