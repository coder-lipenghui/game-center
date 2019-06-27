<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-06-24
 * Time: 11:42
 */

namespace backend\models;
use mdm\admin\components\Configs;
use yii\helpers\ArrayHelper;

class MyUserModel extends User
{
    public $role;
    public $distributions;
    public $games;
    public $support;
    public function rules()
    {
        return [
            [['username', 'password_hash', 'email','role','distributions','games'], 'required'],
            [['support'],'integer'],
            [['role'],'string'],
            [['username', 'password_hash', 'password_reset_token', 'email', 'verification_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
        ];
    }
    public function attributeLabels()
    {
        $myAttributeLabels=[
            'support'=>\Yii::t('app',"扶持权限"),
            'role'=>\Yii::t('app','账号类型'),
            'distributions'=>\Yii::t('app','分销渠道'),
            'games'=>\Yii::t('app','游戏列表'),
        ];
        return array_merge(parent::attributeLabels(),$myAttributeLabels);
    }

    /**
     * 新增用户
     * @param $params
     * @return bool
     * @throws \yii\base\Exception
     */
    public function createUser($params)
    {
        $this->load($params);
        if ($this->validate())
        {
            $this->created_at=time();
            $this->updated_at=time();
            $this->password_hash=\Yii::$app->security->generatePasswordHash($this->password_hash);
            $this->auth_key=\Yii::$app->security->generateRandomString();
            $this->password_reset_token=\Yii::$app->security->generateRandomString();
            if ($this->save())
            {
                $this->assignRole($this->role,$this->id);
                $this->assignPermission();
            }
            return true;
        }
        return false;
    }
    /**
     * 修改用户信息
     */
    public function updateUser($params)
    {
        $this->load($params);
        if ($this->validate())
        {
            $model=self::findModel($this->id);
            if ($model && ($model->role!=$this->role || $model->distributions!=$this->distributions || $model->support!=$this->support || $model->games!=$this->games))
            {
                if ($model->password_hash!=$this->password_hash)
                {
                    $model->password_hash=\Yii::$app->security->generatePasswordHash($this->password_hash);
                }
                $model->updated_at=time();
                $model->save();

                //后台角色
                $this->revokeRole();
                $this->assignRole($this->role,$this->id);

                //后台权限
                $this->revokePermission();
                $this->assignPermission();

                return true;
            }
        }
        return false;
    }

    /**
     * 根据uid获取用户model，同时获取用户的角色、后台权限信息
     * @param $id
     * @return MyUserModel|null
     */
    public static function findModel($id)
    {
        $model=self::findOne($id);
        //获取角色
        $role=Configs::authManager()->getRolesByUser($id);
        foreach ($role as $k=>$v)
        {
            if ($k!="guest")
            {
                $model->role=$k;
                break;
            }
        }
        //获取游戏、分销渠道、扶持权限信息
        $permission=TabPermission::find()->where(['uid'=>$id])->asArray()->all();
        $model->games=ArrayHelper::getColumn($permission,'gameId');
        $model->distributions=ArrayHelper::getColumn($permission,'distributionId');
        return $model;
    }

    /**
     * 清空用户的游戏、渠道、扶持权限
     */
    private function revokePermission()
    {
        TabPermission::deleteAll(['uid'=>$this->id]);
    }
    /**
     * 清空用户所属角色
     */
    private function revokeRole()
    {
        $roles=Configs::authManager()->getRolesByUser($this->id);
        foreach ($roles as $k=>$v)
        {
            if ($k!="guest")
            {
                $role=Configs::authManager()->getRole($k);
                Configs::authManager()->revoke($role,$this->id);
            }
        }
    }
    /**
     * 为用户分配角色
     * @param $role
     * @param $id
     * @throws \Exception
     */
    private function assignRole($role,$id)
    {
        $manager = Configs::authManager();
        $tempRole=Configs::authManager()->getRole($role);
        $manager->assign($tempRole,$id);
    }

    /**
     * 为用户分配游戏、分销渠道、扶持权限
     */
    private function assignPermission()
    {
        for ( $i=0;$i<count($this->distributions);$i++)
        {
            $distribution=TabDistribution::find()->where(['id'=>$this->distributions[$i]])->one();
            if ($distribution)
            {
                $permission=new TabPermission();
                $permission->uid=$this->id;
                $permission->gameId=$distribution->gameId;
                $permission->distributorId=$distribution->distributorId;
                $permission->distributionId=$distribution->id;
                $permission->support=$this->support?1:0;
                $permission->save();
            }
        }
    }
}