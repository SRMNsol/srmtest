<?php

use App\Tests\OrmTestCase;
use App\Entity\Merchant;
use org\bovigo\vfs\vfsStream;
use Symfony\Component\HttpFoundation\File\File;

class MerchantTest extends OrmTestCase
{
    private $downloadPath;
    private $webPath;

    public function setUp()
    {
        parent::setUp();

        $root = vfsStream::setup('root', null, [
            'download' => [
                'original.gif' => file_get_contents(__DIR__.'/blank.gif'),
                'valid.gif' => file_get_contents(__DIR__.'/valid.gif')
            ],
            'web' => [
                'cached.png' => file_get_contents(__DIR__.'/blank.png'),
            ],
        ]);

        $this->downloadPath = $root->getChild('download');
        $this->webPath = $root->getChild('web');

        $this->em->getEventManager()->addEventSubscriber(
            new App\Assets\LogoEventSubscriber(
                vfsStream::url('root/download'),
                vfsStream::url('root/web'),
                '*******'
            )
        );
    }

    public function testDisplayName()
    {
        $merchant = new Merchant();
        $merchant->setName('Test');
        $this->assertEquals('Test', $merchant->getDisplayName());

        $merchant->setAlternativeName('Alt');
        $this->assertEquals('Alt', $merchant->getDisplayName());
    }

    public function testSlug()
    {
        $merchant = new Merchant();
        $merchant->setName('  Store-123 test\'d!');
        $this->assertEquals('store-123_test_d_', $merchant->getSlug());
    }

    public function testLogoPaths()
    {
        $merchant = new Merchant();
        $merchant->setUploadRootDir('/upload');

        $this->assertNull($merchant->getLogoAbsolutePath());
        $this->assertNull($merchant->getLogoWebPath());

        $merchant->setLogoPath('image.png');
        $this->assertEquals('/upload/logo/image.png', $merchant->getLogoAbsolutePath());
        $this->assertEquals('logo/image.png', $merchant->getLogoWebPath());
    }

    public function testGetOriginalLogo()
    {
        $merchant = new Merchant();
        $this->assertNull($merchant->getOriginalLogo());

        $merchant->setLogoUrl('http://example/test.png');
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\File\File', $merchant->getOriginalLogo());
    }

    public function testHasDownloadRootDir()
    {
        $merchant = new Merchant();
        $this->assertEquals(sys_get_temp_dir(), $merchant->getDownloadRootDir());

        $merchant->setDownloadRootDir(vfsStream::url('root/notexists'));
        $this->assertEquals(sys_get_temp_dir(), $merchant->getDownloadRootDir());

        $merchant->setDownloadRootDir(vfsStream::url('root/download'));
        $this->assertEquals(vfsStream::url('root/download'), $merchant->getDownloadRootDir());
    }

    public function testDownloadOriginalLogo()
    {
        $merchant = $this->getMockBuilder('App\Entity\Merchant')
            ->setMethods(['getOriginalLogo'])
            ->getMock();

        $merchant
            ->method('getOriginalLogo')
            ->willReturn(new File(vfsStream::url('root/download/original.gif')));

        $merchant->setName('Store 123');
        $merchant->setDownloadRootDir(vfsStream::url('root/download'));

        $file = $merchant->downloadOriginalLogo();

        $this->assertInstanceOf('Symfony\Component\HttpFoundation\File\File', $file);
        $this->assertStringStartsWith(vfsStream::url('root/download'), $file->getPath());
        $this->assertStringStartsWith($merchant->getSlug(), $file->getFilename());
    }

