<?php

namespace App\Entity;

/**
 * @Entity(repositoryClass="RateRepository")
 * @HasLifecycleCallback
 */
class Rate
{
    /**
     * @Id @Column(type="integer") @GeneratedValue
     */
    protected $id;

    /**
     * @Column(type="decimal", scale=2, nullable=false)
     */
    protected $level0;

    /**
     * @Column(type="decimal", scale=2, nullable=false)
     */
    protected $level1;

    /**
     * @Column(type="decimal", scale=2, nullable=false)
     */
    protected $level2;

    /**
     * @Column(type="decimal", scale=2, nullable=false)
     */
    protected $level3;

    /**
     * @Column(type="decimal", scale=2, nullable=false)
     */
    protected $level4;

    /**
     * @Column(type="decimal", scale=2, nullable=false)
     */
    protected $level5;

    /**
     * @Column(type="decimal", scale=2, nullable=false)
     */
    protected $level6;

    /**
     * @Column(type="decimal", scale=2, nullable=false)
     */
    protected $level7;

    /**
     * @Column(type="datetime")
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
     * @PrePersist
     */
    public function onCreate()
    {
        $this->createdAt = new \DateTime();
    }
}
