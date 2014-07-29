<?php

use App\Tests\OrmTestCase;
use App\Entity\Merchant;

class MerchantTest extends OrmTestCase
{
    public function testDisplayName()
    {
        $merchant = new Merchant();
        $merchant->setName('Test');
        $this->assertEquals('Test', $merchant->getDisplayName());

        $merchant->setAlternativeName('Alt');
        $this->assertEquals('Alt', $merchant->getDisplayName());
    }
}
