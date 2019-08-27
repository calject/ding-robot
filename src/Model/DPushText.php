<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2018/2/6
 * Annotation:
 */

namespace CalJect\DingRobot\Model;

use CalJect\DingRobot\Contacts\PushData\AbsPushDataAt;

class DPushText extends AbsPushDataAt
{

    /**
     * @var string 文本消息
     */
    protected $content = '';


    /**
     * 创建一个消息推送文本
     * @param string $message   推送的消息
     * @return static
     */
    public static function make($message)
    {
        return (new static())->setContent($message);
    }


    /*---------------------------------------------- api ----------------------------------------------*/
    
    /**
     * get the message type
     * @return string
     */
    protected function type(): string
    {
        return 'text';
    }
    
    /**
     * 对应的消息类型内字段数据
     * @return array
     */
    protected function typeData(): array
    {
        return ["content" => $this->content];
    }

    /*---------------------------------------------- getting/setting ----------------------------------------------*/

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return $this
     */
    public function setContent(string $content)
    {
        $this->content = $content;
        return $this;
    }
    
}