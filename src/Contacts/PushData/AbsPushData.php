<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019/1/30
 * Annotation:
 */

namespace CalJect\DingRobot\Contacts\PushData;


abstract class AbsPushData implements IPushData
{
    /*---------------------------------------------- extends function ----------------------------------------------*/
    
    /**
     * @ somebody list
     * @return array
     */
    public function at(): array
    {
        return [];
    }
    
    
    /*---------------------------------------------- abstract ----------------------------------------------*/
    
    
    /**
     * get the message type
     * @return string
     */
    abstract protected function type(): string;
    
    
    /**
     * get the message type data
     * @return array
     */
    abstract protected function typeData(): array;
    
    
    
    /*---------------------------------------------- function ----------------------------------------------*/
    
    
    /**
     * get push data
     * @return array
     */
    public function getData(): array
    {
        $type = $this->type();
        $typeData = $this->typeData();
        return $this->at() + [
                "msgtype" => $type,
                $type => $typeData
            ];
    }
}