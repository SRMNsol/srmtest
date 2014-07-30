<?php

namespace App\Entity;

use Popshops\Merchant as BaseMerchant;
use Popshops\MerchantCommissionShareTrait;
use Popshops\SubidTrait;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\FormInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\AttributeOverrides({
 *   @ORM\AttributeOverride(name="commissionType", column=@ORM\Column(length=20))
 * })
 */
class Merchant extends BaseMerchant
{
    use MerchantCommissionShareTrait;
    use SubidTrait;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $commissionMax = 0.00;

    /**
     * @ORM\Column(nullable=true)
     */
    protected $alternativeName;

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
        $metadata->addPropertyConstraint('commission', new Assert\NotBlank());
        $metadata->addPropertyConstraint('commission', new Assert\GreaterThanOrEqual(['value' => 0]));
        $metadata->addPropertyConstraint('commission', new Assert\LessThanOrEqual(['value' => 100, 'groups' => ['Percentage']]));

        $metadata->addPropertyConstraint('commissionMax', new Assert\NotBlank());
        $metadata->addPropertyConstraint('commissionMax', new Assert\GreaterThanOrEqual(['value' => 0]));
        $metadata->addPropertyConstraint('commissionMax', new Assert\LessThanOrEqual(['value' => 100, 'groups' => ['Percentage']]));

        $metadata->addPropertyConstraint('commissionType', new Assert\Choice([
            self::COMMISSION_TYPE_FIXED,
            self::COMMISSION_TYPE_PERCENTAGE,
            self::COMMISSION_TYPE_FIXED_VAR,
            self::COMMISSION_TYPE_PERCENTAGE_VAR,
        ]));
    }

    /**
     * Set validation groups based on commission type
     */
    static public function determineValidationGroups(FormInterface $form)
    {
        $merchant = $form->getData();
        $groups = ['Merchant'];
        if ($merchant->getCommissionType() === self::COMMISSION_TYPE_PERCENTAGE
            || $merchant->getCommissionType() === self::COMMISSION_TYPE_PERCENTAGE_VAR
        ) {
            $groups[] = 'Percentage';
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
}
