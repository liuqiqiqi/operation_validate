<?php


namespace Zyan\Captcha;

class Captcha
{
    /**
     * make.
     * @return Image
     */
    public static function make(array $config = [])
    {
        $img = new Image($config);
        return $img->make();
    }
}
