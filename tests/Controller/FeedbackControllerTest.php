<?php

namespace App\Tests\Controller;

use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Student;
use PHPUnit\Framework\Attributes\DoesNotPerformAssertions;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

//======================================================================================================//
//Note:
//      this controller directs user into specific feedback page.
//      hence simple test of redirection and rendering added.
//=====================================================================================================//
class FeedbackControllerTest extends WebTestCase
{

    public function testFeedbackDisplay()
    {
        // PHPUnit 11 checks for any leftovers in error handlers, manual cleanup
        $prevHandler = set_exception_handler(null);

        try {
            $client = static::createClient();

            //login user
            $userRepository = static::getContainer()->get(StudentRepository::class);
            $testUser = $userRepository->findOneBy(['username' => 'dumb']);
            $client->loginUser($testUser);

            $crawler = $client->request('GET', '/feedbacks/1');
            $this->assertResponseIsSuccessful();
            $this->assertSame(200, $client->getResponse()->getStatusCode());
            $this->assertSelectorTextContains('h1', 'Provide Feedback');
        } catch (\Exception $e) {
            // Handle the exception gracefully, for example:
            $this->fail('Exception caught during test: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        } finally {
            // Restore the previous exception handler
            set_exception_handler($prevHandler);
        }
    }

    public function testViewFeedback()
    {

    }

    public function testFeedbackprof()
    {

    }

    public function testViewFeedbacks()
    {

    }
}
