<?php

namespace App\Tests\Controller;

use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Student;
use PHPUnit\Framework\Attributes\DoesNotPerformAssertions;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;


//=====================================================================//
//Note: this controller revolves the use of an actual email,
//      hence only test the render and redirections.
//=====================================================================//
class ResetPasswordControllerTest extends WebTestCase
{

    public function testCheckEmailPage()
    {
        // PHPUnit 11 checks for any leftovers in error handlers, manual cleanup
        $prevHandler = set_exception_handler(null);

        try {
            $client = static::createClient();

            $client->request('GET', '/reset-password/check-email');

            $this->assertResponseIsSuccessful();
            $this->assertResponseStatusCodeSame(200);
            $this->assertSelectorTextContains('p', 'If an account matching');

        } catch (\Exception $e) {
            // Handle the exception gracefully, for example:
            $this->fail('Exception caught during test: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        } finally {
            // Restore the previous exception handler
            set_exception_handler($prevHandler);
        }
    }

    public function testReset()
    {

    }

    public function testResetPasswordRequestPage()
    {
        // PHPUnit 11 checks for any leftovers in error handlers, manual cleanup
        $prevHandler = set_exception_handler(null);

        try {
            $client = static::createClient();

            $client->request('GET', '/reset-password');

            $this->assertResponseIsSuccessful();
            $this->assertResponseStatusCodeSame(200);
            $this->assertSelectorTextContains('h1', 'Reset your password');

        } catch (\Exception $e) {
            // Handle the exception gracefully, for example:
            $this->fail('Exception caught during test: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        } finally {
            // Restore the previous exception handler
            set_exception_handler($prevHandler);
        }
    }


}
