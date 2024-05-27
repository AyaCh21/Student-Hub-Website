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
    public function testUnauthorizedDirectingToHome()
    {
        try {
            $client = static::createClient();

            //redirect to home while logged out
            $client->request('GET', '/logout');
            $crawler = $client->request('GET', '/home');
            $this->assertResponseStatusCodeSame(200);
            $this->assertSelectorTextContains('.container-title', 'StudHub!');
            $this->assertCount(1, $crawler->filter('a[href="/register"] input[type="button"][value="Join Now"]'));

            } catch (\Exception $e) {
            // Handle the exception gracefully, for example:
            $this->fail('Exception caught during test: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }

    public function testAuthorizedDirectingToHome()
    {
        try {
            $client = static::createClient();

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

    public function testDirectingToPolicy()
    {
        try {
            $client = static::createClient();


            $crawler = $client->request('GET', '/home');
            $this->assertResponseStatusCodeSame(200);
            $this->assertSelectorTextContains('.container-title', 'StudHub!');

            $this->assertCount(1, $crawler->filter('a[href="https://admin.kuleuven.be/privacy/en/"]'));
            $this->assertSame('Privacy Policy', $crawler->filter('a[href="https://admin.kuleuven.be/privacy/en/"]')->text(), 'Link text wrong.');

            $this->assertCount(1, $crawler->filter('a[href="https://admin.kuleuven.be/icts/english/cookiepolicy/"]'));
            $this->assertSame('Terms of Use', $crawler->filter('a[href="https://admin.kuleuven.be/icts/english/cookiepolicy/"]')->text(), 'Link text wrong.');

        } catch (\Exception $e) {
            // Handle the exception gracefully, for example:
            $this->fail('Exception caught during test: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }

    public function testDirectingToTeam()
    {
        try {
            $client = static::createClient();

            //redirect to home while logged in
            $userRepository = static::getContainer()->get(StudentRepository::class);
            $testUser = $userRepository->findOneBy(['username'=>'dumb']);
            $client->loginUser($testUser);

            $crawler = $client->request('GET', '/team');
            $this->assertResponseStatusCodeSame(200);

            //test discription exist
            $this->assertCount(1,$crawler->filter('div.team-description.is-size-3-desktop.is-size-5-mobile'), 'Team description no');
            $this->assertStringStartsWith("We're a passionate group of engineering students at KU Leuven", $crawler->filter('div.team-description.is-size-3-desktop.is-size-5-mobile')->text(),"Team discription wrong text" );

            //test if team photo exist
            $images = [
                'team_img1.jpeg',
                'team_img2.jpeg',
                'team_img3.jpeg',
                'team_img_4.jpeg',
            ];
            foreach ($images as $imageName) {
                $selector = sprintf('img[src$="%s"]', $imageName);
                $imageElement = $crawler->filter($selector);
                $this->assertNotEmpty($imageElement, sprintf('team "%s" vanished', $imageName));
            }

        } catch (\Exception $e) {
            // Handle the exception gracefully, for example:
            $this->fail('Exception caught during test: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }

}
