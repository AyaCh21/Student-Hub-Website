<?php

namespace App\Tests\Controller;

use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Student;
use PHPUnit\Framework\Attributes\DoesNotPerformAssertions;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

class UserControllerTest extends WebTestCase
{
    protected static function createKernel(array $options = []): \Symfony\Component\HttpKernel\KernelInterface
    {
        // Use your AppKernel class name here
        return new \App\Kernel('test', true);
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
            $this->assertSelectorTextContains('h1', 'Login Page');

        } catch (\Exception $e) {
            // Handle the exception gracefully, for example:
            $this->fail('Exception caught during test: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        } finally {
            // Restore the previous exception handler
            set_exception_handler($prevHandler);
        }
    }


    public function testLoginPageFormExist()
    {
        // PHPUnit 11 checks for any leftovers in error handlers, manual cleanup
        $prevHandler = set_exception_handler(null);

        try {
            $client = static::createClient();

            $client->request('GET', '/login');

            $this->assertResponseIsSuccessful();
            $this->assertSelectorExists('form');
            $this->assertSelectorExists('input[name="_username"]');
            $this->assertSelectorExists('input[name="_password"]');
            $this->assertSelectorExists('input[name="_remember_me"]');
            $this->assertSelectorExists('a[href="/register"] input[type="button"][value="Register Now"]');
            $this->assertSelectorExists('a[href="/reset-password"] input[type="button"][value="Oops I forgot my password"]');
        } catch (\Exception $e) {
            // Handle the exception gracefully, for example:
            $this->fail('Exception caught during test: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        } finally {
            // Restore the previous exception handler
            set_exception_handler($prevHandler);
        }
    }


    public function testExistUserLogin()
    {
        // PHPUnit 11 checks for any leftovers in error handlers, manual cleanup
        $prevHandler = set_exception_handler(null);

        try {
            $client = static::createClient();
            $client->followRedirects();
            $crawler =$client->request('GET', '/login');

            $form = $crawler->selectButton('Login')->form();
            $form['_username'] = "dumb";
            $form['_password'] = "dumb";
            $form['_remember_me']->tick();
            $client->submit($form);
//            $crawler = $client->submitForm('Login', [
//                'username' => 'dumb',
//                'password' => 'dumb',
//                'remember_me' => false,
//            ]);
            $this->assertSame(200, $client->getResponse()->getStatusCode());

            $crawler =$client->request('GET', '/home');
            $this->assertSelectorTextContains('.container-title', 'StudHub!');
            $this->assertCount(1, $crawler->filter('a[href="/study"] input[type="button"][value="Study Now!"]'));

        } catch (\Exception $e) {
            // Handle the exception gracefully, for example:
            $this->fail('Exception caught during test: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        } finally {
            // Restore the previous exception handler
            set_exception_handler($prevHandler);
        }
    }


    public function testNonExistUserLogin()
    {
        // PHPUnit 11 checks for any leftovers in error handlers, manual cleanup
        $prevHandler = set_exception_handler(null);

        try {
            $client = static::createClient();
            $client->followRedirects();
            $crawler =$client->request('GET', '/login');

            $form = $crawler->selectButton('Login')->form();
            $form['_username'] = "no";
            $form['_password'] = "no";
            $form['_remember_me']->tick();
            $client->submit($form);
//            $crawler = $client->submitForm('Login', [
//                'username' => 'dumb',
//                'password' => 'dumb',
//                'remember_me' => false,
//            ]);
            $this->assertSame(200, $client->getResponse()->getStatusCode());
            $this->assertSelectorTextContains('h1', 'Login Page');

            $crawler = $client->request('GET', '/home');
            $this->assertResponseStatusCodeSame(200);
            $this->assertSelectorTextContains('.container-title', 'StudHub!');
            $this->assertCount(1, $crawler->filter('a[href="/register"] input[type="button"][value="Join Now"]'));
        } catch (\Exception $e) {
            // Handle the exception gracefully, for example:
            $this->fail('Exception caught during test: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        } finally {
            // Restore the previous exception handler
            set_exception_handler($prevHandler);
        }
    }


    public function testRegisterPageRedirectSuccessful()
    {
        // PHPUnit 11 checks for any leftovers in error handlers, manual cleanup
        $prevHandler = set_exception_handler(null);

        try {
            $client = static::createClient();
//            $client->followRedirects();

            // Request the login page
            $crawler = $client->request('GET', '/register');

            $this->assertResponseIsSuccessful();
            $this->assertResponseStatusCodeSame(200);
            $this->assertSelectorTextContains('.container-title', 'Register');

        } catch (\Exception $e) {
            // Handle the exception gracefully, for example:
            $this->fail('Exception caught during test: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        } finally {
            // Restore the previous exception handler
            set_exception_handler($prevHandler);
        }
    }


    public function testRegisterPageFormExist()
    {
        // PHPUnit 11 checks for any leftovers in error handlers, manual cleanup
        $prevHandler = set_exception_handler(null);

        try {
            $client = static::createClient();

            $client->request('GET', '/register');

            $this->assertResponseIsSuccessful();
            $this->assertSelectorExists('form');
            $this->assertSelectorExists('input[name="_username"]');
            $this->assertSelectorExists('input[name="_email"]');
            $this->assertSelectorExists('input[name="_password_1"]');
            $this->assertSelectorExists('input[name="_password_2"]');
            $this->assertSelectorExists('select[name="_specialization"]');
            $this->assertSelectorExists('select[name="_phase"]');
            $this->assertSelectorExists('button[type="submit"].btn');
            $this->assertSelectorExists('a[href="/login"]');
        } catch (\Exception $e) {
            // Handle the exception gracefully, for example:
            $this->fail('Exception caught during test: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        } finally {
            // Restore the previous exception handler
            set_exception_handler($prevHandler);
        }
    }


    public function testExistUserRegister()
    {
        // PHPUnit 11 checks for any leftovers in error handlers, manual cleanup
        $prevHandler = set_exception_handler(null);

        try {
            $client = static::createClient();
            $client->followRedirects();
            $crawler =$client->request('GET', '/register');

            $form = $crawler->selectButton('Register')->form();
            $form['_username'] = 'dumb';  // Replace with an actual existing username
            $form['_email'] = 'dumb@dumb.com';
            $form['_password_1'] = 'dumb';
            $form['_password_2'] = 'dumb';
            $form['_specialization'] = 'Electronics';
            $form['_phase'] = '1';

            $client->submit($form);
//            $crawler = $client->submitForm('Login', [
//                'username' => 'dumb',
//                'password' => 'dumb',
//                'remember_me' => false,
//            ]);

            $this->assertSame(200, $client->getResponse()->getStatusCode());
            $currentUrl = $client->getRequest()->getUri();
            $this->assertStringContainsString('/register', $currentUrl);

        } catch (\Exception $e) {
            // Handle the exception gracefully, for example:
            $this->fail('Exception caught during test: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        } finally {
            // Restore the previous exception handler
            set_exception_handler($prevHandler);
        }
    }


    public function testNewUserRegister()
    {
        // PHPUnit 11 checks for any leftovers in error handlers, manual cleanup
        $prevHandler = set_exception_handler(null);

        try {
            $client = static::createClient();
            $client->followRedirects();
            $crawler =$client->request('GET', '/register');

            $username = 'integration_test_user_' . uniqid();
            $form = $crawler->selectButton('Register')->form();
            $form['_username'] = $username;
            $form['_email'] = $username . '@example.com';
            $form['_password_1'] = $username;
            $form['_password_2'] = $username;
            $form['_specialization'] = 'Electronics';
            $form['_phase'] = '1';

            $client->submit($form);
//            $crawler = $client->submitForm('Login', [
//                'username' => 'dumb',
//                'password' => 'dumb',
//                'remember_me' => false,
//            ]);

            $this->assertSame(200, $client->getResponse()->getStatusCode());
            $currentUrl = $client->getRequest()->getUri();
            $this->assertStringContainsString('/login', $currentUrl);

        } catch (\Exception $e) {
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
        } catch (\Exception $e) {
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
        } catch (\Exception $e) {
            // Handle the exception gracefully, for example:
            $this->fail('Exception caught during test: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }finally {
            // Restore the previous exception handler
            set_exception_handler($prevHandler);
        }
    }

}
