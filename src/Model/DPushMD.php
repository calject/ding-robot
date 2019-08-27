<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2018/2/7
 * Annotation:
 */

namespace CalJect\DingRobot\Model;

use CalJect\DingRobot\Contacts\MarkDown\IMDText;
use CalJect\DingRobot\Contacts\PushData\AbsPushDataAt;
use CalJect\DingRobot\Model\MarkDown\MDTextCite;
use CalJect\DingRobot\Model\MarkDown\MDTextHyperlink;
use CalJect\DingRobot\Model\MarkDown\MDTextImage;
use CalJect\DingRobot\Model\MarkDown\MDTextLn;
use CalJect\DingRobot\Model\MarkDown\MDTextTitle;

class DPushMD extends AbsPushDataAt
{
    
    const NEXT_LINE = "\n";
    const NEXT_LINE_DOUBLE = "\n\n";
    
    /**
     * 简略标题
     * @var string
     */
    protected $brief = '';
    
    /**
     * 文本内容
     * @var string
     */
    protected $text = '';
    
    
    /**
     * make markdown instance
     * @param string $brief         简略标题
     * @param bool $isAppendInText  是否设置为内容标题
     * @return static
     */
    public static function make($brief = '', bool $isAppendInText = false)
    {
        $instance = new static();
        $instance->setBrief($brief);
        $isAppendInText && $instance->appendTitle($brief);
        return $instance;
    }
    
    /*---------------------------------------------- markdown append ----------------------------------------------*/
    
    /**
     * @param string $brief
     * @return $this
     */
    public function setBrief(string $brief)
    {
        $this->brief = $brief;
        return $this;
    }
    
    /**
     * append text [xxxx]
     * @param string|IMDText $text
     * @param bool $next_line
     * @return $this
     */
    public function appendText($text, $next_line = false)
    {
        $this->text .= ($text instanceof IMDText) ? $text->text() : $text;
        $next_line && ($this->text .= self::NEXT_LINE_DOUBLE);
        return $this;
    }
    
    /**
     * append text next line [ xxxx \n]
     * @param string|IMDText $text
     * @return DPushMD
     */
    public function appendTextLn($text)
    {
        return $this->appendText(MDTextLn::make($text));
    }
    
    /**
     * append text title [## xxxx]
     * @param $title
     * @param $hierarchy
     * @return $this
     */
    public function appendTitle($title, $hierarchy = 1)
    {
        return $this->appendText(MDTextTitle::make($title, $hierarchy));
    }
    
    /**
     * append text cite [> xxxx]
     * @param string|IMDText $text
     * @return DPushMD
     */
    public function appendCite($text)
    {
        return $this->appendText(MDTextCite::make($text));
    }
    
    /**
     * append items disorder [- xxxx  - xxxx  - xxxx]
     * @param mixed $items
     * @return DPushMD
     */
    public function appendItemsDisorder($items)
    {
        $items = is_array($items) ? $items : func_get_args();
        $item_str = '';
        foreach ($items as $item) {
            $item_str .= '- ' . $item . self::NEXT_LINE_DOUBLE;
        }
        return $this->appendText($item_str);
    }
    
    /**
     * append items orderly [1. xxxx  2. xxxx  3. xxxx]
     * @param mixed $items
     * @return DPushMD
     */
    public function appendItemsOrderly($items)
    {
        $items = is_array($items) ? $items : func_get_args();
        $item_str = '';
        foreach ($items as $index => $item) {
            $item_str .= ($index + 1) . '. ' . $item . self::NEXT_LINE_DOUBLE;
        }
        return $this->appendText($item_str);
    }
    
    /**
     * next line
     * @param int $num
     * @return $this
     */
    public function nextLine($num = 1)
    {
        $this->text .= str_repeat(self::NEXT_LINE_DOUBLE, $num);
        return $this;
    }
    
    /**
     * append the image
     * @param string $url
     * @param bool $next_line
     * @return $this
     */
    public function appendImage($url, $next_line = true)
    {
        $this->appendText(MDTextImage::make($url)) && $next_line && $this->nextLine();
        return $this;
    }
    
    /**
     * append the hyperlink text
     * @param string $text
     * @param string $url
     * @param bool $next_line
     * @return $this
     */
    public function appendHyperlink($text, $url, $next_line = false)
    {
        $this->appendText(MDTextHyperlink::make($text, $url)) && $next_line && $this->nextLine();
        return $this;
    }
    
    /**
     * append date
     * @return DPushMD
     */
    public function appendDateCite()
    {
        return $this->appendCite('date: ' . date('Y-m-d H:i:s'));
    }
    
    /*---------------------------------------------- implodes ----------------------------------------------*/
    
    /**
     * get the message type
     * @return string
     */
    protected function type(): string
    {
        return 'markdown';
    }
    
    /**
     *  get the message type data
     * @return array
     */
    protected function typeData(): array
    {
        $this->appendText($this->getAtText());
        return ["title" => $this->brief, "text" => $this->text];
    }
    
}