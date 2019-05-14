<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-04-25
 * Time: 10:00
 */

namespace backend\models\command;

use yii\base\Model;

/**
 * Class CommandInterface
 * 基础的CMD类，执行周期：
 * buildCommand->buildServers->socket
 * 先在派生类中生成具体的GM命令，然后提供区服列表（需要包含ip，端口，名称）然后遍历区服列表执行GM命令
 * command list:
 * kick 踢下线
 * frvc 通知游戏刷新订单以给玩家进行发货
 * addnotice 发送一条公告
 * remnotice 0 移除一条公告
 * remgm 移除gm
 *
 * @package backend\models\api
 * @TODO 目前的socket在connect连接不通的时候
 */
class BaseCmd extends Model
{
    public static $ERROR_CONNECT_FAILED="connect_failed";
    public static $ERROR_CREATE_FAILED="create_failed";
    public static $ERROR_SEND_FAILDE="send_failed";

    public $command;    //发往游戏服务器的命令
    public $name;       //命令名称

    public $params=[]; //参数列表 以空格拼接


    public $serverList=[];
    public $result=[];

    public function rules()
    {
        return [
            [['name'],'required'],
            [['name'],'string'],
        ];
    }

    /**
     * 执行命令
     * @return array
     */
    public function execu()
    {
        $this->result=[];
        $this->buildCommand();
        $this->buildServers();
        echo("开始对".count($this->serverList)."个区服执行CMD命令");
        for ($i=0;$i<count($this->serverList);$i++)
        {
            $server=$this->serverList[$i];
            try{
                $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
                //3秒发送超时
                socket_set_option($socket,SOL_SOCKET,SO_RCVTIMEO,array("sec"=>3, "usec"=>0 ) );
                //5秒接收超时
                socket_set_option($socket,SOL_SOCKET,SO_SNDTIMEO,array("sec"=>5, "usec"=>0 ) );
                if (!$socket) {
                    $this->result[]=['name'=>$server['name'],'code'=>'-1','msg'=>'socket创建失败'];
                    continue;
                }
                if (!socket_connect($socket, $server['ip'], $server['port'])) {
                    $this->result[]=['name'=>$server['name'],'code'=>'-2','msg'=>'链接失败'];
                    continue;
                }
                $in = md5($this->command.$server['secretKey']).$this->command."\n";
                if (!socket_write($socket, $in, strlen($in))) {
                    $this->result[]=['name'=>$server['name'],'code'=>'-3','msg'=>'命令发送失败'];
                    continue;
                }
                $msg=trim(socket_read($socket, 1024));
                $this->result[]=['name'=>$server['name'],'code'=>'1','msg'=>'执行成功'];
                socket_close($socket);
            }catch (\Exception $e)
            {
                $this->result[]=['name'=>$server['name'],'code'=>'-3','msg'=>'出现异常'];
                continue;
            }
        }
        return $this->result;
    }

    /**
     * 按照" "生成命令
     * 必须在派生类中实现
     */
    public function buildCommand()
    {

    }

    /**
     * 必须实现
     * 在派生类中构建区服列表 参数需求：
     *      [name=>'区服名称',ip=>'区服IP/URL','port'=>'执行命令的端口','secretKey'=>'服务器KEY']
     */
    public function buildServers()
    {
    }
}