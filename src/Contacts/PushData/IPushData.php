<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019/1/30
 * Annotation:
 */

namespace CalJect\DingRobot\Contacts\PushData;


interface IPushData
{
    /**
     * get push data
     * @return array
     */
    public function getData(): array;
    
}