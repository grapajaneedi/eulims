<?php

namespace common\models\lab;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\lab\Documentcontrolindex;

/**
 * DocumentcontrolindexSearch represents the model behind the search form of `common\models\lab\Documentcontrolindex`.
 */
class DocumentcontrolindexSearch extends Documentcontrolindex
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['documentcontrolindex_id'], 'integer'],
            [['dcf_no', 'document_code', 'title', 'rev_no', 'effectivity_date', 'dc'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Documentcontrolindex::find();

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
            'documentcontrolindex_id' => $this->documentcontrolindex_id,
            'effectivity_date' => $this->effectivity_date,
        ]);

        $query->andFilterWhere(['like', 'dcf_no', $this->dcf_no])
            ->andFilterWhere(['like', 'document_code', $this->document_code])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'rev_no', $this->rev_no])
            ->andFilterWhere(['like', 'dc', $this->dc]);

        return $dataProvider;
    }
}
