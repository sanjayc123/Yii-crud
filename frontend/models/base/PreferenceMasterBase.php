<?php

namespace app\models\base;

use Yii;
use app\models\UsersPreferences;

/**
 * This is the model class for table "preference_master".
*
    * @property integer $id
    * @property string $name
    *
            * @property UsersPreferences[] $usersPreferences
    */
class PreferenceMasterBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'preference_master';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => 'ID',
    'name' => 'Name',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUsersPreferences()
    {
    return $this->hasMany(UsersPreferences::className(), ['preference_id' => 'id']);
    }
}