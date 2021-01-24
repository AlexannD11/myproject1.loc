<?php


namespace MyProject\Cli;


class Minusator extends AbstractCommand
{

    public function execute()
    {
        $this->ensureParamExists('x');
        $this->ensureParamExists('y');
    }

    protected function checkParams()
    {
        echo $this->getParam('x') - $this->getParam('y');
    }
}