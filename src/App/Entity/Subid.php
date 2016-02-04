<?php

namespace App\Entity;

class Subid
{
    protected $userId;
    protected $timestamp;

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($id)
    {
        $this->userId = $id;

        return $this;
    }

    public function getTimestamp()
    {
        return $this->timestamp;
    }

    public function setTimestamp(\DateTime $timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    public function encode()
    {
        $params = [];

        if ($this->userId > 0) {
            $params[] = sprintf('u%d', $this->userId);
        }

        if ($this->timestamp instanceof \DateTime) {
            $params[] = sprintf('t%d', $this->timestamp->format('U'));
        }

        $subid = implode('-', $params);

        return urlencode($subid);
    }

    public function decode($string)
    {
        $string = strtolower($string);
        $params = array_filter(explode('-', $string));

        foreach ($params as $param) {
            if (preg_match('/u(\d+)/', $param, $matches)) {
                $this->userId = $matches[1];
            }

            if (preg_match('/t(\d+)/', $param, $matches)) {
                $this->timestamp = \DateTime::createFromFormat('U', $matches[1]);
                $this->timestamp->setTimeZone(new \DateTimeZone(date_default_timezone_get()));
            }
        }
    }

    public function __toString()
    {
        return $this->encode();
    }

    public static function createFromString($string)
    {
        $subid = new self();
        $subid->decode($string);

        return $subid;
    }
}
