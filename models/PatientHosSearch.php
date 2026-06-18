<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PatientHos;

/**
 * PatientHosSearch represents the model behind the search form of `app\models\PatientHos`.
 */
class PatientHosSearch extends PatientHos {

    public $dx_name;
    public $amp_name;
    public $tmb_name;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'age_y', 'age_m', 'dc'], 'integer'],
            [['pid', 'hoscode', 'hosname', 'hn', 'cid', 'pname', 'fname', 'lname', 'gender', 'birth_date', 'occupat', 'pic', 'prov', 'amp', 'tmb', 'moo', 'street', 'place', 'addr', 'tel', 'family', 'addr_note', 'date_sick', 'date_visit', 'symptom', 'dx', 'date_dx', 'doctor', 'lab', 'discharge_type', 'date_discharge', 'note', 'reporter', 'reporter_position', 'reporter_tel', 'created_at', 'created_by', 'updated_at', 'updated_by', 'accepted_hoscode', 'accepted_at', 'accepted_note', 'accepted_reject_at', 'accepted_reject_note'], 'safe'],
            [['dx_name', 'amp_name', 'tmb_name'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = PatientHos::find()->where(['deleted_at' => null]);
        $query->joinWith(['cdx', 'camp', 'ctmb', 'cmoo', 'coccupat']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    //'accepted_hos' => SORT_ASC,
                    'date_visit' => SORT_DESC,
                ],
            ],
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
            'birth_date' => $this->birth_date,
            'age_y' => $this->age_y,
            'age_m' => $this->age_m,
            'date_sick' => $this->date_sick,
            'date_visit' => $this->date_visit,
            'date_dx' => $this->date_dx,
            'date_discharge' => $this->date_discharge,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'accepted_at' => $this->accepted_at,
            'accepted_hoscode' => $this->accepted_hoscode,
            'accepted_reject_at' => $this->accepted_reject_at,
            'dc' => $this->dc
        ]);

        $query->andFilterWhere(['like', 'pid', $this->pid])
                ->andFilterWhere(['like', 'hoscode', $this->hoscode])
                ->andFilterWhere(['like', 'hosname', $this->hosname])
                ->andFilterWhere(['like', 'hn', $this->hn])
                ->andFilterWhere(['like', 'cid', $this->cid])
                ->andFilterWhere(['like', 'pname', $this->pname])
                ->andFilterWhere(['like', 'fname', $this->fname])
                ->andFilterWhere(['like', 'lname', $this->lname])
                ->andFilterWhere(['like', 'gender', $this->gender])
                ->andFilterWhere(['like', 'occupat', $this->occupat])
                ->andFilterWhere(['like', 'pic', $this->pic])
                ->andFilterWhere(['like', 'prov', $this->prov])
                ->andFilterWhere(['like', 'patient_hos.amp', $this->amp])
                ->andFilterWhere(['like', 'ctmb.name', $this->tmb])
                ->andFilterWhere(['like', 'moo', $this->moo])
                ->andFilterWhere(['like', 'street', $this->street])
                ->andFilterWhere(['like', 'place', $this->place])
                ->andFilterWhere(['like', 'addr', $this->addr])
                ->andFilterWhere(['like', 'tel', $this->tel])
                ->andFilterWhere(['like', 'family', $this->family])
                ->andFilterWhere(['like', 'addr_note', $this->addr_note])
                ->andFilterWhere(['like', 'symptom', $this->symptom])
                ->andFilterWhere(['like', 'dx', $this->dx])
                ->andFilterWhere(['like', 'doctor', $this->doctor])
                ->andFilterWhere(['like', 'lab', $this->lab])
                ->andFilterWhere(['like', 'discharge_type', $this->discharge_type])
                ->andFilterWhere(['like', 'note', $this->note])
                ->andFilterWhere(['like', 'reporter', $this->reporter])
                ->andFilterWhere(['like', 'reporter_position', $this->reporter_position])
                ->andFilterWhere(['like', 'reporter_tel', $this->reporter_tel])
                ->andFilterWhere(['like', 'created_by', $this->created_by])
                ->andFilterWhere(['like', 'updated_by', $this->updated_by])
                ->andFilterWhere(['like', 'accepted_note', $this->accepted_note])
                ->andFilterWhere(['like', 'accepted_reject_note', $this->accepted_reject_note])
                ->andFilterWhere(['like', 'cdx.name', $this->dx_name])
        ;

        return $dataProvider;
    }

}