    public function testValidateCommission()
    {
        $commission = new \ReflectionProperty('App\Entity\Merchant', 'commission');
        $commission->setAccessible(true);
        $commissionMax = new \ReflectionProperty('App\Entity\Merchant', 'commissionMax');
        $commissionMax->setAccessible(true);

        $merchant = new Merchant();
        $merchant->setCommission(0.00);
        $merchant->setCommissionMax(0.00);
        $merchant->setCommissionType(Merchant::COMMISSION_TYPE_FIXED);
        $errors = $this->validator->validateProperty($merchant, 'commission');
        $this->assertEquals(0, count($errors));
        $errors = $this->validator->validateProperty($merchant, 'commissionMax');
        $this->assertEquals(0, count($errors));

        $commission->setValue($merchant, null);
        $commissionMax->setValue($merchant, null);
        $errors = $this->validator->validateProperty($merchant, 'commission');
        $this->assertEquals(1, count($errors));
        $this->assertEquals('This value should not be blank.', $errors[0]->getMessage());
        $errors = $this->validator->validateProperty($merchant, 'commissionMax');
        $this->assertEquals(1, count($errors));
        $this->assertEquals('This value should not be blank.', $errors[0]->getMessage());

        $merchant->setCommission(-1);
        $merchant->setCommissionMax(-1);
        $errors = $this->validator->validateProperty($merchant, 'commission');
        $this->assertEquals(1, count($errors));
        $this->assertEquals('This value should be greater than or equal to 0.', $errors[0]->getMessage());
        $errors = $this->validator->validateProperty($merchant, 'commissionMax');
        $this->assertEquals(1, count($errors));
        $this->assertEquals('This value should be greater than or equal to 0.', $errors[0]->getMessage());

        $merchant->setCommissionType(Merchant::COMMISSION_TYPE_FIXED_VAR);
        $errors = $this->validator->validateProperty($merchant, 'commission');
        $this->assertEquals(1, count($errors));
        $this->assertEquals('This value should be greater than or equal to 0.', $errors[0]->getMessage());
        $errors = $this->validator->validateProperty($merchant, 'commissionMax');
        $this->assertEquals(1, count($errors));
        $this->assertEquals('This value should be greater than or equal to 0.', $errors[0]->getMessage());

        $merchant->setCommission(200);
        $merchant->setCommissionMax(200);
        $merchant->setCommissionType(Merchant::COMMISSION_TYPE_PERCENTAGE);
        $errors = $this->validator->validateProperty($merchant, 'commission', ['percentage']);
        $this->assertEquals(1, count($errors));
        $this->assertEquals('This value should be less than or equal to 100.', $errors[0]->getMessage());
        $errors = $this->validator->validateProperty($merchant, 'commissionMax', ['percentage']);
        $this->assertEquals(1, count($errors));
        $this->assertEquals('This value should be less than or equal to 100.', $errors[0]->getMessage());

        $merchant->setCommissionType(Merchant::COMMISSION_TYPE_PERCENTAGE_VAR);
        $errors = $this->validator->validateProperty($merchant, 'commission', ['percentage']);
        $this->assertEquals(1, count($errors));
        $this->assertEquals('This value should be less than or equal to 100.', $errors[0]->getMessage());
        $errors = $this->validator->validateProperty($merchant, 'commissionMax', ['percentage']);
        $this->assertEquals(1, count($errors));
        $this->assertEquals('This value should be less than or equal to 100.', $errors[0]->getMessage());
    }

    public function testIsCurrentLogo()
    {
        $merchant = new Merchant();
        $merchant->setUploadRootDir(vfsStream::url('root/web'));
        $file = new File(vfsStream::url('root/download/valid.gif'));

        mkdir(vfsStream::url('root/web/logo'));
        copy(vfsStream::url('root/web/cached.png'), vfsStream::url('root/web/logo/cached.png'));

        // merchant has no logo
        $this->assertFalse($merchant->isCurrentLogo($file));
        $this->assertFalse($merchant->isCurrentLogo(null));
        // temporary upload name
        $merchant->setLogoPath('123456.gif');
        $this->assertFalse($merchant->isCurrentLogo($file));
        $this->assertFalse($merchant->isCurrentLogo(null));
        // real uploaded file
        $merchant->setLogoPath('cached.png');
        $this->assertFalse($merchant->isCurrentLogo($file));
        // identical path
        $this->assertTrue($merchant->isCurrentLogo(vfsStream::url('root/web/logo/cached.png')));
        // identical file different path
        $this->assertTrue($merchant->isCurrentLogo(vfsStream::url('root/web/cached.png')));
    }

    public function testSetLogoFile()
    {
        $merchant = new Merchant();
        $merchant->setUploadRootDir(vfsStream::url('root/web'));

        $trash = new \ReflectionProperty('App\Entity\Merchant', 'trash');
        $trash->setAccessible(true);

        mkdir(vfsStream::url('root/web/logo'));
        copy(vfsStream::url('root/web/cached.png'), vfsStream::url('root/web/logo/test.png'));

        // current logo is root/web/logo/test.png
        $merchant->setLogoPath('test.png');

        // set the same file, nothing is deleted
        $merchant->setLogoFile(new File(vfsStream::url('root/web/logo/test.png')));
        $this->assertEquals([], $trash->getValue($merchant));

        // set null, nothing is deleted
        $merchant->setLogoFile();
        $this->assertEquals([], $trash->getValue($merchant));

        // set a new file, current logo is deleted
        $merchant->setLogoFile(new File(vfsStream::url('root/download/original.gif')));
        $this->assertNull($merchant->getLogoPath());
        $this->assertEquals([vfsStream::url('root/web/logo/test.png')], $trash->getValue($merchant));
    }

