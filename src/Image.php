<?php

namespace Zyan\Captcha;

use Intervention\Image\ImageManagerStatic;
use think\facade\Cache;

class Image
{

    /**
     * @var array
     */

    protected $config = [
        'width' => 108,
        'height' => 38,
        'background' => '#eee',
        'font_size' => 20,
        'identification' => 0,
    ];

    /**
     */
    protected $img = null;

    /**
     * @var int
     */
    protected $code = 0;


    /**
     * @var int
     */
    protected $identification = 0;


    /**
     * Captcha constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->setConfig($config);
    }

    /**
     * setConfig.
     *
     * @param array $config
     *
     * @return void
     *
     */

    public function setConfig(array $config)
    {
        $this->config = array_merge($this->config, $config);
    }

    /**
     * make.
     *
     * @return self
     *
     */
    public function make()
    {
        $width = $this->config['width'];
        $height = $this->config['height'];
        $background = $this->config['background'];
        $font_size = $this->config['font_size'];
        $identification = $this->config['identification'];

        $img = ImageManagerStatic::canvas($width, $height, $background);

        $h = rand(0, 2);
        $c = rand(1, 9);
        $a = rand(1, 9);
        $b = ['+', '-', '×'][$h];
        $d = "=";
        $e = "?";
        $z = 0;
        switch ($h) {
            case 0:
                $z = $a + $c;
                break;
            case 1:
                $z = $a - $c;
                if ($a < $c) {
                    $b = '×';
                    $z = $a * $c;
                }
                break;
            case 2:
                $z = $a * $c;
                break;
            default:
                $z = 0;
                break;
        }

        $y = $height / 2 + ($font_size / 2.5);
        $x = $width / 5 - ($font_size / 5);

        $img->text($a, $x * 1, $y, function ($font) use ($font_size) {
            $font->file(__DIR__ . '/fonts/SourceHanSansOLD-Normal-2.otf');
            $font->size($font_size);
            $font->color('#000');
            $font->angle(0);
        });

        $img->text($b, $x * 2, $y, function ($font) use ($font_size) {
            $font->file(__DIR__ . '/fonts/SourceHanSansOLD-Normal-2.otf');
            $font->size($font_size);
            $font->color('#000');
            $font->angle(0);
        });

        $img->text($c, $x * 3, $y, function ($font) use ($font_size) {
            $font->file(__DIR__ . '/fonts/SourceHanSansOLD-Normal-2.otf');
            $font->size($font_size);
            $font->color('#000');
            $font->angle(0);
        });

        $img->text($d, $x * 4, $y, function ($font) use ($font_size) {
            $font->file(__DIR__ . '/fonts/SourceHanSansOLD-Normal-2.otf');
            $font->size($font_size);
            $font->color('#000');
            $font->angle(0);
        });

        $img->text($e, $x * 5, $y, function ($font) use ($font_size) {
            $font->file(__DIR__ . '/fonts/SourceHanSansOLD-Normal-2.otf');
            $font->size($font_size);
            $font->color('#f00');
            $font->angle(0);
        });


        $this->img = $img;
        $this->code = $z;
        $this->identification = $identification;


        $this->set_operation_validate_code();

        return $this;
    }

    /**
     * sessoin.
     *
     * @return void
     *
     */

    private function set_operation_validate_code()
    {
        Cache::set('operation_validate_code'.$this->identification, $this->code, 300);
    }


    /**
     * save.
     *
     * @param string $filename
     *
     * @return \Intervention\Image\Image
     *
     */
    public function save(string $filename)
    {
        return $this->img->save($filename);
    }

    /**
     * getCode.
     *
     * @return int
     *
     */

    public function getCode()
    {
        return $this->code;
    }


    /**
     * @return int
     */
    public function getIdentification()
    {
        return $this->identification;
    }

    /**
     * verify.
     *
     * @param int $code
     *
     * @return boolean
     *
     */

    public function verify(int $code,int $identification)
    {
        if (!Cache::get('operation_validate_code'.$identification)) {
            return false;
        }
        if (Cache::get('operation_validate_code'.$identification) == $code) {
            Cache::delete('operation_validate_code'.$identification) ;
            return true;
        } else {
            return false;
        }
    }
}
