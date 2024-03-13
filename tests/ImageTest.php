<?php

/*
 * This file is part of the zyan/captcha.
 *
 * (c) 读心印 <aa24615@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Zyan\Tests;


use PHPUnit\Framework\TestCase;
use Zyan\Captcha\Image;

/**
 * Class ImageTest.
 *
 * @package Zyan\Tests
 *
 * @author 读心印 <aa24615@qq.com>
 */
class ImageTest extends TestCase
{

    public function testVerifyFalse(){
        $img = new Image();

        $img->setConfig(['session'=>false]);

        $m  = $img->make();
        $code = $m->getCode();

        $this->assertTrue(!$m->verify($code));
    }

    public function testVerifyTrue(){
        $img = new Image();

        $img->setConfig(['session'=>true]);

        $m  = $img->make();
        $code = $m->getCode();

        $this->assertTrue($m->verify($code));
    }

    public function testSave(){
        $img = new Image();
        $m  = $img->make();
        @unlink('tests/test.png');
        $m->save('tests/test.png');
        $this->assertTrue(file_exists('tests/test.png'));
    }

}