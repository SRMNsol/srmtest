<?php

namespace App\Entity;

/**
 * @Entity
 * @Table(name="user")
 */
class User
{
    /**
     * @Id @Column(name="uid", type="integer") @GeneratedValue
     */
    protected $id;

    /**
     * @Column(name="id", type="integer", length=11, nullable=true)
     */
    protected $extrabuxId;

    /**
     * @Column(length=250)
     */
    protected $email;

    /**
     * @Column(name="facebook_auto", type="boolean")
     */
    protected $facebookAuto = false;

    /**
     * @Column(name="twitter_auto", type="boolean")
     */
    protected $twitterAuto = false;

    /**
     * @Column(name="payment_method")
     */
    protected $paymentMethod;

    /**
     * @Column(name="paypal_email", length=250)
     */
    protected $paypalEmail;

    /**
     * @Column(length=50)
     */
    protected $alias;

    /**
     * @Column(name="charity_id", type="integer")
     */
    protected $extrabuxCharityId;

    /**
     * @Column(type="boolean")
     */
    protected $admin = false;

    /**
     * @Column(name="send_reminders", type="boolean")
     */
    protected $sendReminders = false;

    /**
     * @Column(name="send_updates", type="boolean")
     */
    protected $sendUpdates = false;

    /**
     * @Column(name="last_login", type="datetime")
     */
    protected $lastLoginAt;

    /**
     * @Column(name="last_refer", type="datetime")
     */
    protected $lastReferAt;

    /**
     * @Column(name="created", type="datetime")
     */
    protected $createdAt;

    /**
     * @Column(name="fb_access_token")
     */
    protected $facebookAccessToken;

    /**
     * @Column(name="twitter_token_secret")
     */
    protected $twitterTokenSecret;

    /**
     * @Column(name="twitter_access_token")
     */
    protected $twitterAccessToken;

    /**
     * @Column
     */
    protected $password;

    /**
     * @Column(name="purchase_exempt", type="boolean")
     */
    protected $purchaseExempt = false;

    /**
     * @Column(name="email_refer_info", type="boolean")
     */
    protected $emailReferInfo = false;

    /**
     * @Column(name="email_83", type="boolean")
     */
    protected $email83 = false;

    /**
     * @Column(name="email_60", type="boolean")
     */
    protected $email60 = false;

    /**
     * @Column(name="last_cashback", type="datetime")
     */
    protected $lastCashbackAt;

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
     * Set extrabuxId
     *
     * @param integer $extrabuxId
     * @return User
     */
    public function setExtrabuxId($extrabuxId)
    {
        $this->extrabuxId = $extrabuxId;

        return $this;
    }

