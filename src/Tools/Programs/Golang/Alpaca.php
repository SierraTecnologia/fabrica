<?php
/**
 * Api Libraries Powered And Created by Alpaca
 * 
 * https://github.com/pksunkara/alpaca
 */

class Alpaca
{
    protected $repositoryUrl = 'https://github.com/pksunkara/alpaca';

    public function workInVersion()
    {
        return [
             '1.2'
        ];
    }

    public function installCommand()
    {
        return 'bash <(curl -s -S -L '.$this->repositoryUrl.')';
    }
}