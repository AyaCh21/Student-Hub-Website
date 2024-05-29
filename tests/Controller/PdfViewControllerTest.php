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
//      this controller contains only indexing.
//      single test added.
//=====================================================================================================//
class PdfViewControllerTest extends WebTestCase
{
    /**
     * Controller is not used anymore.
     */
//    public function testIndexing()
//    {
//        // PHPUnit 11 checks for any leftovers in error handlers, manual cleanup
//        $prevHandler = set_exception_handler(null);
//
//        try {
//            $client = static::createClient();
//
//            $client->request('GET', '/pdf/view');
//
//            $this->assertResponseIsSuccessful();
//            $this->assertResponseStatusCodeSame(200);
//            $this->assertSelectorTextContains('h1', 'Login Page');
//
//        } catch (\Exception $e) {
//            // Handle the exception gracefully, for example:
//            $this->fail('Exception caught during test: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
//        } finally {
//            // Restore the previous exception handler
//            set_exception_handler($prevHandler);
//        }
//    }
}
