<?php
/**
 * Bridge between CI front end and new popshops backend.
 * The legacy CI app is located under the root of the new backend.
 */

/**
 * Silex container loader
 */
function silex()
{
    $app = require __DIR__ . '/../../../../src/app.php';

    return $app;
}
