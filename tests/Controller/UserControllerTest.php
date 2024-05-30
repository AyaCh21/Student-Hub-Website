<?php

namespace App\Tests\Controller;

use App\Kernel;
use App\Repository\StudentRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Student;
use PHPUnit\Framework\Attributes\DoesNotPerformAssertions;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\KernelInterface;

class UserControllerTest extends WebTestCase
{
    protected static function createKernel(array $options = []): KernelInterface
    {
        // Use your AppKernel class name here
        return new Kernel('test', true);
    }

    public function testLoginPageRedirectSuccessful()
    {
        // PHPUnit 11 checks for any leftovers in error handlers, manual cleanup
        $prevHandler = set_exception_handler(null);

        try {
            $client = static::createClient();

            $client->request('GET', '/login');

            $this->assertResponseIsSuccessful();
            $this->assertResponseStatusCodeSame(200);
            $this->assertSelectorTextContains('h1', 'Login');

        } catch (Exception $e) {
            // Handle the exception gracefully, for example:
            $this->fail('Exception caught during test: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        } finally {
            // Restore the previous exception handler
            set_exception_handler($prevHandler);
        }
    }



    //in this test, examine whether the redirecting is successful while a unauthorized user is trying to access profile page
    public function testUnauthenticatedProfileRedirect()
    {
        // PHPUnit 11 checks for any leftovers in error handlers, manual cleanup
        $prevHandler = set_exception_handler(null);

        try {
            $client = static::createClient();

            $client->request('GET', '/logout');

            $client->request('GET', '/home');
            $this->assertResponseStatusCodeSame(200);
            $this->assertSelectorTextContains('.container-title', 'StudHub!');

            $crawler = $client->request('GET', '/profile');
            $this->assertSame(302, $client->getResponse()->getStatusCode());
            $this->assertSame('/login', $client->getResponse()->headers->get('Location'));
            $crawler = $client->followRedirect();
            $this->assertSelectorTextContains('h1', 'Login');
        } catch (Exception $e) {
            // Handle the exception gracefully, for example:
            $this->fail('Exception caught during test: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        } finally {
            // Restore the previous exception handler
            set_exception_handler($prevHandler);
        }
    }

    public function testAuthenticatedProfileRedirect()
    {
        // PHPUnit 11 checks for any leftovers in error handlers, manual cleanup
        $prevHandler = set_exception_handler(null);

        try {
            $client = static::createClient();

            //login user
            $userRepository = static::getContainer()->get(StudentRepository::class);
            $testUser = $userRepository->findOneBy(['username'=>'dumb']);
            $client->loginUser($testUser);

            $crawler = $client->request('GET', '/profile');
            $this->assertResponseIsSuccessful();
            $this->assertSame(200, $client->getResponse()->getStatusCode());
            $this->assertSelectorTextContains('h3', 'Your Profile');
        } catch (Exception $e) {
            // Handle the exception gracefully, for example:
            $this->fail('Exception caught during test: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }finally {
            // Restore the previous exception handler
            set_exception_handler($prevHandler);
        }
    }

}
