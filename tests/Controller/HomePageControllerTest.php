<?php

namespace App\Tests\Controller;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Student;
use PHPUnit\Framework\Attributes\DoesNotPerformAssertions;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

class HomePageControllerTest extends WebTestCase
{
    protected static function createKernel(array $options = []): \Symfony\Component\HttpKernel\KernelInterface
    {
        // Use your AppKernel class name here
        return new \App\Kernel('test', true);
    }

    public function testDirectingToHome()
    {
        try {
            $client = static::createClient();
            $crawler = $client->request('GET', '/home');
            $this->assertResponseStatusCodeSame(200);
            $this->assertSelectorTextContains('.container-title', 'StudHub!');
        } catch (\Exception $e) {
            // Handle the exception gracefully, for example:
            $this->fail('Exception caught during test: ' . $e->getMessage());
        }
    }

    public function testProfileRedirectToLogin()
    {
        try {
            $client = static::createClient();
            $crawler = $client->request('GET', '/profile');
            $this->assertSame(302, $client->getResponse()->getStatusCode());
            $this->assertSame('/login', $client->getResponse()->headers->get('Location'));
        } catch (\Exception $e) {
            // Handle the exception gracefully, for example:
            $this->fail('Exception caught during test: ' . $e->getMessage());
        }
    }

    public function testProfileRedirectToProfile()
    {
        try {
            $client = static::createClient();
            $crawler = $client->request('GET', '/profile');
            // Replace this with actual logic to retrieve or create a user
            $user = new Student();

            $client->loginUser($user);
            $this->assertSame(302, $client->getResponse()->getStatusCode());
            $this->assertSame('/profile', $client->getResponse()->headers->get('Location'));
        } catch (\Exception $e) {
            // Handle the exception gracefully, for example:
            $this->fail('Exception caught during test: ' . $e->getMessage());
        }
    }


}
