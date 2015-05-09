<?php

namespace Vcode\Qrcode\Facades;

use Illuminate\Support\Facades\Facade;

class QrcodeFacade extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     * @author Tung Ly
     */
    protected static function getFacadeAccessor()
    {
        return 'qrcode';
    }
}