    /**
     * Get extrabuxId
     *
     * @return integer 
     */
    public function getExtrabuxId()
    {
        return $this->extrabuxId;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set facebookAuto
     *
     * @param boolean $facebookAuto
     * @return User
     */
    public function setFacebookAuto($facebookAuto)
    {
        $this->facebookAuto = $facebookAuto;

        return $this;
    }

    /**
     * Get facebookAuto
     *
     * @return boolean 
     */
    public function getFacebookAuto()
    {
        return $this->facebookAuto;
    }

    /**
     * Set twitterAuto
     *
     * @param boolean $twitterAuto
     * @return User
     */
    public function setTwitterAuto($twitterAuto)
    {
        $this->twitterAuto = $twitterAuto;

        return $this;
    }

    /**
     * Get twitterAuto
     *
     * @return boolean 
     */
    public function getTwitterAuto()
    {
        return $this->twitterAuto;
    }

    /**
     * Set paymentMethod
     *
     * @param string $paymentMethod
     * @return User
     */
    public function setPaymentMethod($paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    /**
     * Get paymentMethod
     *
     * @return string 
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * Set paypalEmail
     *
     * @param string $paypalEmail
     * @return User
     */
    public function setPaypalEmail($paypalEmail)
    {
        $this->paypalEmail = $paypalEmail;

        return $this;
    }

    /**
     * Get paypalEmail
     *
     * @return string 
     */
    public function getPaypalEmail()
    {
        return $this->paypalEmail;
    }

    /**
     * Set alias
     *
     * @param string $alias
     * @return User
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Get alias
     *
     * @return string 
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Set extrabuxCharityId
     *
     * @param integer $extrabuxCharityId
     * @return User
     */
    public function setExtrabuxCharityId($extrabuxCharityId)
    {
        $this->extrabuxCharityId = $extrabuxCharityId;

        return $this;
    }

    /**
     * Get extrabuxCharityId
     *
     * @return integer 
     */
    public function getExtrabuxCharityId()
    {
        return $this->extrabuxCharityId;
    }

    /**
     * Set admin
     *
     * @param boolean $admin
     * @return User
     */
    public function setAdmin($admin)
    {
        $this->admin = $admin;

        return $this;
    }

    /**
     * Get admin
     *
     * @return boolean 
     */
    public function getAdmin()
    {
        return $this->admin;
    }

    /**
     * Set sendReminders
     *
     * @param boolean $sendReminders
     * @return User
     */
    public function setSendReminders($sendReminders)
    {
        $this->sendReminders = $sendReminders;

        return $this;
    }

    /**
     * Get sendReminders
     *
     * @return boolean 
     */
    public function getSendReminders()
    {
        return $this->sendReminders;
    }

    /**
     * Set sendUpdates
     *
     * @param boolean $sendUpdates
     * @return User
     */
    public function setSendUpdates($sendUpdates)
    {
        $this->sendUpdates = $sendUpdates;

        return $this;
    }

    /**
     * Get sendUpdates
     *
     * @return boolean 
     */
    public function getSendUpdates()
    {
        return $this->sendUpdates;
    }

    /**
     * Set lastLoginAt
     *
     * @param \DateTime $lastLoginAt
     * @return User
     */
    public function setLastLoginAt($lastLoginAt)
    {
        $this->lastLoginAt = $lastLoginAt;

        return $this;
    }

    /**
     * Get lastLoginAt
     *
     * @return \DateTime 
     */
    public function getLastLoginAt()
    {
        return $this->lastLoginAt;
    }

    /**
     * Set lastReferAt
     *
     * @param \DateTime $lastReferAt
     * @return User
     */
    public function setLastReferAt($lastReferAt)
    {
        $this->lastReferAt = $lastReferAt;

        return $this;
    }

    /**
     * Get lastReferAt
     *
     * @return \DateTime 
     */
    public function getLastReferAt()
    {
        return $this->lastReferAt;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return User
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
     * Set facebookAccessToken
     *
     * @param string $facebookAccessToken
     * @return User
     */
    public function setFacebookAccessToken($facebookAccessToken)
    {
        $this->facebookAccessToken = $facebookAccessToken;

        return $this;
    }

    /**
     * Get facebookAccessToken
     *
     * @return string 
     */
    public function getFacebookAccessToken()
    {
        return $this->facebookAccessToken;
    }

    /**
     * Set twitterTokenSecret
     *
     * @param string $twitterTokenSecret
     * @return User
     */
    public function setTwitterTokenSecret($twitterTokenSecret)
    {
        $this->twitterTokenSecret = $twitterTokenSecret;

        return $this;
    }

    /**
     * Get twitterTokenSecret
     *
     * @return string 
     */
    public function getTwitterTokenSecret()
    {
        return $this->twitterTokenSecret;
    }

    /**
     * Set twitterAccessToken
     *
     * @param string $twitterAccessToken
     * @return User
     */
    public function setTwitterAccessToken($twitterAccessToken)
    {
        $this->twitterAccessToken = $twitterAccessToken;

        return $this;
    }

    /**
     * Get twitterAccessToken
     *
     * @return string 
     */
    public function getTwitterAccessToken()
    {
        return $this->twitterAccessToken;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set purchaseExempt
     *
     * @param boolean $purchaseExempt
     * @return User
     */
    public function setPurchaseExempt($purchaseExempt)
    {
        $this->purchaseExempt = $purchaseExempt;

        return $this;
    }

    /**
     * Get purchaseExempt
     *
     * @return boolean 
     */
    public function getPurchaseExempt()
    {
        return $this->purchaseExempt;
    }

    /**
     * Set emailReferInfo
     *
     * @param boolean $emailReferInfo
     * @return User
     */
    public function setEmailReferInfo($emailReferInfo)
    {
        $this->emailReferInfo = $emailReferInfo;

        return $this;
    }

    /**
     * Get emailReferInfo
     *
     * @return boolean 
     */
    public function getEmailReferInfo()
    {
        return $this->emailReferInfo;
    }

    /**
     * Set email83
     *
     * @param boolean $email83
     * @return User
     */
    public function setEmail83($email83)
    {
        $this->email83 = $email83;

        return $this;
    }

    /**
     * Get email83
     *
     * @return boolean 
     */
    public function getEmail83()
    {
        return $this->email83;
    }

    /**
     * Set email60
     *
     * @param boolean $email60
     * @return User
     */
    public function setEmail60($email60)
    {
        $this->email60 = $email60;

        return $this;
    }

    /**
     * Get email60
     *
     * @return boolean 
     */
    public function getEmail60()
    {
        return $this->email60;
    }

    /**
     * Set lastCashbackAt
     *
     * @param \DateTime $lastCashbackAt
     * @return User
     */
    public function setLastCashbackAt($lastCashbackAt)
    {
        $this->lastCashbackAt = $lastCashbackAt;

        return $this;
    }

    /**
     * Get lastCashbackAt
     *
     * @return \DateTime 
     */
    public function getLastCashbackAt()
    {
        return $this->lastCashbackAt;
    }
}
