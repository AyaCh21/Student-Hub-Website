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

            ////redirect to team while logged in
            $userRepository = static::getContainer()->get(StudentRepository::class);
            $testUser = $userRepository->findOneBy(['username'=>'dumb']);
            $client->loginUser($testUser);

            $crawler = $client->request('GET', '/team');
            $this->assertResponseStatusCodeSame(200);

            //test discription exist
            $this->assertCount(1,$crawler->filter('div.team-description.is-size-3-desktop.is-size-5-mobile'), 'Team description no');
            $this->assertStringStartsWith("We're a passionate group of engineering students at KU Leuven", $crawler->filter('div.team-description.is-size-3-desktop.is-size-5-mobile')->text(),"Team discription wrong text" );

            ////redirect to team while logged out
            $client->request('GET', '/logout');

            $crawler = $client->request('GET', '/team');
            $this->assertResponseStatusCodeSame(200);

            //test discription exist
            $this->assertCount(1,$crawler->filter('div.team-description.is-size-3-desktop.is-size-5-mobile'), 'Team description no');
            $this->assertStringStartsWith("We're a passionate group of engineering students at KU Leuven", $crawler->filter('div.team-description.is-size-3-desktop.is-size-5-mobile')->text(),"Team discription wrong text" );


        } catch (\Exception $e) {
            // Handle the exception gracefully, for example:
            $this->fail('Exception caught during test: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }


    public function testElementDisplayOnTeam()
    {
        try {
            $client = static::createClient();

            //redirect to team
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

            //test if personal member card exist
            $this->assertCount(6,$crawler->filter('.member-card'), 'Team member card no');

            //test if figure caption correct
            $captions = [
                'Reach Wiktoria',
                'Reach Bolin',
                'Reach Rohan',
                'Reach Dele',
                'Reach Aya',
                'Reach Wen',
            ];
            foreach ($captions as $captionName) {
                $selector = sprintf('figcaption:contains("%s")', $captionName);
                $imageElement = $crawler->filter($selector);
                $this->assertNotEmpty($imageElement, sprintf('team member link "%s" vanished', $captionName));
            }

            //test if reach member hyperlink is correct
            $links = [
                'https://www.youtube.com/watch?v=L5inD4XWz4U',
                'https://www.youtube.com/watch?v=L5inD4XWz4U',
                'https://www.instagram.com/ro_han_1513?igsh=MW1zcWEzaWk5cDNsdA%3D%3D&utm_source=qr',
                'https://www.youtube.com/watch?v=L5inD4XWz4U',
                'https://www.linkedin.com/in/aya-chaouni-benabdallah-341537233?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=ios_app',
                'https://www.youtube.com/watch?v=L5inD4XWz4U',
            ];
            foreach ($links as $linkName) {
                $selector = sprintf('a[href="%s"]', $linkName);
                $linkElement = $crawler->filter($selector);
                $this->assertNotEmpty($linkElement, sprintf('team member "%s" vanished', $linkName));
            }



        } catch (\Exception $e) {
            // Handle the exception gracefully, for example:
            $this->fail('Exception caught during test: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }


}
