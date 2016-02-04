<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\GroupSequenceProviderInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="AdvertiserTransaction")
 * @ORM\HasLifecycleCallbacks
 * @ORM\EntityListeners({"TransactionListener"})
 */
class Transaction implements GroupSequenceProviderInterface
{
    use MoneyTrait;

    /**
     * @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $registeredAt;

    /**
     * @ORM\Column(length=20)
     */
    protected $status = self::STATUS_REGISTERED;

    /**
     * @ORM\Column
     */
    protected $orderNumber;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $total = 0.00;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $commission = 0.00;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="Merchant", inversedBy="transactions")
     */
    protected $merchant;

    /**
     * @ORM\ManyToOne(targetEntity="Network", inversedBy="transactions")
     */
    protected $network;

    /**
     * @ORM\Column(nullable=true)
     */
    protected $tag;

    /**
     * @ORM\OneToMany(targetEntity="TransactionHistory", mappedBy="transaction")
     */
    protected $history;

    /**
     * @ORM\OneToOne(targetEntity="Cashback", inversedBy="transaction", cascade={"persist"}, orphanRemoval=true)
     */
    protected $cashback;

    /**
     * @ORM\ManyToOne(targetEntity="Rate")
     */
    protected $rate;

    /**
     * @ORM\Column(nullable=true)
     */
    protected $customMerchant;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $manual = false;

    const STATUS_REGISTERED = 'registered'; // new, default status
    const STATUS_AVAILABLE  = 'available';  // confirmed
    const STATUS_PROCESSED  = 'processed';  // final status
    const STATUS_CANCELED   = 'canceled';   // final status

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->history = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set registeredAt
     *
     * @param \DateTime $registeredAt
     * @return Transaction
     */
    public function setRegisteredAt($registeredAt)
    {
        if ($registeredAt instanceof \DateTime && $this->registeredAt instanceof \DateTime) {
            if ($this->registeredAt->format('YmdHis') !== $registeredAt->format('YmdHis')) {
                $this->registeredAt = $registeredAt;
            }

            return $this;
        }

        $this->registeredAt = $registeredAt;

        return $this;
    }

    /**
     * Get registeredAt
     *
     * @return \DateTime
     */
    public function getRegisteredAt()
    {
        return $this->registeredAt;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Transaction
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set orderNumber
     *
     * @param string $orderNumber
     * @return Transaction
     */
    public function setOrderNumber($orderNumber)
    {
        $this->orderNumber = $orderNumber;

        return $this;
    }

    /**
     * Get orderNumber
     *
     * @return string
     */
    public function getOrderNumber()
    {
        return $this->orderNumber;
    }

    /**
     * Set total
     *
     * @param string $total
     * @return Transaction
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return string
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set commission
     *
     * @param string $commission
     * @return Transaction
     */
    public function setCommission($commission)
    {
        $this->commission = $commission;

        return $this;
    }

    /**
     * Get commission
     *
     * @return string
     */
    public function getCommission()
    {
        return $this->commission;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Transaction
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Transaction
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set merchant
     *
     * @param Merchant $merchant
     * @return Transaction
     */
    public function setMerchant(Merchant $merchant = null)
    {
        $this->merchant = $merchant;

        return $this;
    }

    /**
     * Get merchant
     *
     * @return Merchant
     */
    public function getMerchant()
    {
        return $this->merchant;
    }

    /**
     * Set network
     *
     * @param Network $network
     * @return Transaction
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
     * @ORM\PrePersist
     */
    public function onCreate()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function onUpdate()
    {
        $this->updatedAt = new \DateTime();
    }

    /**
     * Set tag
     *
     * @param string $tag
     * @return Transaction
     */
    public function setTag($tag)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Get tag
     *
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

    public function sumTotal($amount)
    {
        $this->total += (float) $amount;
    }

    public function sumCommission($amount)
    {
        $this->commission += (float) $amount;
    }

    public function sumQuantity($count)
    {
        $this->quantity += (int) $count;
    }

    public function parseTag()
    {
        $subid = new Subid();
        $subid->decode($this->tag);

        return $subid;
    }

    public function getRealCommission()
    {
        switch ($this->status) {
            case self::STATUS_CANCELED :
                return 0.00;
            case self::STATUS_REGISTERED :
            case self::STATUS_AVAILABLE :
            case self::STATUS_PROCESSED :
                return $this->commission;
        }

        throw new \RuntimeException(sprintf('Unknown transaction status \'%s\'', $this->status));
    }

    /**
     * Add history
     *
     * @param TransactionHistory $history
     * @return Transaction
     */
    public function addHistory(TransactionHistory $history)
    {
        $this->history[] = $history;
        $history->setTransaction($this);

        return $this;
    }

    /**
     * Remove history
     *
     * @param TransactionHistory $history
     */
    public function removeHistory(TransactionHistory $history)
    {
        $this->history->removeElement($history);
        $history->setTransaction(/* null */);
    }

    /**
     * Get history
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getHistory()
    {
        return $this->history;
    }

    public function updateFromHistory()
    {
        if ($this->history->count() > 0) {
            $total = 0.00;
            $commission = 0.00;
            $registeredAt = clone $this->registeredAt;

            foreach ($this->history as $history) {
                $total += $history->getTotal();
                $commission += $history->getCommission();

                // set transaction date to earliest history
                if (null === $registeredAt || $history->getRegisteredAt() < $registeredAt) {
                    $registeredAt = clone $history->getRegisteredAt();
                }
            }

            $this->total = $total;
            $this->commission = $commission;
            if (null !== $registeredAt) {
                $this->registeredAt = $registeredAt;
            }
        }

        return $this;
    }

    public function getHistoryByDate(\DateTime $from, \DateTime $to)
    {
        $maxDate = clone $to;
        $maxDate->add(\DateInterval::createFromDateString('+ 1 day'));

        $criteria = Criteria::create()
            ->where(Criteria::expr()->gte('registeredAt', $from))
            ->andWhere(Criteria::expr()->lt('registeredAt', $maxDate))
        ;

        return $this->history->matching($criteria);
    }

    /**
     * Validation
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addConstraint(new UniqueEntity([
            'fields' => ['orderNumber', 'merchant'],
            'message' => 'Order number exists for this merchant',
        ]));

        $metadata->addPropertyConstraint('customMerchant', new Assert\NotBlank([
            'groups' => 'CustomMerchant'
        ]));

        $metadata->addPropertyConstraint('orderNumber', new Assert\NotBlank());
        $metadata->addPropertyConstraint('registeredAt', new Assert\NotBlank());

        $metadata->setGroupSequenceProvider(true);
    }

    public function getGroupSequence()
    {
        $groups = ['Transaction'];
        if (null === $this->getMerchant()) {
            $groups[] = 'CustomMerchant';
        }

        return $groups;
    }

    public function getCashback()
    {
        return $this->cashback;
    }

    public function setCashback(Cashback $cashback = null)
    {
        $this->cashback = $cashback;

        return $this;
    }

    public function getRate()
    {
        return $this->rate;
    }

    public function setRate(Rate $rate = null)
    {
        $this->rate = $rate;

        return $this;
    }

    public function getCustomMerchant()
    {
        return $this->customMerchant;
    }

    public function setCustomMerchant($name)
    {
        $this->customMerchant = $name;

        return $this;
    }

    public function getManual()
    {
        return $this->manual;
    }

    public function setManual($value)
    {
        $this->manual = (bool) $value;

        return $this;
    }

    /**
     * Calculate commission by level
     */
    public function getCommissionByLevel($rateLevel)
    {
        $commission = 0.00;

        $rate = $this->getRate();
        $share = $rate ? $rate->getLevel($rateLevel) : 0;

        if (self::gt($this->getRealCommission(), 0) && self::gt($share, 0)) {
            $commission = $share * $this->getRealCommission();
        }

        return self::round($commission);
    }

    public function getMerchantName()
    {
        if (null === $this->merchant) {
            return $this->customMerchant;
        }

        return $this->merchant->getName();
    }
}
