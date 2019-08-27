<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2018/2/7
 * Annotation:
 */

namespace CalJect\DingRobot\Model;


class DPushActionCardOne extends AbsDPushActionCard
{

    /**
     * 单个按钮的方案。(设置此项和singleURL后btns无效。)
     * @var string
     */
    protected $singleTitle = '';
    /**
     * 点击singleTitle按钮触发的URL
     * @var string
     */
    protected $singleURL = '';




    /**
     * @param string $singleTitle
     * @return $this
     */
    public function setSingleTitle($singleTitle)
    {
        $this->singleTitle = $singleTitle;
        return $this;
    }

    /**
     * @param string $singleURL
     * @return $this
     */
    public function setSingleURL($singleURL)
    {
        $this->singleURL = $singleURL;
        return $this;
    }

    /**
     * 获取消息跳转列表
     * @return array
     */
    public function btnsData()
    {
        return [
            'singleTitle' => $this->singleTitle,
            'singleURL' => $this->singleURL
        ];
    }


}