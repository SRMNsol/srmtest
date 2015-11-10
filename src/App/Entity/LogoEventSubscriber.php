<?php

namespace App\Entity;

use Doctrine\ORM\Events;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use App\Entity\Merchant;

class LogoEventSubscriber implements EventSubscriber
{
    protected $uploadRootDir;
    protected $uploadRootUrl;

    public function __construct($uploadRootDir, $uploadRootUrl)
    {
        $this->uploadRootDir = $uploadRootDir;
        $this->uploadRootUrl = $uploadRootUrl;
    }

    /**
     * Update merchants download and upload root directories
     */
    protected function updatePaths(Merchant $merchant)
    {
        $merchant->setUploadRootDir($this->uploadRootDir);
        $merchant->setUploadRootUrl($this->uploadRootUrl);
    }

    public function getSubscribedEvents()
    {
        return [
            Events::postLoad,
            Events::prePersist,
            Events::preUpdate,
            Events::preRemove,
            Events::postPersist,
            Events::postUpdate,
            Events::postRemove,
        ];
    }

    public function postLoad(LifecycleEventArgs $args)
    {
        $merchant = $args->getObject();
        if ($merchant instanceof Merchant) {
            $this->updatePaths($merchant);
        }
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $merchant = $args->getObject();
        if ($merchant instanceof Merchant) {
            $this->updatePaths($merchant);
            $merchant->setUploadedLogoPath();
        }
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $merchant = $args->getObject();
        if ($merchant instanceof Merchant) {
            $merchant->setUploadedLogoPath();
        }
    }

    public function preRemove(LifecycleEventArgs $args)
    {
        $merchant = $args->getObject();
        if ($merchant instanceof Merchant) {
            $merchant->deleteLogo();
        }
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $merchant = $args->getObject();
        if ($merchant instanceof Merchant) {
            $merchant->uploadLogo();
            $merchant->removeDeletedFiles();
        }
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $merchant = $args->getObject();
        if ($merchant instanceof Merchant) {
            $merchant->uploadLogo();
            $merchant->removeDeletedFiles();
        }
    }

    public function postRemove(LifecycleEventArgs $args)
    {
        $merchant = $args->getObject();
        if ($merchant instanceof Merchant) {
            $merchant->removeDeletedFiles();
        }
    }
}
