<?php

namespace App\Tests\Controller;

use App\Repository\StudentRepository;
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

    //test redirecting to home page while authenticated and not authenticated
    public function testDirectingToHome()
    {
        try {
            $client = static::createClient();

            //redirect to home while logged out
            $client->request('GET', '/logout');
            $crawler = $client->request('GET', '/home');
            $this->assertResponseStatusCodeSame(200);
            $this->assertSelectorTextContains('.container-title', 'StudHub!');
            $this->assertCount(1, $crawler->filter('a[href="/register"] input[type="button"][value="Join Now"]'));

            //redirect to home while logged in
            $userRepository = static::getContainer()->get(StudentRepository::class);
            $testUser = $userRepository->findOneBy(['username'=>'dumb']);
            $client->loginUser($testUser);

            $crawler = $client->request('GET', '/home');
            $this->assertResponseStatusCodeSame(200);
            $this->assertSelectorTextContains('.container-title', 'StudHub!');
            $this->assertCount(1, $crawler->filter('a[href="/study"] input[type="button"][value="Study Now!"]'));
        } catch (\Exception $e) {
            // Handle the exception gracefully, for example:
            $this->fail('Exception caught during test: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }




}
