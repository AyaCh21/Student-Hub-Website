<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

class UserRepository extends EntityRepository implements PasswordUpgraderInterface
{
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        // set the new hashed password on the User object
        $user->setPassword($newHashedPassword);

        // execute the queries on the database
        $this->getEntityManager()->flush();
    }
}