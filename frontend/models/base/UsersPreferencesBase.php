<?php

namespace app\models\base;

use Yii;
use app\models\PreferenceMaster;
use app\models\Users;

/**
 * This is the model class for table "users_preferences".
*
    * @property integer $id
    * @property integer $user_id
    * @property integer $preference_id
    *
            * @property PreferenceMaster $preference
            * @property Users $user
    */
class UsersPreferencesBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'users_preferences';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['user_id', 'preference_id'], 'integer'],
            [['preference_id'], 'exist', 'skipOnError' => true, 'targetClass' => PreferenceMaster::className(), 'targetAttribute' => ['preference_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => 'ID',
    'user_id' => 'User ID',
    'preference_id' => 'Preference ID',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getPreference()
    {
    return $this->hasOne(PreferenceMaster::className(), ['id' => 'preference_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUser()
    {
    return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}