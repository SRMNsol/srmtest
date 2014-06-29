<?php

/**
 * Path from S3 bucket
 *
 * vim
 * %s/\v(src|href) *\= *["']\/?([^ :<]{-}\..{-})["']/\1="<?php echo s3path("\/\2") ?>"/g
 */
function s3path($file) {
    return 'http://static0.beesavy.com' . $file;
}
