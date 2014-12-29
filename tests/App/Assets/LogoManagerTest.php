<?php

use org\bovigo\vfs\vfsStream;
use Symfony\Component\HttpFoundation\File\File;
use App\Tests\OrmTestCase;

class LogoManagerTest extends OrmTestCase
{
    private $downloadPath;
    private $uploadPath;

    public function setUp()
    {
        parent::setUp();

        $root = vfsStream::setup('root', null, [
            'download' => [
                'valid.gif' => file_get_contents(__DIR__.'/valid.gif'),
                'valid.png' => file_get_contents(__DIR__.'/valid.png'),
                'invalid.png' => 'Not an image',
            ],
            'web' => [
                'logo' => [
                    'cached.png' => file_get_contents(__DIR__.'/valid.png'),
                ]
            ],
        ]);

        $this->downloadPath = $root->getChild('download');
        $this->uploadPath = $root->getChild('web');

        $this->em->getEventManager()->addEventSubscriber(
            new App\Assets\LogoEventSubscriber(
                vfsStream::url('root/download'),
                vfsStream::url('root/web'),
                '*******'
            )
        );
    }

    public function testValidateLogo()
    {
        $merchant = new App\Entity\Merchant();
        $merchant->setId(1);
        $merchant->setNetworkMerchantId(1);
        $merchant->setName('Store 123');
        $merchant->setUploadRootDir(vfsStream::url('root/web'));

        if (!$this->uploadPath->getChild('logo')->hasChild('cached.png')) {
            $this->fail('Missing logo/cached.png');
        }
        $merchant->setLogoPath('cached.png');

        $validator = $this->getMockBuilder('Symfony\Component\Validator\Validator')
            ->disableOriginalConstructor()
            ->getMock();

        $validator
            ->method('validate')
            ->will($this->onConsecutiveCalls([], ['error']));

        $manager = new App\Assets\LogoManager($this->em, $validator);

        // first call is valid
        $manager->validateLogo($merchant);
        $this->assertEquals('cached.png', $merchant->getLogoPath());
        $this->assertTrue($this->uploadPath->getChild('logo')->hasChild('cached.png'));

        // second call is invalid, logo deleted
        $manager->validateLogo($merchant);
        $this->assertNull($merchant->getLogoPath());
        $this->assertFalse($this->uploadPath->getChild('logo')->hasChild('cached.png'));
    }

    public function testUpdateLogo()
    {
        $merchant = new App\Entity\Merchant();
        $merchant->setId(1);
        $merchant->setNetworkMerchantId(1);
        $merchant->setName('Store 123');
        $merchant->setLogoUrl(vfsStream::url('root/download/valid.gif'));
        $merchant->setUploadRootDir(vfsStream::url('root/web'));

        $validator = $this->getMockBuilder('Symfony\Component\Validator\Validator')
            ->disableOriginalConstructor()
            ->getMock();

        $validator
            ->method('validate')
            ->will($this->onConsecutiveCalls(
                [], [], [], ['error']
            ));

        $manager = new App\Assets\LogoManager($this->em, $validator);

        $manager->updateLogo($merchant);
        $this->assertNotNull($merchant->getLogoUpdatedAt());
        // logo is uploaded
        $this->assertTrue($this->uploadPath->hasChild('logo'));
        $this->assertTrue($this->uploadPath->getChild('logo')->hasChild($merchant->getLogoPath()));

        // retrieve entity
        $prevLogoPath = $merchant->getLogoPath();
        $merchant = $this->em->find('App\Entity\Merchant', 1);
        $manager->updateLogo($merchant);
        $this->assertTrue($this->uploadPath->getChild('logo')->hasChild($merchant->getLogoPath()));
        // same logo, no update
        $this->assertEquals($prevLogoPath, $merchant->getLogoPath());

        // change original logo
        $merchant->setLogoUrl(vfsStream::url('root/download/valid.png'));
        $manager->updateLogo($merchant);
        // logo is uploaded
        $this->assertTrue($this->uploadPath->getChild('logo')->hasChild($merchant->getLogoPath()));
        // previous logo is deleted
        $this->assertFalse($this->uploadPath->getChild('logo')->hasChild($prevLogoPath));

        // test invalid logo
        $logoPath = $merchant->getLogoPath();
        $merchant->setLogoUrl(vfsStream::url('root/download/invalid.png'));
        $manager->updateLogo($merchant);
        // no change
        $this->assertEquals($logoPath, $merchant->getLogoPath());
        $this->assertTrue($this->uploadPath->getChild('logo')->hasChild($merchant->getLogoPath()));

        // remove entity
        $logoPath = $merchant->getLogoPath();
        $this->em->remove($merchant);
        $this->em->flush();

        // logo is deleted on remove
        $this->assertFalse($this->uploadPath->getChild('logo')->hasChild($logoPath));
    }
}
