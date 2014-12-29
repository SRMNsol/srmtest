<?php

namespace App\Assets;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\FileException;
use Symfony\Component\Validator\Validator;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use App\Entity\Merchant;

class LogoManager
{
    protected $em;
    protected $validator;

    public function __construct(EntityManager $em, Validator $validator)
    {
        $this->em = $em;
        $this->validator = $validator;
    }

    /**
     * Validate and delete invalid current logo
     */
    public function validateLogo(Merchant $merchant)
    {
        try {
            $current = $merchant->getCurrentLogo();
        } catch (FileException $e) {
            $merchant->setLogoPath(null);
        }

        if (isset($current)) {
            $merchant->setLogoFile($current);
            $errors = $this->validator->validate($merchant, ['logo']);
            $isValid = count($errors) === 0;

            if (!$isValid) {
                $merchant->deleteCurrentLogo();
                $merchant->setLogoFile(); // unset
            }
        }

        $this->em->persist($merchant);
        $this->em->flush();

        return $isValid;
    }

    /**
     * Update merchant logo with the original logo
     */
    public function updateLogo(Merchant $merchant)
    {
        $original = $merchant->downloadOriginalLogo();

        if ($original !== null) {
            $logoPath = $merchant->getLogoPath();
            $merchant->setLogoFile($original);
            $errors = $this->validator->validate($merchant, ['logo']);
            if (count($errors) > 0) {
                $merchant->setLogoPath($logoPath);
                $merchant->setLogoFile(); // unset
                $merchant->emptyTrash(); // no files to delete
            }
        }

        $merchant->setLogoUpdatedAt(new \DateTime());
        $this->em->persist($merchant);
        $this->em->flush();
    }
}
