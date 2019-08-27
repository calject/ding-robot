<?php
/**
 * Created by PhpStorm.
 * User: 沧澜
 * Date: 2019/1/30
 * Annotation: a small pipeline class
 */

namespace CalJect\DingRobot\Component;

use Closure;

class Pipeline
{
    
    /**
     * @var array
     */
    protected $pipes = [];
    
    
    /**
     * The object being passed through the pipeline.
     *
     * @var mixed
     */
    protected $passable;
    
    
    /**
     * Set the array of pipes.
     * @param Closure $pipe
     * @return $this
     */
    public function through(Closure $pipe)
    {
        $this->pipes[] = $pipe;
        return $this;
    }
    
    /**
     * Set the object being sent through the pipeline.
     *
     * @param  mixed  $passable
     * @return $this
     */
    public function send($passable)
    {
        $this->passable = $passable;
        return $this;
    }
    
    
    /**
     * Run the pipeline with a final destination callback.
     * @param  Closure  $destination
     * @return mixed
     */
    public function then(Closure $destination)
    {
        $pipeline = array_reduce(
            array_reverse($this->pipes), $this->carry(), $this->prepareDestination($destination)
        );
        return $pipeline($this->passable);
    }
    
    /**
     * Get a Closure that represents a slice of the application onion.
     *
     * @return Closure
     */
    protected function carry()
    {
        return function ($stack, $pipe) {
            return function ($passable) use ($stack, $pipe) {
                dd($passable, $stack, $pipe);
            };
        };
    }
    
    /**
     * Get the final piece of the Closure onion.
     *
     * @param  Closure  $destination
     * @return Closure
     */
    protected function prepareDestination(Closure $destination)
    {
        return function ($passable) use ($destination) {
            return $destination($passable);
        };
    }
    
}