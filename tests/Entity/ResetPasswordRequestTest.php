<?php

namespace App\Tests\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\ResetPasswordRequest;
use App\Entity\Student;

class ResetPasswordRequestTest extends TestCase
{
    public function testConstructorAndGetters()
    {
        $user = new Student();
        $expiresAt = new \DateTimeImmutable('+1 hour');
        $selector = 'dummy_selector';
        $hashedToken = 'dummy_hashed_token';

        $resetPasswordRequest = new ResetPasswordRequest($user, $expiresAt, $selector, $hashedToken);

        $this->assertSame($user, $resetPasswordRequest->getUser());
        $this->assertEquals($expiresAt, $resetPasswordRequest->getExpiresAt());
        $this->assertEquals($hashedToken, $resetPasswordRequest->getHashedToken());
    }

    public function testGetId()
    {
        $resetPasswordRequest = new ResetPasswordRequest(new Student(), new \DateTimeImmutable('+1 hour'), 'selector', 'hashed_token');

        $reflection = new \ReflectionClass($resetPasswordRequest);
        $property = $reflection->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($resetPasswordRequest, 1);

        $this->assertEquals(1, $resetPasswordRequest->getId());
    }

}