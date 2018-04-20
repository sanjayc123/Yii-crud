<?php

namespace app\models;

class Users extends \app\models\base\UsersBase
{
    public $password_repeat;
    public $preference_ids;

    /**
	* @inheritdoc
	*/
	public function rules()
	{
        return [
            [['username', 'email', 'password','preference_ids',], 'required', 'on' => ['create'],],
            [['username', 'email', 'preference_ids',], 'required', 'on' => ['update'],],
            [['email', 'password'], 'string', 'max' => 255, 'on' => ['create'],],
			[['email',], 'string', 'max' => 255, 'on' => ['update'],],


            ['username', 'string', 'min' => 3, 'on' => ['create','update'],],
            ['email', 'email', 'on' => ['create','update'],],
            [['username', 'email'], 'unique', 'on' => ['create', 'update'],],
            [['username', 'email'], 'filter', 'filter' => 'trim', 'on' => ['create', 'update'],],
            /*[['username'], 'validateUsername', 'on' => ['update'],],
            [['email'], 'validateEmail', 'on' => ['update'],],*/
            ['password_repeat', 'required', 'on' => ['create'],],
            ['password_repeat', 'compare', 'compareAttribute'=>'password', 'message'=>"Passwords don't match", 'on' => ['create'],],
            [['picture'], 'image', 'extensions' => 'gif, jpg, jpeg, png', 'maxSize' => 1024 * 1024 * 10, 'on' => ['create','update'],], // 10mb
            ['picture', 'image', 'on' => 'create', 'skipOnEmpty' => false],
            ['picture', 'image', 'on' => 'update', 'skipOnEmpty' => true],

            ['preference_ids', 'checkoption', 'on' => ['create','update']],
            /*['preference_ids', function ($attribute, $params) {
            	var_dump($attribute,$params);exit;
		            if(count($this->preference_ids) < 3) {
			            $this->addError($preference_ids, 'Max 3 option allowd.');
			            return false;
			    	}
			}, 'on' => ['create','update']],*/
        ];
	}

	public function checkoption($attribute, $params, $validator)
    {
        if (count($this->$attribute) < 3) {
        	$validator->addError($this, $attribute, 'Min 3 option required.');
            //$this->addError($attribute, 'Min 3 option required.".');
            return false;
        }
    }

    public function validateUsername($attribute, $params, $validator) {
        $ASvalidateusername = Users::find()->where('username = "' . $this->username . '"')->asArray()->all();
        if (!empty($ASvalidateusername)) {
            $validator->addError($this, $attribute, 'This Username has already been taken.');
            return false;
        }
    }

    public function validateEmail($attribute, $params, $validator) {
        $ASvalidateEmail = Users::find()->where('email = "' . $this->email . '"')->all();
        if (!empty($ASvalidateEmail)) {
            $validator->addError($this, $attribute, 'This Email has already been taken.');
            return false;
        }
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
		    'password_repeat' => 'Confirm Password',
		    'preference_ids' => 'Preferences',
		];
	}

    public function getUserPic($id='')
    {
        $user = Users::find()
            ->where(['id' => $id])
            ->one();
        return $user->picture; 
    }
}