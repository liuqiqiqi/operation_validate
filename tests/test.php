<?php

/*
 * This file is part of the zyan/captcha.
 *
 * (c) 读心印 <aa24615@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

require '../vendor/autoload.php';



use Zyan\Captcha\Captcha;

$captcha = Captcha::make();
//$captcha = Captcha::make(['width' => 150,'height' => 50,'font_size' => 25,'background' => '#eee']);

$captcha->save('code.png');
$code =  $captcha->getCode();

var_dump($captcha->verify($code));
