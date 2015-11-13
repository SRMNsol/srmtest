<?php

namespace App\Entity;

use Popshops\Merchant as BaseMerchant;
use Popshops\MerchantCommissionShareTrait;
use Popshops\SubidTrait;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\GroupSequenceProviderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Filesystem\Filesystem;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="MerchantRepository")
 * @ORM\AttributeOverrides({
 *   @ORM\AttributeOverride(name="commissionType", column=@ORM\Column(length=20)),
 *   @ORM\AttributeOverride(name="popshopsId", column=@ORM\Column(type="integer", nullable=true, unique=true)),
 *   @ORM\AttributeOverride(name="networkMerchantId", column=@ORM\Column(type="integer", nullable=true))
 * })
 */
class Merchant extends BaseMerchant implements GroupSequenceProviderInterface
{
    use MerchantCommissionShareTrait;
    use SubidTrait;
    use FileTrait;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $commissionMax = 0.00;

    /**
     * @ORM\Column(nullable=true)
     */
    protected $alternativeName;

    /**
     * @ORM\Column(nullable=true)
     */
    protected $logoPath;

    protected $logoFile;

    protected $uploadedLogoHash;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $skipLogoUpdate = false;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $logoUpdatedAt;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $topStore = false;

    /**
     * @ORM\Column(nullable=true)
     */
    protected $clickoutUrl;

    const COMMISSION_TYPE_FIXED_VAR = 'fixed_var';
    const COMMISSION_TYPE_PERCENTAGE_VAR = 'percentage_var';

    public function getCommissionMax()
    {
        return $this->commissionMax;
    }

    public function setCommissionMax($value)
    {
        $this->commissionMax = (float) $value;

        return $this;
    }

    public function getAlternativeName()
    {
        return $this->alternativeName;
    }

    public function setAlternativeName($name)
    {
        $this->alternativeName = $name;

        return $this;
    }

    public function getDisplayName()
    {
        return ($this->alternativeName !== null) ? $this->alternativeName : $this->name;
    }

    public function hasVariableCommission()
    {
        return $this->commissionType === self::COMMISSION_TYPE_FIXED_VAR
            || $this->commissionType === self::COMMISSION_TYPE_PERCENTAGE_VAR;
    }

    public function calculateCommissionShareAmount($price, $sharePct = 100)
    {
        $amount = 0;

        switch ($this->commissionType) {
            case self::COMMISSION_TYPE_FIXED :
                $cashback = $this->commission * ($sharePct / 100);
                $amount = $cashback;
                break;
            case self::COMMISSION_TYPE_PERCENTAGE :
                $cashback = $this->commission * ($sharePct / 100);
                $amount = $price * ($cashback / 100);
                break;
            case self::COMMISSION_TYPE_FIXED_VAR :
                $cashback = $this->commissionMax * ($sharePct / 100);
                $amount = $cashback;
                break;
            case self::COMMISSION_TYPE_PERCENTAGE_VAR :
                $cashback = $this->commissionMax * ($sharePct / 100);
                $amount = $price * ($cashback / 100);
                break;
        }

        return $amount;
    }

    public function getCommissionShareText($sharePct = 100, $currency = '$', $rangeTemplate = ':min-:max')
    {
        $text = number_format($this->commission * ($sharePct / 100), 2);
        $textMax = number_format($this->commissionMax * ($sharePct / 100), 2);

        if ($text === '0.00') {
            return null;
        }

        switch ($this->commissionType) {
            case self::COMMISSION_TYPE_FIXED :
                $text = preg_replace('/\.00$/', '', $text);

                return "$currency$text";
                break;
            case self::COMMISSION_TYPE_PERCENTAGE :
                $text = preg_replace('/0+$/', '', $text);
                $text = preg_replace('/\.$/', '', $text);

                return "$text%";
                break;
            case self::COMMISSION_TYPE_FIXED_VAR :
                $text = preg_replace('/\.00$/', '', $text);
                $textMax = preg_replace('/\.00$/', '', $textMax);

                $template = $rangeTemplate;
                $template = str_replace(':min', "$currency$text", $template);
                $template = str_replace(':max', "$currency$textMax", $template);

                return $template;
                break;
            case self::COMMISSION_TYPE_PERCENTAGE_VAR :
                $text = preg_replace('/0+$/', '', $text);
                $text = preg_replace('/\.$/', '', $text);
                $textMax = preg_replace('/0+$/', '', $textMax);
                $textMax = preg_replace('/\.$/', '', $textMax);

                $template = $rangeTemplate;
                $template = str_replace(':min', "$text%", $template);
                $template = str_replace(':max', "$textMax%", $template);

                return $template;
                break;
        }

        return null;
    }

