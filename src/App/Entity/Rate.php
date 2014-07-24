<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="RateRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Rate
{
    /**
     * @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=false)
     */
    protected $level0;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=false)
     */
    protected $level1;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=false)
     */
    protected $level2;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=false)
     */
    protected $level3;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=false)
     */
    protected $level4;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=false)
     */
    protected $level5;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=false)
     */
    protected $level6;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=false)
     */
    protected $level7;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

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
     * Set level0
     *
     * @param string $level0
     * @return Rate
     */
    public function setLevel0($level0)
    {
        $this->level0 = $level0;

        return $this;
    }

    /**
     * Get level0
     *
     * @return string
     */
    public function getLevel0()
    {
        return $this->level0;
    }

    /**
     * Set level1
     *
     * @param string $level1
     * @return Rate
     */
    public function setLevel1($level1)
    {
        $this->level1 = $level1;

        return $this;
    }

    /**
     * Get level1
     *
     * @return string
     */
    public function getLevel1()
    {
        return $this->level1;
    }

    /**
     * Set level2
     *
     * @param string $level2
     * @return Rate
     */
    public function setLevel2($level2)
    {
        $this->level2 = $level2;

        return $this;
    }

    /**
     * Get level2
     *
     * @return string
     */
    public function getLevel2()
    {
        return $this->level2;
    }

    /**
     * Set level3
     *
     * @param string $level3
     * @return Rate
     */
    public function setLevel3($level3)
    {
        $this->level3 = $level3;

        return $this;
    }

    /**
     * Get level3
     *
     * @return string
     */
    public function getLevel3()
    {
        return $this->level3;
    }

    /**
     * Set level4
     *
     * @param string $level4
     * @return Rate
     */
    public function setLevel4($level4)
    {
        $this->level4 = $level4;

        return $this;
    }

    /**
     * Get level4
     *
     * @return string
     */
    public function getLevel4()
    {
        return $this->level4;
    }

    /**
     * Set level5
     *
     * @param string $level5
     * @return Rate
     */
    public function setLevel5($level5)
    {
        $this->level5 = $level5;

        return $this;
    }

    /**
     * Get level5
     *
     * @return string
     */
    public function getLevel5()
    {
        return $this->level5;
    }

    /**
     * Set level6
     *
     * @param string $level6
     * @return Rate
     */
    public function setLevel6($level6)
    {
        $this->level6 = $level6;

        return $this;
    }

    /**
     * Get level6
     *
     * @return string
     */
    public function getLevel6()
    {
        return $this->level6;
    }

    /**
     * Set level7
     *
     * @param string $level7
     * @return Rate
     */
    public function setLevel7($level7)
    {
        $this->level7 = $level7;

        return $this;
    }

    /**
     * Get level7
     *
     * @return string
     */
    public function getLevel7()
    {
        return $this->level7;
    }

    /**
     * Get level by parameter
     */
    public function getLevel($level)
    {
        if ($level < 0 || $level > 7) {
            throw new \Exception(sprintf('Invalid level %d', $level));
        }

        $property = 'level' . $level;

        return $this->$property;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Rate
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
     * @ORM\PrePersist
     */
    public function onCreate()
    {
        $this->createdAt = new \DateTime();
    }

    public function createCopy()
    {
        $rate = new Rate();
        $rate->setLevel0($this->getLevel0());
        $rate->setLevel1($this->getLevel1());
        $rate->setLevel2($this->getLevel2());
        $rate->setLevel3($this->getLevel3());
        $rate->setLevel4($this->getLevel4());
        $rate->setLevel5($this->getLevel5());
        $rate->setLevel6($this->getLevel6());
        $rate->setLevel7($this->getLevel7());

        return $rate;
    }

    public function hasSameValues(Rate $rate)
    {
        return ($this->getLevel0() == $rate->getLevel0())
            && ($this->getLevel1() == $rate->getLevel1())
            && ($this->getLevel2() == $rate->getLevel2())
            && ($this->getLevel3() == $rate->getLevel3())
            && ($this->getLevel4() == $rate->getLevel4())
            && ($this->getLevel5() == $rate->getLevel5())
            && ($this->getLevel6() == $rate->getLevel6())
            && ($this->getLevel7() == $rate->getLevel7())
        ;
    }
}
