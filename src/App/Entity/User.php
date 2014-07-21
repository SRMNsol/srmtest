<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="UserRepository")
 * @ORM\Table(name="user", indexes={@ORM\Index(columns={"created"})})
 */
class User
{
    /**
     * @ORM\Id @ORM\Column(name="uid", type="integer") @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(name="id", type="integer", length=11, nullable=true)
     */
    protected $extrabuxId;

    /**
     * @ORM\Column(length=250, unique=true)
     */
    protected $email;

    /**
     * @ORM\Column(name="facebook_auto", type="boolean")
     */
    protected $facebookAuto = false;

    /**
     * @ORM\Column(name="twitter_auto", type="boolean")
     */
    protected $twitterAuto = false;

    /**
     * @ORM\Column(name="payment_method", nullable=true)
     */
    protected $paymentMethod;

    /**
     * @ORM\Column(name="paypal_email", length=250, nullable=true)
     */
    protected $paypalEmail;

    /**
     * @ORM\Column(length=50, unique=true)
     */
    protected $alias;

    /**
     * @ORM\ManyToOne(targetEntity="Charity")
     */
    protected $charity;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $admin = false;

    /**
     * @ORM\Column(name="send_reminders", type="boolean")
     */
    protected $sendReminders = false;

    /**
     * @ORM\Column(name="send_updates", type="boolean")
     */
    protected $sendUpdates = false;

    /**
     * @ORM\Column(name="last_login", type="datetime", nullable=true)
     */
    protected $lastLoginAt;

    /**
     * @ORM\Column(name="last_refer", type="datetime", nullable=true)
     */
    protected $lastReferAt;

    /**
     * @ORM\Column(name="created", type="datetime", nullable=true)
     */
    protected $createdAt;

    /**
     * @ORM\Column(name="fb_access_token", nullable=true)
     */
    protected $facebookAccessToken;

    /**
     * @ORM\Column(name="twitter_token_secret", nullable=true)
     */
    protected $twitterTokenSecret;

    /**
     * @ORM\Column(name="twitter_access_token", nullable=true)
     */
    protected $twitterAccessToken;

    /**
     * @ORM\Column
     */
    protected $password;

    /**
     * @ORM\Column(name="purchase_exempt", type="boolean")
     */
    protected $purchaseExempt = false;

    /**
     * @ORM\Column(name="email_refer_info", type="boolean")
     */
    protected $emailReferInfo = false;

    /**
     * @ORM\Column(name="email_83", type="boolean")
     */
    protected $email83 = false;

    /**
     * @ORM\Column(name="email_60", type="boolean")
     */
    protected $email60 = false;

    /**
     * @ORM\Column(name="last_cashback", type="datetime", nullable=true)
     */
    protected $lastCashbackAt;

    /**
     * @ORM\Column(name="raw_data", type="text", nullable=true)
     */
    protected $extrabuxRawData;

    /**
     * @ORM\Column(name="last_sync", type="datetime", nullable=true)
     */
    protected $extrabuxLastSyncAt;

    /**
     * @ORM\Column(name="first_name", length=50, nullable=true)
     */
    protected $firstName;

    /**
     * @ORM\Column(name="last_name", length=50, nullable=true)
     */
    protected $lastName;

    /**
     * @ORM\Column(name="raw_user_data", type="text", nullable=true)
     */
    protected $extrabuxRawUserData;

    /**
     * @ORM\OneToMany(targetEntity="Payable", mappedBy="user")
     */
    protected $payables;

    /**
     * @ORM\Column(nullable=true)
     */
    protected $address;

    /**
     * @ORM\Column(length=50, nullable=true)
     */
    protected $city;

    /**
     * @ORM\Column(length=5, nullable=true)
     */
    protected $state;

    /**
     * @ORM\Column(length=10, nullable=true)
     */
    protected $zip;

