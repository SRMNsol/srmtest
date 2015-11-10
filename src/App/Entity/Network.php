<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Network
{
    /**
     * @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="integer", nullable=true, unique=true)
     */
    protected $popshopsId;

    /**
     * @ORM\Column
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="Merchant", mappedBy="network")
     */
    protected $merchants;

    /**
     * @ORM\OneToMany(targetEntity="Transaction", mappedBy="network")
     */
    protected $transactions;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    protected $lastTransactionDownloadAt;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    protected $lastTransactionHistoryDownloadAt;

    /**
     * Constructor
     */
    public function __construct(Crawler $node = null)
    {
        $this->merchants = new \Doctrine\Common\Collections\ArrayCollection();
    }

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

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Add merchants
     *
     * @param Merchant $merchant
     * @return Network
     */
    public function addMerchant(Merchant $merchant)
    {
        $this->merchants[] = $merchant;

        return $this;
    }

    /**
     * Remove merchants
     *
     * @param Merchant $merchant
     */
    public function removeMerchant(Merchant $merchant)
    {
        $this->merchants->removeElement($merchant);
    }

    /**
     * Get merchants
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMerchants()
    {
        return $this->merchants;
    }

    /**
     * Add transactions
     *
     * @param Transaction $transactions
     * @return Network
     */
    public function addTransaction(Transaction $transaction)
    {
        $this->transactions[] = $transaction;

        return $this;
    }

    /**
     * Remove transactions
     *
     * @param Transaction $transactions
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

    public function getLastTransactionDownloadAt()
    {
        return $this->lastTransactionDownloadAt;
    }

    public function setLastTransactionDownloadAt(\DateTime $date = null)
    {
        $this->lastTransactionDownloadAt = $date;

        return $this;
    }

    public function getLastTransactionHistoryDownloadAt()
    {
        return $this->lastTransactionHistoryDownloadAt;
    }

    public function setLastTransactionHistoryDownloadAt(\DateTime $date = null)
    {
        $this->lastTransactionHistoryDownloadAt = $date;

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
