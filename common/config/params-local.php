<?php

Yii::setAlias('@anyname', realpath(dirname(__FILE__).'/../../'));

$ssHost = 'http://'.$_SERVER['HTTP_HOST'].'/yii-advance/';

Yii::setAlias('@common_base', $ssHost.'common/');
Yii::setAlias('@upload_url', $ssHost.'uploads/');
Yii::setAlias('@frontend_base', $ssHost.'frontend/');
Yii::setAlias('@forum_base', $ssHost.'forum/');
//Yii::setAlias('@', $ssHost.'frontend/');
Yii::setAlias('@backend_base', $ssHost.'backend/');
Yii::setAlias('@upload_web', dirname(dirname(__DIR__)) . '/uploads');
Yii::setAlias('@SERVER_FOLDER_NAME', 'yii-advance');

Yii::setAlias('@host', $ssHost);

Yii::setAlias('common', dirname(__DIR__));
Yii::setAlias('frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('app_dir', dirname(dirname(__DIR__)));

Yii::setAlias('backend', dirname(dirname(__DIR__)) . '/backend');

return [
    'site_url'                              => stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true ? 'https://' . $_SERVER['HTTP_HOST'] : 'http://' . $_SERVER['HTTP_HOST'],
    'no_image_path'                         => 'uploads/no_image.jpg',
];