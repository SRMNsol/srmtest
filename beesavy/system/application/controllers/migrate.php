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

    public function user_download()
    {
        echo 'Starting user download', PHP_EOL;
    }
}