    /**
     * @ORM\Column(length=10)
     */
    protected $status = self::STATUS_ACTIVE;

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="referredUsers")
     * @ORM\JoinColumn(referencedColumnName="uid", name="ref_uid")
     */
    protected $referredBy;

    /**
     * @ORM\OneToMany(targetEntity="User", mappedBy="referredBy")
     */
    protected $referredUsers;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addConstraint(new UniqueEntity(['fields' => 'email']));
        $metadata->addConstraint(new UniqueEntity(['fields' => 'alias']));
        $metadata->addPropertyConstraint('email', new Assert\NotBlank());
        $metadata->addPropertyConstraint('email', new Assert\Email());
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

    /**
     * Set extrabuxRawData
     *
     * @param string $extrabuxRawData
     * @return User
     */
    public function setExtrabuxRawData($extrabuxRawData)
    {
        $this->extrabuxRawData = $extrabuxRawData;

        return $this;
    }

    /**
     * Get extrabuxRawData
     *
     * @return string
     */
    public function getExtrabuxRawData()
    {
        return $this->extrabuxRawData;
    }

    /**
     * Set extrabuxLastSyncAt
     *
     * @param \DateTime $extrabuxLastSyncAt
     * @return User
     */
    public function setExtrabuxLastSyncAt($extrabuxLastSyncAt)
    {
        $this->extrabuxLastSyncAt = $extrabuxLastSyncAt;

        return $this;
    }

    /**
     * Get extrabuxLastSyncAt
     *
     * @return \DateTime
     */
    public function getExtrabuxLastSyncAt()
    {
        return $this->extrabuxLastSyncAt;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Set extrabuxRawUserData
     *
     * @param string $extrabuxRawUserData
     * @return User
     */
    public function setExtrabuxRawUserData($extrabuxRawUserData)
    {
        $this->extrabuxRawUserData = $extrabuxRawUserData;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Get extrabuxRawUserData
     *
     * @return string
     */
    public function getExtrabuxRawUserData()
    {
        return $this->extrabuxRawUserData;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->payables = new ArrayCollection();
        $this->referredUsers = new ArrayCollection();
    }

    /**
     * Add payables
     *
     * @param \App\Entity\Payable $payables
     * @return User
     */
    public function addPayable(\App\Entity\Payable $payable)
    {
        $this->payables[] = $payable;

        return $this;
    }

    /**
     * Remove payables
     *
     * @param \App\Entity\Payable $payables
     */
    public function removePayable(\App\Entity\Payable $payable)
    {
        $this->payables->removeElement($payable);
    }

    /**
     * Get payables
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPayables()
    {
        return $this->payables;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return User
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return User
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set state
     *
     * @param string $state
     * @return User
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set zip
     *
     * @param string $zip
     * @return User
     */
    public function setZip($zip)
    {
        $this->zip = $zip;

        return $this;
    }

    /**
     * Get zip
     *
     * @return string
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return User
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
     * Set referredBy
     *
     * @param \App\Entity\User $referredBy
     * @return User
     */
    public function setReferredBy(\App\Entity\User $referredBy = null)
    {
        $this->referredBy = $referredBy;

        return $this;
    }

    /**
     * Get referredBy
     *
     * @return \App\Entity\User
     */
    public function getReferredBy()
    {
        return $this->referredBy;
    }

    /**
     * Add referredUsers
     *
     * @param \App\Entity\User $referredUsers
     * @return User
     */
    public function addReferredUser(\App\Entity\User $referredUser)
    {
        $this->referredUsers[] = $referredUser;

        return $this;
    }

    /**
     * Remove referredUsers
     *
     * @param \App\Entity\User $referredUsers
     */
    public function removeReferredUser(\App\Entity\User $referredUser)
    {
        $this->referredUsers->removeElement($referredUser);
    }

    /**
     * Get referredUsers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReferredUsers()
    {
        return $this->referredUsers;
    }

    /**
     * Count number of direct referrals (level 1)
     *
     * @return int
     */
    public function countDirectReferrals()
    {
        return $this->referredUsers->count();
    }

    /**
     * Count number of indirect referrals (level 2-7)
     */
    public function countIndirectReferrals($depth = 7)
    {
        $users = $this->referredUsers->toArray();
        $count = 0;
        for ($i = 2; $i <= $depth; $i++) {
            $next = [];
            foreach ($users as $user) {
                $count += $user->countDirectReferrals();
                $next = array_merge($next, $user->getReferredUsers()->toArray());
            }
            $users = $next;
        }

        return $count;
    }

    public function getReferralTree($level = 7)
    {
        $users = $this->referredUsers->toArray();
        $refUsers[1] = $users;

        for ($i = 2; $i <= $level; $i++) {
            $next = [];
            foreach ($users as $user) {
                $next = array_merge($next, $user->getReferredUsers()->toArray());
            }
            $users = $next;
            $refUsers[$i] = $users;
        }

        return $refUsers;
    }

    public function __toString()
    {
        return (string) $this->email;
    }

    /**
     * Implement the original hashing from legacy site
     */
    public static function passwordHash($plainPassword)
    {
        return sha1($plainPassword);
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set charity
     *
     * @param \App\Entity\Charity $charity
     * @return User
     */
    public function setCharity(\App\Entity\Charity $charity = null)
    {
        $this->charity = $charity;

        return $this;
    }

    /**
     * Get charity
     *
     * @return \App\Entity\Charity
     */
    public function getCharity()
    {
        return $this->charity;
    }
}
