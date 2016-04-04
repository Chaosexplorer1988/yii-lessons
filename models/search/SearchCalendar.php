<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Calendar;

/**
 * SearchCalendar represents the model behind the search form about `app\models\Calendar`.
 */
class SearchCalendar extends Calendar
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['text', 'creator', 'date_event'], 'safe'],
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
        $query = Calendar::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $query->joinWith(['access']);
        $dataProvider->sort->attributes['access'] = [
            'asc' => ['table_access.user_owner' => SORT_ASC],
            'desc' => ['table_access.user_owner' => SORT_DESC],
        ];
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->joinWith('userCreator');
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'date_event' => $this->date_event,
           // 'table_access.user_owner' => $this->access['user_owner']
        ]);

        $query->andFilterWhere(['like', 'text', $this->text])
              ->andFilterWhere(['like', 'creator', $this->creator]);

        return $dataProvider;
    }
}
