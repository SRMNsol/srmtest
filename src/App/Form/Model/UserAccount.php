<?php

namespace App\Form\Model;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\GroupSequenceProviderInterface;
use App\Entity\User;

class UserAccount implements GroupSequenceProviderInterface
{
    protected $user;
    protected $editPassword = false;
    protected $newPassword;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('user', new Assert\Type([
            'type' => 'App\Entity\User'
        ]));
        $metadata->addPropertyConstraint('user', new Assert\Valid());
        $metadata->addPropertyConstraint('newPassword', new Assert\NotBlank([
            'groups' => ['EditPassword']
        ]));
        $metadata->setGroupSequenceProvider(true);
    }

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
