<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019/1/31
 * Annotation:
 */

namespace CalJect\DingRobot\Model\Customs;


use CalJect\DingRobot\Contacts\PushData\AbsPushDataAt;
use Throwable;

class DPushException extends AbsPushDataAt
{
    
    /**
     * title
     * @var string
     */
    protected $title = '';
    
    /**
     * 任意异常类
     * @var Throwable
     */
    protected $exception;
    
    /**
     * @param Throwable $exception
     * @param string $title
     * @return static
     */
    public static function make(Throwable $exception, string $title = '')
    {
        $instance = new static();
        $instance->setException($exception);
        $instance->setTitle($title);
        return $instance;
    }
    
    /**
     * get the message type
     * @return string
     */
    protected function type(): string
    {
        return 'markdown';
    }
    
    /**
     * get the message type data
     * @return array
     */
    protected function typeData(): array
    {
        $this->atAll(true); // 设置该类型推送@所有人
        $this->isShowAtAll(true); // 设置显示@所有人文本
        
        $text = $this->strSplice(
            '## 系统异常推送',
            '> file: '. $this->exception->getFile(),
            '> line: '. $this->exception->getLine(),
            '> message: '.$this->exception->getMessage(),
            '> date: '. date('Y-m-d H:i:s'),
            $this->getAtText()
        );
        return ["title" => $this->title ?: '异常消息推送', "text" => $text];
    }
    
    /**
     * @param string[] $strings
     * @return string
     */
    protected function strSplice(string ... $strings): string
    {
        $buffer = '';
        foreach ($strings as $str) {
            $buffer .= $str."\n\n";
        }
        return rtrim($buffer, "\n");
    }
    
    /**
     * @param Throwable $exception
     * @return $this
     */
    public function setException(Throwable $exception)
    {
        $this->exception = $exception;
        return $this;
    }
    
    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
        return $this;
    }
    
}