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

/**
 * Class DingRobot
 * @package CalJect\DingRobot\Service
 */
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
     * 机器人access_token
     * @var string
     */
    protected $token;
    
    /**
     * 加签token
     * @var string
     */
    protected $signToken;
    
    /**
     * 保留创建
     * DingRobot constructor.
     * @param string $token
     * @param string $signToken
     */
    public function __construct(string $token, string $signToken = null)
    {
        $this->token = $token;
        $this->signToken = $signToken;
    }
    
    /**
     * 根据token获取机器人实例[保存在静态数组中]
     * @param string $token
     * @param string $signToken
     * @return static
     */
    public static function get(string $token, string $signToken = null)
    {
        return self::$robots[$token] ?? self::$robots[$token] = new static($token, $signToken);
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
        $host = $this->host . '?access_token=' . $this->token;
        if ($this->signToken) {
            $micTime = time(). substr(microtime(), '2', 3);
            $sign = base64_encode(hash_hmac('sha256', $micTime . "\n" . $this->signToken, $this->signToken, true));
            $host .= "&timestamp={$micTime}&sign={$sign}";
        }
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