    public function testDeleteCurrentLogo()
    {
        $merchant = new Merchant();
        $merchant->setUploadRootDir(vfsStream::url('root/web'));

        mkdir(vfsStream::url('root/web/logo'));
        copy(vfsStream::url('root/web/cached.png'), vfsStream::url('root/web/logo/test.png'));

        // temporary logoPath, nothing deleted
        $merchant->setLogoPath('1234134.png');
        $merchant->deleteCurrentLogo();
        $this->assertEquals('1234134.png', $merchant->getLogoPath());
        $this->assertEquals([], $merchant->getTrash());

        // current logo is root/web/logo/test.png
        $merchant->setLogoPath('test.png');
        $merchant->deleteCurrentLogo();
        $this->assertNull($merchant->getLogoPath());
        // logo in trash
        $this->assertEquals([vfsStream::url('root/web/logo/test.png')], $merchant->getTrash());
    }

    public function testValidateLogo()
    {
        $merchant = new Merchant();
        $merchant->setUploadRootDir(vfsStream::url('root/web'));

        $merchant->setLogoFile(new File(__DIR__.'/notimage.txt'));
        $errors = $this->validator->validate($merchant, ['logo']);
        $this->assertEquals(1, count($errors));
        $this->assertEquals('This file is not a valid image.', $errors[0]->getMessage());

        $merchant->setLogoFile(new File(__DIR__.'/blank.gif'));
        $errors = $this->validator->validate($merchant, ['logo']);
        $this->assertEquals(1, count($errors));
        $this->assertRegExp('/The image width is too small/', $errors[0]->getMessage());

        $merchant->setLogoFile(new File(__DIR__.'/wide.png'));
        $errors = $this->validator->validate($merchant, ['logo']);
        $this->assertEquals(1, count($errors));
        $this->assertRegExp('/The image height is too small/', $errors[0]->getMessage());

        $merchant->setLogoFile(new File(__DIR__.'/portrait.jpg'));
        $errors = $this->validator->validate($merchant, ['logo']);
        $this->assertEquals(1, count($errors));
        $this->assertRegExp('/Portrait oriented images are not allowed/', $errors[0]->getMessage());

        $merchant->setLogoFile(new File(__DIR__.'/square.gif'));
        $errors = $this->validator->validate($merchant, ['logo']);
        $this->assertEquals(1, count($errors));
        $this->assertRegExp('/Square images are not allowed/', $errors[0]->getMessage());

        $merchant->setLogoFile(new File(__DIR__.'/valid.gif'));
        $errors = $this->validator->validate($merchant, ['logo']);
        $this->assertEquals(0, count($errors));
    }

    public function testUpload()
    {
        $merchant = new Merchant();
        $merchant->setName('Store 123');
        $merchant->setLogoFile(new File(vfsStream::url('root/download/valid.gif')));
        $merchant->setUploadRootDir(vfsStream::url('root/web'));

        if ($this->webPath->hasChild('logo')) {
            $this->fail('Logo directory should not exists in web path');
        }

        $merchant->uploadLogo();
        // logo directory created
        $this->assertTrue($this->webPath->hasChild('logo'));
        // logo directory contains new logo
        $this->assertEquals(1, count($this->webPath->getChild('logo')->getChildren()));
        // new logo is uploaded
        $this->assertTrue($this->webPath->getChild('logo')->hasChild($merchant->getLogoPath()));
        // logo path starts with slug
        $this->assertStringStartsWith($merchant->getSlug(), $merchant->getLogoPath());
        // nothing to delete
        $this->assertEquals(0, count($merchant->getTrash()));
        $path1 = $merchant->getLogoPath();

        // upload an identical file
        // must make copy because uploadLogo remove source file
        $tempPath = sys_get_temp_dir().'/'.uniqid(mt_rand(0, 1000)).'.gif';
        copy(__DIR__.'/valid.gif', $tempPath);
        $merchant->setLogoFile(new File($tempPath));
        $merchant->uploadLogo();
        // nothing is uploaded
        $this->assertEquals(1, count($this->webPath->getChild('logo')->getChildren()));
        // logo path not changed
        $this->assertEquals($path1, $merchant->getLogoPath());
        // nothing to delete
        $this->assertEquals(0, count($merchant->getTrash()));

        // upload a different file
        $merchant->setLogoFile(new File(vfsStream::url('root/download/original.gif')));
        $merchant->uploadLogo();
        // new logo is uploaded, now contains 2 files
        $this->assertEquals(2, count($this->webPath->getChild('logo')->getChildren()));
        // new path
        $this->assertNotEquals($path1, $merchant->getLogoPath());
        // previous logo in trash
        $this->assertEquals(1, count($merchant->getTrash()));
        $this->assertEquals([vfsStream::url('root/web/logo/'.$path1)], $merchant->getTrash());
    }

