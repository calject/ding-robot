<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2018/2/7
 * Annotation:
 */

namespace CalJect\DingRobot\Model;



use CalJect\DingRobot\Contacts\PushData\AbsPushData;

class DPushLink extends AbsPushData
{

    /*---------------------------------------------- attributes ----------------------------------------------*/

    protected $text = '';
    protected $title = '';
    protected $messageUrl = '';
    protected $picUrl = '';

    /**
     * 创建当前消息实例
     * @param string $title         标题
     * @param string $text          内容简介
     * @param string $messageUrl    跳转url
     * @param string $picUrl        显示图片url
     * @return static
     */
    public static function make($title, $text, $messageUrl = '', $picUrl = '')
    {
        return (new static())
            ->setTitle($title)
            ->setText($text)
            ->setMessageUrl($messageUrl)
            ->setPicUrl($picUrl);
    }


    /**
     * get the message type
     * @return string
     */
    protected function type(): string
    {
        return "link";
    }

    /**
     * 对应的消息类型内字段数据
     * @return array
     */
    protected function typeData(): array
    {
        return [
            "text" => $this->text,
            "title" => $this->title,
            "picUrl" => $this->picUrl,
            "messageUrl" => $this->messageUrl,
        ];
    }


    /**
     * @param string $text
     * @return $this
     */
    public function setText(string $text)
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param string $picUrl
     * @return $this
     */
    public function setPicUrl(string $picUrl)
    {
        $this->picUrl = $picUrl;
        return $this;
    }

    /**
     * @param string $messageUrl
     * @return $this
     */
    public function setMessageUrl(string $messageUrl)
    {
        $this->messageUrl = $messageUrl;
        return $this;
    }

}