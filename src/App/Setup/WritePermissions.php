<?php

namespace App\Setup;

use Composer\Script\Event;

class WritePermissions
{
    public static function checkPaths(Event $event)
    {
        $app = require __DIR__ . '/../../app.php';
        chmod($app['log_dir'], 0777);
        chmod($app['cache_dir'], 0777);
        chmod($app['legacy_cache_dir'], 0777);
        chmod($app['temp_dir'], 0777);
    }
}
