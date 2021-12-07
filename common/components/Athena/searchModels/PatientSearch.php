<?php

namespace common\components\Athena\searchModels;

use yii\data\ActiveDataProvider;
use common\components\Athena\models\Patient;

class PatientSearch extends Patient
{
    //public $_firstname;
    //public $_lastname;
    //public $_dob;

    public function rules()
    {
        return [
            [['firstname','lastname','dob'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Patient::find();//->innerJoinWith('groups', true);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['attributes' => ['firstname', 'lastname', 'dob', 'email']]
        ]);

        $this->load($params);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'sex' => $this->sex,
            'status' => $this->status,
            'dob' => $this->dob,
        ]);

        $query->andFilterWhere(['like', 'lower(firstname)', $this->firstname])
                ->andFilterWhere(['like', 'lower(lastname)', $this->lastname])
                ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}