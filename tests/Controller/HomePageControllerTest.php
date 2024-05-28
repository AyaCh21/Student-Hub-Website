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
        return new \App\Kernel('test', true);
    }


    public function testUnauthorizedDirectingToHome()
    {
        // PHPUnit 11 checks for any leftovers in error handlers, manual cleanup
        $prevHandler = set_exception_handler(null);

        try {
            $client = static::createClient();

            // Redirect to home while logged out
            $client->request('GET', '/logout');

            $crawler = $client->request('GET', '/home');
            $this->assertResponseStatusCodeSame(200);
            $this->assertSelectorTextContains('.container-title', 'StudHub!');
            $this->assertCount(1, $crawler->filter('a[href="/register"] input[type="button"][value="Join Now"]'));
        } catch (\Exception $e) {
            // Handle the exception gracefully
            $this->fail('Exception caught during test: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        } finally {
            // Restore the previous exception handler
            set_exception_handler($prevHandler);
        }
    }


    public function testAuthorizedDirectingToHome()
    {
        // PHPUnit 11 checks for any leftovers in error handlers, manual cleanup
        $prevHandler = set_exception_handler(null);

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
        }finally {
            // Restore the previous exception handler
            set_exception_handler($prevHandler);
        }
    }


    public function testDirectingToPolicy()
    {
        // PHPUnit 11 checks for any leftovers in error handlers, manual cleanup
        $prevHandler = set_exception_handler(null);

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
        }finally {
            // Restore the previous exception handler
            set_exception_handler($prevHandler);
        }
    }


    public function testDirectingToTeam()
    {
        // PHPUnit 11 checks for any leftovers in error handlers, manual cleanup
        $prevHandler = set_exception_handler(null);

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
        }finally {
            // Restore the previous exception handler
            set_exception_handler($prevHandler);
        }
    }


    public function testTeamPhotoDisplayOnTeam()
    {
        // PHPUnit 11 checks for any leftovers in error handlers, manual cleanup
        $prevHandler = set_exception_handler(null);

        try {
            $client = static::createClient();

            //redirect to team
            $crawler = $client->request('GET', '/team');
            $this->assertResponseStatusCodeSame(200);

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
        }finally {
            // Restore the previous exception handler
            set_exception_handler($prevHandler);
        }
    }

    public function testMemberCardDisplayOnTeam()
    {
        // PHPUnit 11 checks for any leftovers in error handlers, manual cleanup
        $prevHandler = set_exception_handler(null);

        try {
            $client = static::createClient();

            //redirect to team
            $crawler = $client->request('GET', '/team');
            $this->assertResponseStatusCodeSame(200);

            //test if personal member card exist
            $this->assertCount(6,$crawler->filter('.member-card'), 'Team member card no');

        } catch (\Exception $e) {
            // Handle the exception gracefully, for example:
            $this->fail('Exception caught during test: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }finally {
            // Restore the previous exception handler
            set_exception_handler($prevHandler);
        }
    }


    public function testMemberCaptionDisplayOnTeam()
    {
        // PHPUnit 11 checks for any leftovers in error handlers, manual cleanup
        $prevHandler = set_exception_handler(null);

        try {
            $client = static::createClient();

            //redirect to team
            $crawler = $client->request('GET', '/team');
            $this->assertResponseStatusCodeSame(200);

            //test if figure caption correct
            $captions = [
                'Reach Wiktoria',
                'Reach Bolin',
                'Reach Rohan',
                'Reach Dele',
                'Reach Aya',
                'Reach Wen',
            ];
            foreach ($captions as $caption) {
                $selector = sprintf('figcaption:contains("%s")', $caption);
                $imageElement = $crawler->filter($selector);
                $this->assertNotEmpty($imageElement, sprintf('team member link "%s" vanished', $caption));
            }

        } catch (\Exception $e) {
            // Handle the exception gracefully, for example:
            $this->fail('Exception caught during test: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }finally {
            // Restore the previous exception handler
            set_exception_handler($prevHandler);
        }
    }


    public function testMemberHyperlinkDisplayOnTeam()
    {
        // PHPUnit 11 checks for any leftovers in error handlers, manual cleanup
        $prevHandler = set_exception_handler(null);

        try {
            $client = static::createClient();

            //redirect to team
            $crawler = $client->request('GET', '/team');
            $this->assertResponseStatusCodeSame(200);

            //test if reach member hyperlink is correct
            $links = [
                'https://www.youtube.com/watch?v=L5inD4XWz4U',
                'https://www.youtube.com/watch?v=L5inD4XWz4U',
                'https://www.instagram.com/ro_han_1513?igsh=MW1zcWEzaWk5cDNsdA%3D%3D&utm_source=qr',
                'https://www.youtube.com/watch?v=L5inD4XWz4U',
                'https://www.linkedin.com/in/aya-chaouni-benabdallah-341537233?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=ios_app',
                'https://www.youtube.com/watch?v=L5inD4XWz4U',
            ];
            foreach ($links as $link) {
                $selector = sprintf('a[href="%s"]', $link);
                $linkElement = $crawler->filter($selector);
                $this->assertNotEmpty($linkElement, sprintf('team member "%s" vanished', $link));
            }

            //test if team member intro is correct
            $intros = [
                'Problem-solving is my superpower',
                'I bring the thrill of skydiving to brainstorming sessions',
                'Gamers, cubers, and fellow royals, unite!',
                'Coder by day, entrepreneur in my dreams',
                'I code like a champion and fuel team spirit',
                'By day, I build software empires. By night,',
            ];

            foreach ($intros as $intro) {
                $introElement = $crawler->filter('div.member-description');
                $this->assertGreaterThan(0, $introElement->count(), sprintf('Team intro containing "%s" vanished', $intro));
                $found = false;
                foreach ($introElement as $element) {
                    if (str_contains($element->textContent, $intro)) {
                        $found = true;
                        break;
                    }
                }
                $this->assertTrue($found, sprintf('Team intro "%s" does not match any element text', $intro));
            }



        } catch (\Exception $e) {
            // Handle the exception gracefully, for example:
            $this->fail('Exception caught during test: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }finally {
            // Restore the previous exception handler
            set_exception_handler($prevHandler);
        }
    }


    public function testMemberIntroDisplayOnTeam()
    {
        // PHPUnit 11 checks for any leftovers in error handlers, manual cleanup
        $prevHandler = set_exception_handler(null);

        try {
            $client = static::createClient();

            //redirect to team
            $crawler = $client->request('GET', '/team');
            $this->assertResponseStatusCodeSame(200);

            //test if team member intro is correct
            $intros = [
                'Problem-solving is my superpower',
                'I bring the thrill of skydiving to brainstorming sessions',
                'Gamers, cubers, and fellow royals, unite!',
                'Coder by day, entrepreneur in my dreams',
                'I code like a champion and fuel team spirit',
                'By day, I build software empires. By night,',
            ];

            foreach ($intros as $intro) {
                $introElement = $crawler->filter('div.member-description');
                $this->assertGreaterThan(0, $introElement->count(), sprintf('Team intro containing "%s" vanished', $intro));
                $found = false;
                foreach ($introElement as $element) {
                    if (str_contains($element->textContent, $intro)) {
                        $found = true;
                        break;
                    }
                }
                $this->assertTrue($found, sprintf('Team intro "%s" does not match any element text', $intro));
            }



        } catch (\Exception $e) {
            // Handle the exception gracefully, for example:
            $this->fail('Exception caught during test: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }finally {
            // Restore the previous exception handler
            set_exception_handler($prevHandler);
        }
    }

}
