<?php

namespace frontend\modules\kiosk\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\kiosk\models\TbQuequ;

/**
 * TbQuequSearch represents the model behind the search form about `frontend\modules\kiosk\models\TbQuequ`.
 */
class TbQuequSearch extends TbQuequ
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['q_ids', 'serviceid', 'servicegroupid', 'q_qty', 'q_wt', 'q_issueid', 'q_statusid', 'q_printstationid'], 'integer'],
            [['q_num', 'q_timestp', 'q_ref'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
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
    public function search($params)
    {
        $query = TbQuequ::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'q_ids' => $this->q_ids,
            'serviceid' => $this->serviceid,
            'servicegroupid' => $this->servicegroupid,
            'q_qty' => $this->q_qty,
            'q_wt' => $this->q_wt,
            'q_timestp' => $this->q_timestp,
            'q_issueid' => $this->q_issueid,
            'q_statusid' => $this->q_statusid,
            'q_printstationid' => $this->q_printstationid,
        ]);

        $query->andFilterWhere(['like', 'q_num', $this->q_num])
            ->andFilterWhere(['like', 'q_ref', $this->q_ref]);

        return $dataProvider;
    }
}
