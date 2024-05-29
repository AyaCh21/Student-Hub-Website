<?php

namespace App\Tests\Controller;

use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Student;
use PHPUnit\Framework\Attributes\DoesNotPerformAssertions;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

//======================================================================================================//
//Note: Tests: 3, Assertions: 19, Warnings: 2.
//      TODO application dont have valid pdf yet! valid path test to be added after pdf available.
//      this controller directs user into specific lecture page.
//      hence simple test of redirection and rendering added.
//=====================================================================================================//
class LectureControllerTest extends WebTestCase
{

    public function testLecturePage()
    {
        // PHPUnit 11 checks for any leftovers in error handlers, manual cleanup
        $prevHandler = set_exception_handler(null);

        try {
            $client = static::createClient();

            //login user
            $userRepository = static::getContainer()->get(StudentRepository::class);
            $testUser = $userRepository->findOneBy(['username' => 'dumb']);
            $client->loginUser($testUser);

            $crawler = $client->request('GET', '/lecture/1/lecture');
            $this->assertResponseIsSuccessful();
            $this->assertSame(200, $client->getResponse()->getStatusCode());
            $this->assertSelectorTextContains('h1', 'Fundamentals of Mathematics');
            $this->assertSelectorTextContains('h1', 'Lecture');
            $this->assertCount(2, $crawler->filter('.ratings-section'));
            $this->assertCount(1, $crawler->filter('.materials-section'));
            $this->assertCount(1, $crawler->filter('.comments-section'));
        } catch (\Exception $e) {
            // Handle the exception gracefully, for example:
            $this->fail('Exception caught during test: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        } finally {
            // Restore the previous exception handler
            set_exception_handler($prevHandler);
        }
    }

    public function testLabPage()
    {
        // PHPUnit 11 checks for any leftovers in error handlers, manual cleanup
        $prevHandler = set_exception_handler(null);

        try {
            $client = static::createClient();

            //login user
            $userRepository = static::getContainer()->get(StudentRepository::class);
            $testUser = $userRepository->findOneBy(['username' => 'dumb']);
            $client->loginUser($testUser);

            $crawler = $client->request('GET', '/lecture/1/lab');
            $this->assertResponseIsSuccessful();
            $this->assertSame(200, $client->getResponse()->getStatusCode());
            $this->assertSelectorTextContains('h1', 'Fundamentals of Mathematics');
            $this->assertSelectorTextContains('h1', 'Lab');
            $this->assertCount(2, $crawler->filter('.ratings-section'));
            $this->assertCount(1, $crawler->filter('.materials-section'));
            $this->assertCount(1, $crawler->filter('.comments-section'));
        } catch (\Exception $e) {
            // Handle the exception gracefully, for example:
            $this->fail('Exception caught during test: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        } finally {
            // Restore the previous exception handler
            set_exception_handler($prevHandler);
        }
    }


    public function testViewPdf()
    {
        // PHPUnit 11 checks for any leftovers in error handlers, manual cleanup
        $prevHandler = set_exception_handler(null);

        try {
            $client = static::createClient();

            //login user
            $userRepository = static::getContainer()->get(StudentRepository::class);
            $testUser = $userRepository->findOneBy(['username' => 'dumb']);
            $client->loginUser($testUser);

            $crawler = $client->request('GET', '/study_material/1/view_pdf');
            $this->assertSame(404, $client->getResponse()->getStatusCode());
            /**
             * Application dont have pdf yet! valid path to be added after pdf available.
             */

        } catch (\Exception $e) {
            // Handle the exception gracefully, for example:
            $this->fail('Exception caught during test: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        } finally {
            // Restore the previous exception handler
            set_exception_handler($prevHandler);
        }
    }


}
