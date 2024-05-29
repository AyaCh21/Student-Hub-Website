<?php

namespace App\Tests\Controller;

use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Student;
use PHPUnit\Framework\Attributes\DoesNotPerformAssertions;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

//======================================================================================================//
//Note: Tests: 18, Assertions: 111, Warnings: 2.
//      this controller uses JSOn to fetch all necessary course data at loading, most functionality implemented by JavaScript.
//      hence simple test added to check redirection successful.
//=====================================================================================================//
class StudyControllerTest extends WebTestCase
{

    /**
     * Note: Redirection to this page under the condition of whether authenticated or not has been tested in UserControllerTest
     **/


    public function testStudySectionCompleteness()
    {
        // PHPUnit 11 checks for any leftovers in error handlers, manual cleanup
        $prevHandler = set_exception_handler(null);

        try {
            $client = static::createClient();

            //login user
            $userRepository = static::getContainer()->get(StudentRepository::class);
            $testUser = $userRepository->findOneBy(['username' => 'dumb']);
            $client->loginUser($testUser);

            $crawler = $client->request('GET', '/study');
            $this->assertResponseIsSuccessful();
            $this->assertSame(200, $client->getResponse()->getStatusCode());
            $this->assertSelectorTextContains('h2', 'FavoriteCourse');
            $this->assertCount(1, $crawler->filter('.search-form'));
            $this->assertCount(1, $crawler->filter('.favorite-wrapper'));
            $this->assertCount(1, $crawler->filter('.phases-wrapper'));
            $this->assertCount(4, $crawler->filter('.phase-wrapper'));
        } catch (\Exception $e) {
            // Handle the exception gracefully, for example:
            $this->fail('Exception caught during test: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        } finally {
            // Restore the previous exception handler
            set_exception_handler($prevHandler);
        }
    }


    public function testToggleFavorite()
    {
        // PHPUnit 11 checks for any leftovers in error handlers, manual cleanup
        $prevHandler = set_exception_handler(null);

        try {
            $client = static::createClient();

            //login user
            $userRepository = static::getContainer()->get(StudentRepository::class);
            $testUser = $userRepository->findOneBy(['username' => 'dumb']);
            $client->loginUser($testUser);

            $crawler = $client->request('GET', '/study');
            $this->assertResponseIsSuccessful();
            $this->assertSame(200, $client->getResponse()->getStatusCode());
            $this->assertSelectorTextContains('h2', 'FavoriteCourse');
        } catch (\Exception $e) {
            // Handle the exception gracefully, for example:
            $this->fail('Exception caught during test: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        } finally {
            // Restore the previous exception handler
            set_exception_handler($prevHandler);
        }
    }


}
