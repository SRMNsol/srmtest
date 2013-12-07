<?php

namespace App\Entity;

use Popshops\Merchant as BaseMerchant;
use Popshops\MerchantCommissionShareTrait;
use Popshops\SubidTrait;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\FormInterface;

/**
 * @Entity
 * @AttributeOverrides({
 *   @AttributeOverride(name="commissionType", column=@Column(length=20))
 * })
 */
class Merchant extends BaseMerchant
{
    use MerchantCommissionShareTrait;
    use SubidTrait;

    /**
     * @Column(type="decimal", scale=2)
     */
    protected $commissionMax = 0.00;

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

    public function getCommissionShareText($sharePct = 100, $currency = '$')
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
            case self::COMMISSION_TYPE_PERCENTAGE :
                $text = preg_replace('/0+$/', '', $text);
                $text = preg_replace('/\.$/', '', $text);
                return "$text%";
            case self::COMMISSION_TYPE_FIXED_VAR :
                $text = preg_replace('/\.00$/', '', $text);
                $textMax = preg_replace('/\.00$/', '', $textMax);
                return "$currency$text-$currency$textMax";
            case self::COMMISSION_TYPE_PERCENTAGE_VAR :
                $text = preg_replace('/0+$/', '', $text);
                $text = preg_replace('/\.$/', '', $text);
                $textMax = preg_replace('/0+$/', '', $textMax);
                $textMax = preg_replace('/\.$/', '', $textMax);
                return "$text%-$textMax%";
        }

        return null;
    }

    static public function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('commission', new Assert\NotBlank());
        $metadata->addPropertyConstraint('commission', new Assert\GreaterThanOrEqual(['value' => 0]));
        $metadata->addPropertyConstraint('commission', new Assert\LessThanOrEqual(['value' => 100, 'groups' => ['Percentage']]));

        $metadata->addPropertyConstraint('commissionMax', new Assert\NotBlank());
        $metadata->addPropertyConstraint('commissionMax', new Assert\GreaterThanOrEqual(['value' => 0]));
        $metadata->addPropertyConstraint('commissionMax', new Assert\LessThanOrEqual(['value' => 100, 'groups' => ['Percentage']]));
    }

    static public function determineValidationGroups(FormInterface $form)
    {
        $merchant = $form->getData();
        $groups = ['Default'];
        if ($merchant->getCommissionType() === self::COMMISSION_TYPE_PERCENTAGE
            || $merchant->getCommissionType() === self::COMMISSION_TYPE_PERCENTAGE_VAR
        ) {
            $groups[] = 'Percentage';
        }
        return $groups;
    }
}