    /**
     * Validators
     */
    static public function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('name', new Assert\NotBlank());

        $metadata->addPropertyConstraint('commission', new Assert\NotBlank());
        $metadata->addPropertyConstraint('commission', new Assert\GreaterThanOrEqual([
            'value' => 0
        ]));
        $metadata->addPropertyConstraint('commission', new Assert\LessThanOrEqual([
            'value'  => 100,
            'groups' => ['percentage'],
        ]));

        $metadata->addPropertyConstraint('commissionMax', new Assert\NotBlank());
        $metadata->addPropertyConstraint('commissionMax', new Assert\GreaterThanOrEqual([
            'value' => 0
        ]));
        $metadata->addPropertyConstraint('commissionMax', new Assert\LessThanOrEqual([
            'value'  => 100,
            'groups' => ['percentage'],
        ]));

        $metadata->addPropertyConstraint('commissionType', new Assert\Choice([
            self::COMMISSION_TYPE_FIXED,
            self::COMMISSION_TYPE_PERCENTAGE,
            self::COMMISSION_TYPE_FIXED_VAR,
            self::COMMISSION_TYPE_PERCENTAGE_VAR,
        ]));

        $metadata->addPropertyConstraint('logoFile', new Assert\Image([
            'maxSize'       => 3000000,
            'minWidth'      => 50,
            'minHeight'     => 10,
            'allowPortrait' => false,
            'allowSquare'   => false,
            'groups'        => ['logo'],
        ]));

        $metadata->addPropertyConstraint('clickoutUrl', new Assert\Regex([
            'pattern' => '/\{SUBID\}/',
            'message' => 'Missing {SUBID} placeholder in the url.',
        ]));

