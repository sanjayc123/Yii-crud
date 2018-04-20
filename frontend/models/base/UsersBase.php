<?php

namespace app\models\base;

use Yii;
use app\models\UsersPreferences;

/**
 * This is the model class for table "users".
*
    * @property integer $id
    * @property string $username
    * @property string $email
    * @property string $password
    * @property string $picture
    *
            * @property UsersPreferences[] $usersPreferences
    */
class UsersBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'users';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['username', 'email', 'password', 'picture'], 'required'],
            [['username', 'email', 'password', 'picture'], 'string', 'max' => 255],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => 'ID',
    'username' => 'Username',
    'email' => 'Email',
    'password' => 'Password',
    'picture' => 'Picture',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUsersPreferences()
    {
    return $this->hasMany(UsersPreferences::className(), ['user_id' => 'id']);
    }
}