<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019/1/30
 * Annotation:
 */

namespace CalJect\DingRobot\Service;


use CalJect\DingRobot\Contacts\IPush;
use CalJect\DingRobot\Contacts\PushData\IPushData;

class DingRobot implements IPush
{
    /**
     * @var DingRobot[]
     */
    private static $robots = [];
    
    /**
     * @var string
     */
    protected $host = 'https://oapi.dingtalk.com/robot/send';
    
    /**
     * @var string
     */
    protected $token;
    
    /**
     * DingRobot constructor.
     * @param string $token
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }
    
    /**
     * 根据token获取机器人实例
     * @param $token
     * @return static
     */
    public static function get($token)
    {
        if (!($instance = &self::$robots[$token])) {
            $instance = new static($token);
        }
        return $instance;
    }
    
    /**
     * setting push host
     * @param string $host
     * @return $this
     */
    public function to($host)
    {
        $this->host = $host;
        return $this;
    }
    
    /**
     * setting push token
     * @param string $token
     * @return $this
     */
    public function token($token)
    {
        $this->token = $token;
        return $this;
    }
    
    /**
     * @param IPushData $data 推送的消息
     * @return mixed
     */
    public function push(IPushData $data)
    {
        $host = $this->host.'?access_token='.$this->token;
        $push_data = json_encode($data->getData(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        return $this->request($host, $push_data);
    }
    
    /**
     * curl request
     * @param $remote_server
     * @param $post_string
     * @return mixed
     */
    protected function request($remote_server, $post_string)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $remote_server);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json;charset=utf-8']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
}