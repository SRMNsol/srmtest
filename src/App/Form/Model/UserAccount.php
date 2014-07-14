<?php

namespace App\Form\Model;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\GroupSequenceProviderInterface;
use App\Entity\User;

class UserAccount implements GroupSequenceProviderInterface
{
    /**
     * @Assert\Type(type="App\Entity\User")
     * @Assert\Valid()
     */
    protected $user;

    protected $editPassword = false;

    /**
     * @Assert\NotBlank(groups={"EditPassword"})
     */
    protected $newPassword;

    public function getGroupSequence()
    {
        $groups = ['User'];

        if ($this->editPassword) {
            $groups[] = 'EditPassword';
        }

        return $groups;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    public function getEditPassword()
    {
        return $this->editPassword;
    }

    public function setEditPassword($value)
    {
        $this->editPassword = (boolean) $value;
    }

    public function getNewPassword()
    {
        return $this->newPassword;
    }

    public function setNewPassword($password)
    {
        $this->newPassword = $password;

        return $this;
    }
}
