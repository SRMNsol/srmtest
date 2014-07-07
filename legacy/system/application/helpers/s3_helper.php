<?php

/**
 * Path from S3 bucket
 *
 * vim
 * %s/\v(src|href) *\= *["']\/?([^ :<]{-}\..{-})["']/\1="<?php echo s3path("\/\2") ?>"/g
 */
function s3path($file)
{
    static $counter = 0;

    $url = 'http://static' . $counter . '.beesavy.com' . $file;

    $counter += ($counter < 3) ? 1 : -3;

    return $url;
}
