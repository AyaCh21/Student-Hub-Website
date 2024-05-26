<?php


namespace App\Tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testConstructorAndGetters()
    {
        $username = 'testuser';
        $password = 'password123';
        $email = 'testuser@example.com';
        $id = 1;

        $user = new User($username, $password, $email, $id);

        $this->assertEquals($id, $user->getId());
        $this->assertEquals($username, $user->getUsername());
        $this->assertEquals($email, $user->getEmail());
        $this->assertEquals($password, $user->getPassword());
    }

    public function testSetEmail()
    {
        $user = new User('testuser', 'password123', 'testuser@example.com');
        $user->setEmail('newemail@example.com');
        $this->assertEquals('newemail@example.com', $user->getEmail());
    }

    public function testGetUserIdentifier()
    {
        $user = new User('testuser', 'password123', 'testuser@example.com');
        $this->assertEquals('testuser@example.com', $user->getUserIdentifier());
    }

    public function testGetAndSetRoles()
    {
        $user = new User('testuser', 'password123', 'testuser@example.com');
        $roles = ['ROLE_ADMIN', 'ROLE_USER'];
        $user->setRoles($roles);
        $this->assertEquals(['ROLE_ADMIN', 'ROLE_USER'], $user->getRoles());
    }

    public function testSetPassword()
    {
        $user = new User('testuser', 'password123', 'testuser@example.com');
        $user->setPassword('newpassword123');
        $this->assertEquals('newpassword123', $user->getPassword());
    }

    public function testGetAndSetPhase()
    {
        $user = new User('testuser', 'password123', 'testuser@example.com');
        $user->setPhase(2);
        $this->assertEquals(2, $user->getPhase());
    }

    public function testGetAndSetSpecialization()
    {
        $user = new User('testuser', 'password123', 'testuser@example.com');
        $user->setSpecialization('Math');
        $this->assertEquals('Math', $user->getSpecialization());
    }

    public function testGetAndSetNewUser()
    {
        $user = new User('testuser', 'password123', 'testuser@example.com');
        $user->setNewUser(1);
        $this->assertEquals(1, $user->getNewUser());
    }

    public function testEraseCredentials()
    {
        $user = new User('testuser', 'password123', 'testuser@example.com');
        $user->eraseCredentials();
        $this->assertTrue(true); // Simply ensure the method can be called without error
    }
}