        $metadata->setGroupSequenceProvider(true);
    }

    /**
     * Set validation groups based on commission type
     */
    public function getGroupSequence()
    {
        $groups = ['Merchant'];

        if ($this->getCommissionType() === self::COMMISSION_TYPE_PERCENTAGE
            || $this->getCommissionType() === self::COMMISSION_TYPE_PERCENTAGE_VAR
        ) {
            $groups[] = 'percentage';
        }

        $groups[] = 'logo';

        return $groups;
    }

    /**
     * String representation
     */
    public function __toString()
    {
        return $this->getDisplayName();
    }

    /**
     * Merchant name with network
     */
    public function getNetworkMerchantName()
    {
        return sprintf('[%s] %s', (string) $this->network ?: '?', $this->getDisplayName());
    }

    public function getLogoPath()
    {
        return $this->logoPath;
    }

    public function setLogoPath($path)
    {
        $this->logoPath = $path;
    }

    public function getSlug()
    {
        $slug = $this->getDisplayName();
        $slug = strtolower(trim($slug));
        $slug = preg_replace('/[^a-z0-9\-_]/', '_', $slug);

        return $slug;
    }

    public function getLogoAbsolutePath()
    {
        return null === $this->logoPath
            ? null
            : $this->getLogoUploadRootDir().'/'.$this->logoPath;
    }

    public function getLogoWebPath()
    {
        return null === $this->logoPath
            ? null
            : $this->getLogoUploadDir().'/'.$this->logoPath;
    }

    public function getLogoWebUrl()
    {
        return null === $this->logoPath
            ? null
            : $this->getUploadRootUrl().'/'.$this->getLogoWebPath();
    }

    protected function getLogoUploadRootDir()
    {
        return $this->getUploadRootDir().'/'.$this->getLogoUploadDir();
    }

    /**
     * Relative path to uploaded logo directory from
     * upload root directory
     */
    protected function getLogoUploadDir()
    {
        return 'logo';
    }

    /**
     * Relative path to logo download directory from
     * download root directory
     */
    protected function getLogoDownloadDir()
    {
        return 'logo';
    }

    /**
     * Return File from url.
     *
     * Cannot validate file existence due to http stream limitation
     */
    public function getOriginalLogo()
    {
        if (null !== $this->logoUrl) {
            return new File($this->logoUrl, false);
        }
    }

    /**
     * Return File from logo absolute path
     */
    public function getCurrentLogo()
    {
        if (null !== $this->getLogoAbsolutePath()) {
            return new File($this->getLogoAbsolutePath());
        }
    }

    /**
     * Compare $file with current logo
     */
    public function isCurrentLogo($file)
    {
        try {
            $current = $this->getCurrentLogo();
        } catch (FileException $e) {
            // current logo not readable
            return false;
        }

        // any of $file or $current is empty
        if (!isset($file) || !isset($current)) {
            return false;
        }

        // identical path
        if ((string) $file === (string) $current) {
            return true;
        }

        // identical content
        if (sha1_file((string) $file) === sha1_file((string) $current)) {
            return true;
        }

        return false;
    }

    /**
     * Download original logo to download directory
     */
    public function downloadOriginalLogo()
    {
        $original = $this->getOriginalLogo();
        if (null === $original) {
            return;
        }

        $name = uniqid($this->getSlug().'_');
        return $this->download($original, $name, $this->getLogoDownloadDir());
    }

    /**
     * Deletes current logo
     */
    public function deleteCurrentLogo()
    {
        try {
            $current = $this->getCurrentLogo();
            if (isset($current)) {
                $this->delete($current);
                $this->logoPath = null;
            }
        } catch (FileException $e) {
            return;
        }
    }

    public function setLogoFile(File $file = null)
    {
        $this->logoFile = $file;

        // prevent deleting current logo
        // $file is current logo or null
        if (!isset($file) || $this->isCurrentLogo($file)) {
            return $this;
        }

        // file is new delete current logo
        if (isset($this->logoPath)) {
            try {
                $this->delete($this->getCurrentLogo());
            } catch (FileException $e) {
                // current logo not found
            }
            $this->logoPath = null;
        }

        return $this;
    }

    public function getLogoFile()
    {
        return $this->logoFile;
    }

    public function setSkipLogoUpdate($value)
    {
        $this->skipLogoUpdate = (boolean) $value;
    }

    public function getSkipLogoUpdate()
    {
        return $this->skipLogoUpdate;
    }

    public function setLogoUpdatedAt(\DateTime $date = null)
    {
        $this->logoUpdatedAt = $date;

        return $this;
    }

    public function getLogoUpdatedAt()
    {
        return $this->logoUpdatedAt;
    }

    /**
     * Set logoPath to unique name for logoFile.
     * To be run on prePersist and preUpdate events
     */
    public function setUploadedLogoPath()
    {
        $file = $this->getLogoFile();

        if (isset($file) && !$this->isCurrentLogo($file)) {
            $fileHash = sha1_file($file);
            if ($this->uploadedLogoHash === $fileHash) {
                return;
            }
            $this->uploadedLogoHash = $fileHash;

            $name = uniqid($this->getSlug().'_');
            if ($file->guessExtension() !== '') {
                $name .= '.'.$file->guessExtension();
            }

            $this->setLogoPath($name);
        }
    }

    public function uploadLogo()
    {
        $logo = $this->getLogoFile();

        if (isset($logo) && !$this->isCurrentLogo($logo)) {
            $this->setUploadedLogoPath();
            $remote = $this->upload($logo, $this->logoPath, $this->getLogoUploadDir());
        } else {
            try {
                $remote = $this->getCurrentLogo();
            } catch (FileException $e) {
                $remote = null;
            }
        }

        $this->logoFile = null;
        return $remote;
    }

    public function deleteLogo()
    {
        $this->delete($this->getLogoAbsolutePath());
    }

    public function logoInvalid()
    {
        return !isset($this->logoPath) && isset($this->logoUpdatedAt);
    }

    public function getTopStore()
    {
        return $this->topStore;
    }

    public function setTopStore($value)
    {
        $this->topStore = (boolean) $value;

        return $this;
    }

    public function getClickoutUrl()
    {
        return $this->clickoutUrl;
    }

    public function setClickoutUrl($url)
    {
        $this->clickoutUrl = $url;

        return $this;
    }

    public function getTestTrackingUrl()
    {
        return str_replace('{SUBID}', 'TEST', $this->clickoutUrl);
    }
}
