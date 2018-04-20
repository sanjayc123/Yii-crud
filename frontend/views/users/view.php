<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\Common;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title                   = 'View user : ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Manage Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'View';
?>
<div class="users-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'username',
            'email:email',
            [  
                'attribute' => 'preference_ids',
                'value'   => function ($model)
                {
                    if (!empty($model->usersPreferences)) {
                        $amData = [];
                        foreach ($model->usersPreferences as $key => $value) {
                            $amData[] = $value->preference->name;
                        }
                        if (!empty($amData)) {
                            return implode(',',$amData);
                        }
                    }
                    return '---';
                },
            ],
            [
                'attribute' =>'picture',
                'value'     => Common::getFileFromDatabase($model, Yii::getAlias('@anyname')."\uploads\\", "picture", $bOnlyUrl= 1),
                'format'    => 'image',
            ],            
        ],
    ]) ?>

</div>
