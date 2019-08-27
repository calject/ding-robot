<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019/1/30
 * Annotation:
 */

namespace CalJect\DingRobot\Contacts;


use CalJect\DingRobot\Contacts\PushData\IPushData;

interface IPush
{
    /**
     * push the ding robot message with data
     * @param IPushData $data
     * @return mixed
     */
    public function push(IPushData $data);
    
}