<?php

namespace App\Entity;

use Popshops\Network as BaseNetwork;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Network extends BaseNetwork
{
    /**
     * @ORM\Column(type="date", nullable=true)
     */
    protected $lastTransactionDownloadAt;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    protected $lastTransactionHistoryDownloadAt;

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
