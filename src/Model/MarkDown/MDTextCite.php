<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019/1/30
 * Annotation:
 */

namespace CalJect\DingRobot\Model\MarkDown;


use CalJect\DingRobot\Contacts\MarkDown\AbsMDText;

class MDTextCite extends AbsMDText
{
    
    /**
     * handle the text
     * @param string $text
     * @param array $args
     * @return string
     */
    public function handle(string $text, ... $args): string
    {
        return '> ' . $text . self::NEXT_LINE;
    }
}