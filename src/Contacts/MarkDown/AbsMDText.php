<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019/1/30
 * Annotation:
 */

namespace CalJect\DingRobot\Contacts\MarkDown;


use CalJect\DingRobot\Component\Pipeline;

abstract class AbsMDText implements IMDText
{
    
    const NEXT_LINE = "\n\n";
    
    /**
     * the markdown text
     * @var string
     */
    protected $text = '';
    
    /**
     * @var array
     */
    protected $args = [];
    
    /**
     * @var \Closure[]
     */
    protected $pipes = [];
    
    /**
     * @var Pipeline
     */
    protected $pipeline;
    
    /**
     * AbsMDText constructor.
     * @param string|IMDText $val
     * @param array $args
     */
    public function __construct($val, ... $args)
    {
        $this->text = ($val instanceof IMDText) ? $val->text() : $val;
        $this->args = $args;
        $this->pipeline = new Pipeline();
    }
    
    /**
     * @param string|IMDText $text
     * @param array $args
     * @return static
     */
    public static function make($text, ... $args)
    {
        return new static($text, ... $args);
    }
    
    
    /**
     * get the md text
     * @return string
     */
    public function text(): string
    {
        return $this->handle($this->text, ... $this->args);
    }
    
    /**
     * handle the text
     * @param string $text
     * @param array $args
     * @return string
     */
    abstract public function handle(string $text, ... $args): string;
    
    /*---------------------------------------------- static ----------------------------------------------*/
    
    /**
     * @param string $text
     * @return string
     */
    public static function convert(string $text): string
    {
        return static::make($text)->text();
    }
    
    /**
     * invoke
     */
    public function __invoke()
    {
        return $this->text();
    }
    
}