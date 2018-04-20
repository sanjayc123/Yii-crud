<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Users;

/**
 * UsersSearch represents the model behind the search form of `app\models\Users`.
 */
class UsersSearch extends Users
{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['preference_ids', 'username', 'email', 'password', 'picture',], 'safe'],
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Users::find();
        $query = Users::find()
            ->orderBy(['id' => SORT_DESC]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,  
            'pagination' => array('pageSize' => 5),          
        ]);

        // No search? Then return data Provider
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}
