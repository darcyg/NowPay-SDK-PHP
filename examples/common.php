<?php

use BaicProject\NowPaySDK\Baic;

require dirname(__DIR__) . '/vendor/autoload.php';

$sdkId = 'Your sdkId';
$appKey = 'Your appKey';
$baic = new Baic($sdkId, $appKey);