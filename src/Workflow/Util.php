<?php

namespace Fabrica\Workflow;

class Util
{
    //
    public function preStepFunc1($args): void
    {
        echo 'pre step func1 ===';
    }

    //
    public function postStepFunc1($args): void
    {
        echo 'post step func1 ===';
    }

    //
    public function preStepFunc2($args): void
    {
        echo 'pre step func2 ===';
    }

    //
    public function postStepFunc2($args): void
    {
        echo 'post step func2 ===';
    }

    //
    public function preActionFunc1($args): void
    {
        echo 'pre action func1 ===';
    }

    //
    public function postActionFunc1($args): void
    {
        echo 'post action func1 ===';
    }

    //
    public function preActionFunc2($args): void
    {
        echo 'pre action func2 ===';
    }

    //
    public function postActionFunc2($args): void
    {
        echo 'post action func2 ===';
    }

    //
    public function preResultFunc1($args): void
    {
        echo 'pre result func1 ===';
    }

    //
    public function postResultFunc1($args): void
    {
        echo 'post result func1 ===';
    }

    //
    public function preResultFunc2($args): void
    {
        echo 'pre result func2 ===';
    }

    //
    public function postResultFunc2($args): void
    {
        echo 'post result func2 ===';
    }

    //
    /**
     * @return true
     */
    public function trueCondition1($args): bool
    {
        return true;
    }

    //
    /**
     * @return true
     */
    public function trueCondition2($args): bool
    {
        return true;
    }

     //
    /**
     * @return false
     */
    public function falseCondition1($args): bool
    {
        return false;
    }

    //
    /**
     * @return false
     */
    public function falseCondition2($args): bool
    {
        return false;
    }
}
