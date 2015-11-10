<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;

/**
 * @ORM\Entity
 */
class Category
{
    /**
     * @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="Merchant", mappedBy="category")
     */
    protected $merchants;

    public function __construct()
    {
        $this->merchants = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
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
     * Add merchant
     *
     * @param \App\Entity\Merchant $merchant
     *
     * @return Category
     */
    public function addMerchant(Merchant $merchant)
    {
        $this->merchants[] = $merchant;
        $merchant->setCategory($this);

        return $this;
    }

    /**
     * Remove merchant
     *
     * @param \App\Entity\Merchant $merchant
     */
    public function removeMerchant(Merchant $merchant)
    {
        $this->merchants->removeElement($merchant);
        $merchant->setCategory();

        return $this;
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

    public function __toString()
    {
        return $this->name;
    }

    /**
     * Get merchants
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getActiveMerchants()
    {
        $criteria = Criteria::create();
        $criteria->where(Criteria::expr()->eq('active', true));
        $criteria->orderBy(['name' => Criteria::ASC]);

        return $this->merchants->matching($criteria);
    }
}
