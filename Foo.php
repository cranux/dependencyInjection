<?php
namespace PhpTest;

class Baz{
    protected $bar;

    public function __construct(Bar $bar)
    {
        $this->bar = $bar;
    }
}

class Bar{}

class Foo
{
    protected $baz;
    protected $bac;
    protected $bar;

    public function __construct($bac='wk', Bar $bar, Baz $baz)
    {
        $this->bac = $bac;
        $this->bar = $bar;
        $this->baz = $baz;

    }
}