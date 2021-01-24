<?php

namespace MyProject\Exceptions;

interface MyInterface extends \ Throwable
{
    public function newMethod();
}

class NotIdException extends \Exception implements MyInterface
{
    public function newMethod(): string
    {
        // TODO: Implement newMethod() method.
        return 'File: ' . $this->getFile() . '  ||  ' . '  Line: ' . $this->getTraceAsString();
    }
}