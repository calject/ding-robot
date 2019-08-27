<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019/1/30
 * Annotation:
 */

namespace CalJect\DingRobot\Model\MarkDown;


use CalJect\DingRobot\Contacts\MarkDown\AbsMDText;

class MDTextHyperlink extends AbsMDText
{
    /**
     * handle the text
     * @param string $text
     * @param array $args
     * @return string
     */
    public function handle(string $text, ... $args): string
    {
        return isset($args[0]) ? "[$text]({$args[0]})" : $text;
    }
}