    public function testUploadOrm()
    {
        $merchant = new Merchant();
        $merchant->setNetworkMerchantId(1);
        $merchant->setName('Store 123');
        $merchant->setLogoFile(new File(vfsStream::url('root/download/valid.gif')));
        $merchant->setUploadRootDir(vfsStream::url('root/web'));

        if ($this->webPath->hasChild('logo')) {
            $this->fail('Logo directory should not exists in web path');
        }

        $this->em->persist($merchant);
        $this->em->flush();

        // new logo is uploaded
        $this->assertTrue($this->webPath->getChild('logo')->hasChild($merchant->getLogoPath()));
        $path1 = $merchant->getLogoPath();

        // upload an identical file
        // must make copy because uploadLogo remove source file
        $tempPath = sys_get_temp_dir().'/'.uniqid(mt_rand(0, 1000)).'.gif';
        copy(__DIR__.'/valid.gif', $tempPath);
        $merchant->setLogoFile(new File($tempPath));
        $this->em->persist($merchant);
        $this->em->flush();

        // nothing is uploaded, logoPath not changed
        $this->assertEquals($path1, $merchant->getLogoPath());
        $this->assertTrue($this->webPath->getChild('logo')->hasChild($merchant->getLogoPath()));

        // upload a different file
        $merchant->setLogoFile(new File(vfsStream::url('root/download/original.gif')));
        $this->em->persist($merchant);
        $this->em->flush();

        // new logo is uploaded
        $this->assertNotEquals($path1, $merchant->getLogoPath());
        $this->assertTrue($this->webPath->getChild('logo')->hasChild($merchant->getLogoPath()));
        // previous logo is deleted
        $this->assertFalse($this->webPath->getChild('logo')->hasChild($path1));
    }

    public function testRemove()
    {
        $merchant = new App\Entity\Merchant();

        $method = new \ReflectionMethod('App\Entity\Merchant', 'delete');
        $method->setAccessible(true);

        $method->invoke($merchant, new File(vfsStream::url('root/download/original.gif')));
        $this->assertEquals(1, count($merchant->getTrash()));

        // file won't be added twice
        $method->invoke($merchant, vfsStream::url('root/download/original.gif'));
        $this->assertEquals(1, count($merchant->getTrash()));

        $method->invoke($merchant, new File(vfsStream::url('root/web/cached.png')));
        $this->assertEquals(2, count($merchant->getTrash()));

        $merchant->removeDeletedFiles();
        $this->assertFalse($this->downloadPath->hasChild('original.gif'));
        $this->assertFalse($this->webPath->hasChild('cached.png'));
    }

    public function testDataUrl()
    {
        $url = 'data:text/plain;base64,'.base64_encode('Hello!');
        $merchant = new Merchant();
        $merchant->setLogoUrl($url);
        $merchant->setDownloadRootDir(vfsStream::url('root/download'));
        $file = $merchant->downloadOriginalLogo();

        $this->assertInstanceOf('Symfony\Component\HttpFoundation\File\File', $file);
        $this->assertStringStartsWith(vfsStream::url('root/download'), $file->getPath());
        $this->assertEquals('Hello!', $file->openFile()->current());
    }

    public function testHasCustomRepository()
    {
        $repository = $this->em->getRepository('App\Entity\Merchant');
        $this->assertInstanceOf('App\Entity\MerchantRepository', $repository);
    }
}
