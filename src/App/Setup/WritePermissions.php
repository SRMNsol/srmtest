<?php

namespace App\Setup;

use Composer\Script\Event;

class WritePermissions
{
    public static function checkPaths(Event $event)
    {
        $app = require __DIR__ . '/../../app.php';
        chmod($app['log_path'], 0777);
        chmod($app['cache_path'], 0777);
    }
}
