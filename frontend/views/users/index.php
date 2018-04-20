<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\components\Common;
use yii\helpers\ArrayHelper;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Users', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [  
                'attribute' => 'username',
                'content'   => function ($model)
                {
                    return !empty($model->username) ? $model->username : '---';
                },
                // 'filterOptions'  => ["style" => "width:15%;"],
                // 'headerOptions'  => ["style" => "width:15%;"],
                // 'contentOptions' => ["style" => "width:15%;"],
                // "enableSorting"  => FALSE,
            ],
            [  
                'attribute' => 'preference_ids',
                'content'   => function ($model)
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
                // 'filterOptions'  => ["style" => "width:15%;"],
                // 'headerOptions'  => ["style" => "width:15%;"],
                // 'contentOptions' => ["style" => "width:15%;"],
                "enableSorting"  => FALSE,
                "filter"         => FALSE,
            ],
            'email:email',
            [
                'format'         => 'image',
                'attribute'      => 'picture',
                "enableSorting"  => FALSE,
                "filter"         => FALSE,
                'content'        => function ($model)
                {
                    return Common::getFileFromDatabase($model, Yii::getAlias('@anyname')."\uploads\\", "picture");
                }
            ],

            [
                'header'         => 'Actions',
                'class'          => 'yii\grid\ActionColumn',
                'template'       => '{update} {view} {delete}',
                'buttons'        => [    
                    'delete' => function($url, $model){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->id], [
                            'class' => '',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this user?',
                                'method' => 'post',
                            ],
                        ]);
                    }, 
                ]
            ],
        ],
    ]); ?>

    <?php
        // echo \yii\widgets\LinkPager::widget([
        //     'pagination'=>$dataProvider->pagination,
        // ]);
    ?>
</div>
