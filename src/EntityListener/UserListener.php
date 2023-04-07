<?php


namespace App\EntityListener;

use App\Entity\Users;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserListener
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function prePersist(Users $user)
    {
        $this->encodePassword($user);
    }

 

    /**
     * encoder le mot de passe en se basant sur un mot de passe simple
     *
     * @param Users $user
     * @return void
     */
    public function encodePassword(Users $user)
    {
        if ($user->getPlainPassword() === null) {
            return;
        }
        $user->setPassword(
            $this->hasher->hashPassword(
                $user,
                $user->getPlainPassword()
            )
        );

    }
}