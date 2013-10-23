<?php

/**
 * Migration CLI
 */
class Migrate extends Controller
{
    public function __construct()
    {
        parent::Controller();
    }

    public function test($param)
    {
        echo "Test : $param" . PHP_EOL;
    }
}
