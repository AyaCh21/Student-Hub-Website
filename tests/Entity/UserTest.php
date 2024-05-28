<?php


namespace App\Tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testConstructorAndGetters()
    {
        $username = 'user';
        $password = 'password123';
        $email = 'boa@gmail.com';
        $id = 1;

        $user = new User($username, $password, $email, $id);

        $this->assertEquals($id, $user->getId());
        $this->assertEquals($username, $user->getUsername());
        $this->assertEquals($email, $user->getEmail());
        $this->assertEquals($password, $user->getPassword());
    }

    public function testSetEmail()
    {
        $user = new User('user', 'password123', 'boa@gmail.com');
        $user->setEmail('newemail@gmail.com');
        $this->assertEquals('newemail@gmail.com', $user->getEmail());
    }

    public function testGetUserIdentifier()
    {
        $user = new User('user', 'password123', 'boa@gmail.com');
        $this->assertEquals('boa@gmail.com', $user->getUserIdentifier());
    }

    public function testGetAndSetRoles()
    {
        $user = new User('user', 'password123', 'boa@gmail.com');
        $roles = ['ROLE_ADMIN', 'ROLE_USER'];
        $user->setRoles($roles);
        $this->assertEquals(['ROLE_ADMIN', 'ROLE_USER'], $user->getRoles());
    }

    public function testSetPassword()
    {
        $user = new User('user', 'password123', 'boa@gmail.com');
        $user->setPassword('newpassword123');
        $this->assertEquals('newpassword123', $user->getPassword());
    }

    public function testGetAndSetPhase()
    {
        $user = new User('user', 'password123', 'boa@gmail.com');
        $user->setPhase(2);
        $this->assertEquals(2, $user->getPhase());
    }

    public function testGetAndSetSpecialization()
    {
        $user = new User('user', 'password123', 'boa@gmail.com');
        $user->setSpecialization('Math');
        $this->assertEquals('Math', $user->getSpecialization());
    }

    public function testGetAndSetNewUser()
    {
        $user = new User('user', 'password123', 'boa@gmail.com');
        $user->setNewUser(1);
        $this->assertEquals(1, $user->getNewUser());
    }

    public function testEraseCredentials()
    {
        $user = new User('user', 'password123', 'boa@gmail.com');
        $user->eraseCredentials();
        $this->assertTrue(true);
    }
}
