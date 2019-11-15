<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2018/2/7
 * Annotation:
 */

namespace CalJect\DingRobot\Model;



use CalJect\DingRobot\Contacts\PushData\AbsPushData;

class DPushFeedCard extends AbsPushData
{

    /**
     * 消息列表(类似微信公众号推送的卡片消息列表)
     * @var array
     */
    protected $links = [];
    
    /**
     * DPushFeedCard constructor.
     * @param array ...$args
     */
    protected function __construct(... $args)
    {
        $this->init(... $args);
    }
    
    /**
     * @param array ...$args
     * @return void
     */
    protected function init(... $args)
    {
        // TODO: Implement init() method.
    }
    
    /**
     * 获取当前实例
     * @param array ...$args   参数列表
     * @return static
     */
    public static function make(... $args)
    {
        return new static(... $args);
    }


    /**
     * 添加列表子项
     * @param $title
     * @param $messageURL
     * @param string $picURL
     * @return $this
     */
    public function appendLink($title, $messageURL, $picURL = '')
    {
        array_push(
            $this->links,
            [
                "title" => $title,
                "messageURL" => $messageURL,
                "picURL" => $picURL
            ]
        );
        return $this;
    }

    /**
     * get the message type
     * @return string
     */
    protected function type(): string
    {
       return 'feedCard';
    }

    /**
     * 对应的消息类型内字段数据
     * @return array
     */
    protected function typeData(): array
    {
       return [
           "links" => $this->links
       ];
    }
    
}