<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019/1/30
 * Annotation:
 */

namespace CalJect\DingRobot\Model\MarkDown;


use CalJect\DingRobot\Contacts\MarkDown\AbsMDText;

class MDTextImage extends AbsMDText
{
    
    /**
     * handle the text
     * @param string $url
     * @param array $args
     * @return string
     */
    public function handle(string $url, ... $args): string
    {
        return "![screenshot]($url)";
    }
}