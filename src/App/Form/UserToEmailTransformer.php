<?php

namespace App\Form;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;

class UserToEmailTransformer implements DataTransformerInterface
{
    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    /**
     * Transforms an object (user) to a string (email).
     *
     * @param  User|null $user
     * @return string
     */
    public function transform($user)
    {
        if (null === $user) {
            return "";
        }

        return $user->getEmail();
    }

    /**
     * Transforms a string (email) to an object (user).
     *
     * @param  string $email
     *
     * @return User|null
     *
     * @throws TransformationFailedException if object (user) is not found.
     */
    public function reverseTransform($email)
    {
        if (!$email) {
            return null;
        }

        $user = $this->om
            ->getRepository('App\Entity\User')
            ->findOneBy(array('email' => $email))
        ;

        if (null === $user) {
            throw new TransformationFailedException(sprintf(
                'An user with email "%s" does not exist!',
                $email
            ));
        }

        return $user;
    }
}
