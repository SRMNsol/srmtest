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

/**
 * Serialize merchants
 */
function serialize_merchants(\App\Popshops\MerchantCollection $merchants)
{
    return array_values($merchants->map(function (\App\Popshops\Merchant $merchant) {
        return [
            'id' => $merchant->getId(),
            'name' => $merchant->getName(),
            'logo' => $merchant->getLogoUrl(),
            'logo_thumb' => $merchant->getLogoUrl(),
            'description' => '',
            'cashback_percent' => 0,
            'cashback_flat' => 0,
            'cashback_text' => '0%',
            'coupons' => $merchant->getDealCount(),
            'link' => '/transfer/store/' . $merchant->getId(),
        ];
    })->toArray());
}

/**
 * Random slice array
 */
function random_slice(array $array, $length)
{
    shuffle($array);
    return array_slice($array, 0, $length);
}
