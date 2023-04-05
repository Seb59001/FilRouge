<?php


namespace App\EntityListener;

use App\Entity\Users;
use App\EntityListener;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserListener
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function prePersist(Users $users)
    {
        $this->encodePassword($users);
    }

    public function preUpdate(Users $users)
    {
        $this->encodePassword($users);
    }

    /**
     * encoder le mot de passe en se basant sur un mot de passe simple
     *
     * @param Users $user
     * @return void
     */
    public function encodePassword(Users $users)
    {
        if ($users->getPlainPassword() === null) {
            return;
        }
        $users->setPassword(
            $this->hasher->hashPassword(
                $users,
                $users->getPlainPassword()
            )
        );
       
    }
}