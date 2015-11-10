<?php

namespace App\Entity;

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
 */
class Merchant implements GroupSequenceProviderInterface
{
    use FileTrait;

    /**
     * @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="integer", nullable=true, unique=true)
     */
    protected $popshopsId;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $networkMerchantId;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="merchants")
     */
    protected $category;

    /**
     * @ORM\Column
     */
    protected $name;

    /**
     * @ORM\Column(nullable=true)
     */
    protected $url;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    const COMMISSION_TYPE_FIXED = 'fixed';
    const COMMISSION_TYPE_PERCENTAGE = 'percentage';
    const COMMISSION_TYPE_FIXED_VAR = 'fixed_var';
    const COMMISSION_TYPE_PERCENTAGE_VAR = 'percentage_var';

    /**
     * @ORM\Column(length=20)
     */
    protected $commissionType = self::COMMISSION_TYPE_FIXED;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $commission = 0.00;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $commissionMax = 0.00;

    /**
     * @ORM\Column(nullable=true)
     */
    protected $alternativeName;

    /**
     * @ORM\ManyToOne(targetEntity="Network", inversedBy="merchants")
     */
    protected $network;

    /**
     * @ORM\OneToMany(targetEntity="Transaction", mappedBy="merchant")
     */
    protected $transactions;

    /**
     * @ORM\Column(nullable=true)
     */
    protected $logoPath;

    protected $logoFile;

    protected $uploadedLogoHash;

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

    /**
     * @ORM\Column(type="boolean")
     */
    protected $active = false;

    public function getId()
    {
        return $this->id;
    }

    public function getPopshopsId()
    {
        return $this->popshopsId;
    }

    public function setPopshopsId($id)
    {
        $this->popshopsId = (int) $id;

        return $this;
    }

    public function getNetworkMerchantId()
    {
        return $this->networkMerchantId;
    }

    public function setNetworkMerchantId($id)
    {
        $this->networkMerchantId = (int) $id;

        return $this;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory(Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($text)
    {
        $this->description = $text;

        return $this;
    }

    public function getCommissionType()
    {
        return $this->commissionType;
    }

    public function setCommissionType($value)
    {
        $this->commissionType = $value;

        return $this;
    }

    public function getCommission()
    {
        return $this->commission;
    }

    public function setCommission($value)
    {
        $this->commission = (float) $value;

        return $this;
    }

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

    /**
     * Set network
     *
     * @param Network $network
     * @return Merchant
     */
    public function setNetwork(Network $network = null)
    {
        $this->network = $network;

        return $this;
    }

    /**
     * Get network
     *
     * @return Network
     */
    public function getNetwork()
    {
        return $this->network;
    }

    /**
     * Add transactions
     *
     * @param Transaction $transactions
     * @return Merchant
     */
    public function addTransaction(Transaction $transaction)
    {
        $this->transactions[] = $transaction;

        return $this;
    }

    /**
     * Remove transactions
     *
     * @param Transaction $transaction
     */
    public function removeTransaction(Transaction $transaction)
    {
        $this->transactions->removeElement($transaction);
    }

    /**
     * Get transactions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTransactions()
    {
        return $this->transactions;
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

    public function getCommissionSharePercentage($sharePct = 100)
    {
        if ($this->commissionType === self::COMMISSION_TYPE_PERCENTAGE) {
            return $this->commissionType * ($sharePct / 100);
        }

        return 0;
    }

    public function getCommissionShareFixed($sharePct = 100)
    {
        if ($this->commissionType === self::COMMISSION_TYPE_FIXED) {
            return $this->commissionType * ($sharePct / 100);
        }

        return 0;
    }

    public function calculateFinalPrice($price, $sharePct = 100)
    {
        return $price - $this->calculateCommissionShareAmount($price, $sharePct);
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

    public function getActive()
    {
        return $this->active;
    }

    public function setActive($value)
    {
        $this->active = (boolean) $value;

        return $this;
    }

    public function getTrackingUrl(Subid $subid = null)
    {
        $param = isset($subid) ? $subid->encode() : '';

        return str_replace('{SUBID}', $param, $this->clickoutUrl);
    }
}
