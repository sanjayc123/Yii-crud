<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\components\Common;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form yii\widgets\ActiveForm */

$listData = ArrayHelper::map($preferences,'id','name');
?>

<div class="users-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    
    <?php 
        if ($model->isNewRecord) {
            echo $form->field($model, 'password')->passwordInput(['maxlength' => true]);    
            echo $form->field($model, 'password_repeat')->passwordInput(['maxlength' => true]);
        }
    ?>

    <?php
         if(!$model->isNewRecord) {
            $model->preference_ids = $amSelected;
         }

    ?>
	
    <?= $form->field($model, 'preference_ids')->checkboxList($listData);?>

    <?php 
        if (!$model->isNewRecord) {
            if (empty($model->picture)) {
                $model->picture = $model->getUserPic($model->id);
            }
            echo Common::getFileFromDatabase($model, Yii::getAlias('@anyname')."\uploads\\", "picture");
        }
    ?>

    <?= $form->field($model, 'picture')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
