<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2018/2/7
 * Annotation:
 */

namespace CalJect\DingRobot\Model;


class DPushActionCardList extends AbsDPushActionCard
{

    /**
     * 按钮列表
     * @var array
     */
    protected $btns = [];


    /**
     * 添加跳转按钮
     * @param string $title
     * @param string $actionURL
     * @return $this
     */
    public function appendBtn($title, $actionURL)
    {
        array_push(
            $this->btns,
            [
                "title" => $title,
                "actionURL" => $actionURL,
            ]
        );
        return $this;
    }

    /**
     * @return array
     */
    public function btnsData()
    {
        return [
          "btns" => $this->btns
        ];
    }
}