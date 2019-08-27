<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019/1/30
 * Annotation:
 */

namespace CalJect\DingRobot\Contacts\MarkDown;


interface IMDText
{
    /**
     * get the md text
     * @return string
     */
    public function text(): string;
    
}