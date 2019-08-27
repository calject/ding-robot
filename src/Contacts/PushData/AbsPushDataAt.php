<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019/1/30
 * Annotation:
 */

namespace CalJect\DingRobot\Contacts\PushData;

abstract class AbsPushDataAt extends AbsPushData
{
    
    /**
     * @ mobile list
     * @var array
     */
    protected $atMobiles = [];
    
    /**
     * is @ all
     * @var bool
     */
    protected $atAll = false;
    
    /**
     * is show @ all
     * @var bool
     */
    protected $isShowAtAll = false;
    
    /**
     * is show @ person mobile tag
     * @var bool
     */
    protected $isShowAtMobiles = true;
    
    
    /**
     * add @ person mobile
     * @param array ...$args
     * @return $this
     */
    public function atMobiles( ... $args)
    {
        foreach ($args as $arg) {
            if (is_array($arg)) {
                $this->atMobiles(... $arg);
            }else {
                array_push($this->atMobiles, $arg);
            }
        }
        return $this;
    }
    
    /**
     * set is @ all
     * @param bool $at_all
     * @param bool $isShowAtAll is show @ all tag
     * @return $this
     */
    public function atAll(bool $at_all = true, $isShowAtAll = null)
    {
        $this->atAll = $at_all;
        isset($isShowAtAll) && $this->isShowAtAll($isShowAtAll);
        return $this;
    }
    
    /**
     * set is show @ all tag, default false
     * @param bool $showAtAll
     * @return $this
     */
    public function isShowAtAll(bool $showAtAll)
    {
        $this->isShowAtAll = $showAtAll;
        return $this;
    }
    
    /**
     * set is show @ person mobile tag, default true
     * @param bool $isShowAtMobiles
     * @return $this
     */
    public function isShowAtMobiles(bool $isShowAtMobiles)
    {
        $this->isShowAtMobiles = $isShowAtMobiles;
        return $this;
    }
    
    /**
     * @ somebody list
     * @return array
     */
    public function at(): array
    {
        if ($this->atMobiles || $this->atAll) {
            return ["at" => ["atMobiles" => $this->atMobiles, "isAtAll" => $this->atAll]];
        } else {
            return [];
        }
    }
    
    /**
     * get the @ text
     * @return string
     */
    public function getAtText()
    {
        if ($this->atAll) {
            return $this->isShowAtAll ? '@all' : '';
        }else if ($this->isShowAtMobiles){
            $str = '';
            foreach ($this->atMobiles as $mobile) {
                $str .= '@'.$mobile.' ';
            }
            return $str;
        }else {
            return '';
        }
    }
    
}