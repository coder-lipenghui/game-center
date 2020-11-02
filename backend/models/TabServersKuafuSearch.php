<?php

namespace backend\models;
use phpDocumentor\Reflection\Types\This;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * TabServersKuafuSearch represents the model behind the search form of `backend\models\TabServersKuafu`.
 */
class TabServersKuafuSearch extends TabServersKuafu
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'versionId', 'gameId', 'index', 'status', 'netPort', 'masterPort', 'contentPort', 'smallDbPort', 'bigDbPort'], 'integer'],
            [['name', 'url'], 'safe'],
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
        $query = TabServersKuafu::find();

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
            'id' => $this->id,
            'versionId' => $this->versionId,
            'gameId' => $this->gameId,
            'index' => $this->index,
            'status' => $this->status,
            'netPort' => $this->netPort,
            'masterPort' => $this->masterPort,
            'contentPort' => $this->contentPort,
            'smallDbPort' => $this->smallDbPort,
            'bigDbPort' => $this->bigDbPort,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'url', $this->url]);

        return $dataProvider;
    }
    public function add($params)
    {
        $kfServer=self::findOne($params['kfServerId']);
        if ($kfServer)
        {
            if(TabServers::updateAll(['kUrl'=>$kfServer->url,'kPort'=>$kfServer->contentPort],['id'=>$params['servers']])>0)
            {
                return json_encode(['code'=>1,'msg'=>'success']);
            }
        }
        return json_encode(['code'=>1,'msg'=>'failed']);
    }
    public function remove($params)
    {
        if(TabServers::updateAll(['kUrl'=>null,'kPort'=>null],['id'=>$params['servers']])>0)
        {
            return json_encode(['code'=>1,'msg'=>'success']);
        }
        return json_encode(['code'=>1,'msg'=>'failed']);
    }
    public function getServers($params)
    {
        $this->load($params);
        $query = TabServers::find();
        if (!empty($this->gameId))
        {
            $query->where(['gameId'=>$this->gameId])->andWhere([
                'OR',
                ['kUrl'=>''],
                ['IS','kUrl',new \yii\db\Expression('NULL')]
            ]);
        }else{
            $query->where('0=1');
        }
        return $query->asArray()->all();
    }
    public function getKfServers($params)
    {
        $this->load($params);
        $query = self::find();
        $data=null;

        $query->select([
            'kId'=>'tab_servers_kuafu.id', //这个地方不能用 'id'=>'tab_servers_kuafu.id'
            'kName'=>'tab_servers_kuafu.name',
            'gameId'=>'tab_servers_kuafu.gameId',
            'kUrl'=>'tab_servers_kuafu.url',
            'sId'=>'tab_servers.id',
            'sName'=>'tab_servers.name',
        ]);

        $query->join("LEFT JOIN","tab_servers",'tab_servers.kUrl=tab_servers_kuafu.url');
        if (!empty($this->gameId))
        {
            $query->where(['tab_servers_kuafu.gameId'=>$this->gameId]);
        }else{
            $query->where('0=1');
        }
        $data=$query->asArray()->all();
        return ArrayHelper::index($data,null,'kId');
    }
}
