<?php

namespace common\components;

use app\models\Users;
use Yii;
use yii\helpers\Html;

class Common   
{
    public static function deleteImage($ssImagePath = "")
    {

        if (!empty($ssImagePath))
        {
            if (is_file($ssImagePath))
            {
                unlink($ssImagePath);
            }
        }
    }

    public static function getFileFromDatabase($omModel, $ssUploadPath, $ssAttributeName = "image_name", $bOnlyUrl = 0, $bNoImg = 1)
    {
        $ssNoImgUrl        = Yii::getAlias('@host') . '/' . Yii::$app->params['no_image_path'];
        $strAttributeValue = is_array($omModel) ? $omModel["$ssAttributeName"] : $omModel->$ssAttributeName;

        if (empty($strAttributeValue))
        {            
            if ($bOnlyUrl)
            {
                return $ssNoImgUrl;
            }
            return Html::img($ssNoImgUrl, ["width" => 100, "height" => 100]);
        }

        if (is_file($ssUploadPath . $strAttributeValue))
        {
            $ssParentDirPath = dirname($ssUploadPath);
            $ssChildDriName  = basename($ssUploadPath);
            $ssParentDirName = basename($ssParentDirPath);
            //$ssImageUrl      = Url::base(TRUE) . "/../../$ssParentDirName/$ssChildDriName/{$strAttributeValue}";
            //$ssImageUrl      = Yii::getAlias('@host') . '/' . "$ssParentDirName/$ssChildDriName/" . $strAttributeValue;
            $ssImageUrl      = Yii::getAlias('@host') . '/' . "$ssChildDriName/" . $strAttributeValue;
            $omImg = Html::img($ssImageUrl, ["width" => 100, "height" => 100]);
            
            if ($bOnlyUrl != 0)
            {
                return $ssImageUrl;
            }
            return Html::a($omImg, $ssImageUrl, ["target" => "_blank"]);
        }
        if ($bOnlyUrl != 0)
        {
            if (!$bNoImg)
            {
                return FALSE;
            }
            return $ssNoImgUrl;
        }
        //SHOW NO IMAGE
        return Html::img($ssNoImgUrl, ["width" => 100, "height" => 100]);        
    }
}