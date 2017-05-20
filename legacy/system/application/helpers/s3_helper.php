<?php

/**
 * Path from S3 bucket
 *
 * vim
 * %s/\v(src|href) *\= *["']\/?([^ :<]{-}\..{-})["']/\1="<?php echo s3path("\/\2") ?>"/g
 */
function s3path($path)
{   
    static $prefix;

    if (!isset($path)) {
        return '#';
    }

    if (!isset($prefix)) {
        $app = silex();
        $prefix = $app['bucket_url'];
    }

    $url = parse_url($path, PHP_URL_SCHEME) ? $path : $prefix.$path;

   //return s3rotate($url);
    return ASSETURL.$path;
}

function s3rotate($url)
{
    static $counter = 0;

    if (0 !== strpos($url, 'http://static0.beesavy.com')) {
        return $url;
     }
    
    $url = str_replace('http://static0', 'http://static'.$counter, $url);
    $counter += ($counter < 3) ? 1 : -3;
    
   return $url;
}
