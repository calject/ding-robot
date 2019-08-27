<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2018/2/7
 * Annotation:
 */

namespace CalJect\DingRobot\Model;


abstract class AbsDPushActionCard extends DPushMD
{

    /*---------------------------------------------- const ----------------------------------------------*/
    /**
     * 显示正常发消息者头像
     */
    const AVATAR_SHOW = '0';
    /**
     * 隐藏发消息者头像
     */
    const AVATAR_HIDE = '1';
    /**
     * 按钮横向排列
     */
    const BTN_ORIENTATION_HORIZONTAL = 1;
    /**
     * 按钮竖向排列
     */
    const BTN_ORIENTATION_VERTICAL = 0;


    /*---------------------------------------------- attributes ----------------------------------------------*/


    /**
     * 0-正常发消息者头像,1-隐藏发消息者头像
     * @var string
     */
    protected $hideAvatar = self::AVATAR_SHOW;
    /**
     * 0-按钮竖直排列，1-按钮横向排列
     * @var string
     */
    protected $btnOrientation = self::BTN_ORIENTATION_VERTICAL;



    /*---------------------------------------------- extends ----------------------------------------------*/

    /**
     * @return string
     */
    protected function type(): string
    {
        return 'actionCard';
    }

    /**
     * 对应的消息类型内字段数据
     * @return array
     */
    protected function typeData(): array
    {
        return array_merge(
            [
                'title' => $this->brief,
                'text' => $this->text,
                'hideAvatar' => $this->hideAvatar,
                'btnOrientation' => $this->btnOrientation
            ],
            $this->btnsData()
        );
    }


    /*---------------------------------------------- abstract ----------------------------------------------*/

    /**
     * 获取消息跳转列表
     * @return array
     */
    abstract public function btnsData();

    /*---------------------------------------------- set ----------------------------------------------*/

    /**
     * @param string $hideAvatar
     * @return $this
     */
    public function setHideAvatar($hideAvatar)
    {
        $this->hideAvatar = $hideAvatar;
        return $this;
    }

    /**
     * @param string $btnOrientation
     * @return $this
     */
    public function setBtnOrientation($btnOrientation)
    {
        $this->btnOrientation = $btnOrientation;
        return $this;
    }


}