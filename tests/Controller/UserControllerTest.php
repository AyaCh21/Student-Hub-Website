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
//      this controller revolves firewall and user authentication,
//      hence comprehensive tests applied to ensure the security of website and personal infomation.
//=====================================================================================================//
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
            $crawler = $client->request('GET', '/login');

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

            $crawler = $client->request('GET', '/home');
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
            $crawler = $client->request('GET', '/login');

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
            $this->assertSelectorExists('button[type="submit"]');
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
            $crawler = $client->request('GET', '/register');

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

    public function testExistEmailRegister()
    {
        // PHPUnit 11 checks for any leftovers in error handlers, manual cleanup
        $prevHandler = set_exception_handler(null);

        try {
            $client = static::createClient();
            $client->followRedirects();
            $crawler = $client->request('GET', '/register');

            $form = $crawler->selectButton('Register')->form();
            $form['_username'] = 'dumb_newname';  // Replace with an actual existing username
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


    public function testNewUserMismatchPasswordRegister()
    {
        // PHPUnit 11 checks for any leftovers in error handlers, manual cleanup
        $prevHandler = set_exception_handler(null);

        try {
            $client = static::createClient();
            $client->followRedirects();
            $crawler = $client->request('GET', '/register');

            $username = 'integration_test_user_' . uniqid();
            $form = $crawler->selectButton('Register')->form();
            $form['_username'] = $username;
            $form['_email'] = $username . '@example.com';
            $form['_password_1'] = $username;
            $form['_password_2'] = $username.$username;
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
            $crawler = $client->request('GET', '/register');

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


    public function testNewUserRegisterThenLogin()
    {
        // PHPUnit 11 checks for any leftovers in error handlers, manual cleanup
        $prevHandler = set_exception_handler(null);

        try {
            $client = static::createClient();
            $client->followRedirects();
            $crawler = $client->request('GET', '/register');

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
            $crawler = $client->getCrawler();

            $form = $crawler->selectButton('Login')->form();
            $form['_username'] = $username;
            $form['_password'] = $username;
            $form['_remember_me']->tick();
            $client->submit($form);
//            $crawler = $client->submitForm('Login', [
//                'username' => 'dumb',
//                'password' => 'dumb',
//                'remember_me' => false,
//            ]);
            $this->assertSame(200, $client->getResponse()->getStatusCode());

            $crawler = $client->request('GET', '/home');
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
            $testUser = $userRepository->findOneBy(['username' => 'dumb']);
            $client->loginUser($testUser);

            $crawler = $client->request('GET', '/profile');
            $this->assertResponseIsSuccessful();
            $this->assertSame(200, $client->getResponse()->getStatusCode());
            $this->assertSelectorTextContains('h3', 'Your Profile');
        } catch (\Exception $e) {
            // Handle the exception gracefully, for example:
            $this->fail('Exception caught during test: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        } finally {
            // Restore the previous exception handler
            set_exception_handler($prevHandler);
        }
    }


//    public function testChangeUserPhaseNSpecialization()
//    {
//        // PHPUnit 11 checks for any leftovers in error handlers, manual cleanup
//        $prevHandler = set_exception_handler(null);
//
//        try {
//            $client = static::createClient();
//            $client->followRedirects();
//
//            // Login as a user
//            $client->request('GET', '/login');
//            $client->submitForm('Login', [
//                '_username' => 'dumb', // Replace with your actual username
//                '_password' => 'dumb', // Replace with your actual password
//            ]);
//
//            // Go to the profile page
//            $client->request('GET', '/profile');
//
//            $client->executeScript("
//            document.getElementById('specialisation').value = 'Electronics';
//            ");
//
//        } catch (\Exception $e) {
//            // Handle the exception gracefully, for example:
//            $this->fail('Exception caught during test: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
//        } finally {
//            // Restore the previous exception handler
//            set_exception_handler($prevHandler);
//        }
//    }

    public function testUnauthenticatedEditUsername()
    {
        // PHPUnit 11 checks for any leftovers in error handlers, manual cleanup
        $prevHandler = set_exception_handler(null);

        try {
            $client = static::createClient();
            $client->followRedirects();

            $userRepository = static::getContainer()->get(StudentRepository::class);
            $testUser = $userRepository->findOneBy(['username' => 'integration_test_new_user']);
            $client->loginUser($testUser);

            // Simulate accessing the page where the username can be edited
            $crawler = $client->request('GET', '/profile');
            $this->assertEquals("integration_test_new_user", $crawler->filter('#username-info-display')->text());


            // Fill the form with a new username and submit it
            $form = $crawler->filter('#username-edit-confirm')->form();
            $form['edit-username'] = 'integration_test_new_user_NEWNAME';
            $crawler = $client->request('GET', '/logout');
            $client->submit($form);

            $this->assertSame(500, $client->getResponse()->getStatusCode());

        } catch (\Exception $e) {
            // Handle the exception gracefully, for example:
            $this->fail('Exception caught during test: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        } finally {
            // Restore the previous exception handler
            set_exception_handler($prevHandler);
        }
    }

    public function testEditUsernameBackNForth()
    {
        // PHPUnit 11 checks for any leftovers in error handlers, manual cleanup
        $prevHandler = set_exception_handler(null);

        try {
            $client = static::createClient();
            $client->followRedirects();

            $userRepository = static::getContainer()->get(StudentRepository::class);
            $testUser = $userRepository->findOneBy(['username' => 'integration_test_new_user']);
            $client->loginUser($testUser);

            // Simulate accessing the page where the username can be edited
            $crawler = $client->request('GET', '/profile');
            $this->assertEquals("integration_test_new_user", $crawler->filter('#username-info-display')->text());


            // Fill the form with a new username and submit it
            $form = $crawler->filter('#username-edit-confirm')->form();
            $form['edit-username'] = 'integration_test_new_user_NEWNAME';
            $client->submit($form);


            $this->assertSame(200, $client->getResponse()->getStatusCode());
            // Simulate accessing the page again to change the username back
            $crawler = $client->request('GET', '/profile');

            $this->assertEquals("integration_test_new_user_NEWNAME", $crawler->filter('#username-info-display')->text());

            // Fill the form with the original username and submit it
            $form = $crawler->filter('#username-edit-confirm')->form();
            $form['edit-username'] = 'integration_test_new_user';
            $client->submit($form);


            // Simulate accessing the page again to change the username back
            $crawler = $client->request('GET', '/profile');

            $this->assertEquals("integration_test_new_user", $crawler->filter('#username-info-display')->text());


        } catch (\Exception $e) {
            // Handle the exception gracefully, for example:
            $this->fail('Exception caught during test: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        } finally {
            // Restore the previous exception handler
            set_exception_handler($prevHandler);
        }
    }


    public function testUnauthenticatedEditEmail()
    {
        // PHPUnit 11 checks for any leftovers in error handlers, manual cleanup
        $prevHandler = set_exception_handler(null);

        try {
            $client = static::createClient();
            $client->followRedirects();

            $userRepository = static::getContainer()->get(StudentRepository::class);
            $testUser = $userRepository->findOneBy(['username' => 'integration_test_new_user']);
            $client->loginUser($testUser);

            $crawler = $client->request('GET', '/profile');
            $this->assertEquals("integration_test_new_user@integration_test_new_user.com", $crawler->filter('#email-info-display')->text());


            $form = $crawler->filter('#email-edit-confirm')->form();
            $form['edit-email-password'] = 'integration_test_new_user';
            $form['edit-email'] = 'integration_test_new_user_NEWNAME@integration_test_new_user_NEWNAME.com';
            $crawler = $client->request('GET', '/logout');
            $client->submit($form);

            $this->assertSame(500, $client->getResponse()->getStatusCode());

        } catch (\Exception $e) {
            // Handle the exception gracefully, for example:
            $this->fail('Exception caught during test: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        } finally {
            // Restore the previous exception handler
            set_exception_handler($prevHandler);
        }
    }


    public function testWrongPasswordEditEmail()
    {
        // PHPUnit 11 checks for any leftovers in error handlers, manual cleanup
        $prevHandler = set_exception_handler(null);

        try {
            $client = static::createClient();
            $client->followRedirects();

            $userRepository = static::getContainer()->get(StudentRepository::class);
            $testUser = $userRepository->findOneBy(['username' => 'integration_test_new_user']);
            $client->loginUser($testUser);

            $crawler = $client->request('GET', '/profile');
            $this->assertEquals("integration_test_new_user@integration_test_new_user.com", $crawler->filter('#email-info-display')->text());


            $form = $crawler->filter('#email-edit-confirm')->form();
            $form['edit-email-password'] = 'wrongpassword';
            $form['edit-email'] = 'integration_test_new_user_NEWNAME@integration_test_new_user_NEWNAME.com';
            $client->submit($form);

            $this->assertSame(200, $client->getResponse()->getStatusCode());
            $this->assertEquals("integration_test_new_user@integration_test_new_user.com", $crawler->filter('#email-info-display')->text());


        } catch (\Exception $e) {
            // Handle the exception gracefully, for example:
            $this->fail('Exception caught during test: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        } finally {
            // Restore the previous exception handler
            set_exception_handler($prevHandler);
        }
    }


    public function testEditEmailBackNForth()
    {
        // PHPUnit 11 checks for any leftovers in error handlers, manual cleanup
        $prevHandler = set_exception_handler(null);

        try {
            $client = static::createClient();
            $client->followRedirects();

            $userRepository = static::getContainer()->get(StudentRepository::class);
            $testUser = $userRepository->findOneBy(['username' => 'integration_test_new_user']);
            $client->loginUser($testUser);

            $crawler = $client->request('GET', '/profile');

            $this->assertEquals("integration_test_new_user@integration_test_new_user.com", $crawler->filter('#email-info-display')->text());

            $form = $crawler->filter('#email-edit-confirm')->form();
            $form['edit-email-password'] = 'integration_test_new_user';
            $form['edit-email'] = 'integration_test_new_user_NEWNAME@integration_test_new_user_NEWNAME.com';
            $client->submit($form);


            $this->assertSame(200, $client->getResponse()->getStatusCode());
            $crawler = $client->request('GET', '/profile');

            $this->assertEquals("integration_test_new_user_NEWNAME@integration_test_new_user_NEWNAME.com", $crawler->filter('#email-info-display')->text());

            $form = $crawler->filter('#email-edit-confirm')->form();
            $form['edit-email-password'] = 'integration_test_new_user';
            $form['edit-email'] = 'integration_test_new_user@integration_test_new_user.com';
            $client->submit($form);


            $crawler = $client->request('GET', '/profile');

            $this->assertEquals("integration_test_new_user@integration_test_new_user.com", $crawler->filter('#email-info-display')->text());


        } catch (\Exception $e) {
            // Handle the exception gracefully, for example:
            $this->fail('Exception caught during test: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        } finally {
            // Restore the previous exception handler
            set_exception_handler($prevHandler);
        }
    }


    public function testEditEmailWithIncorrectPassword()
    {
        // PHPUnit 11 checks for any leftovers in error handlers, manual cleanup
        $prevHandler = set_exception_handler(null);

        try {
            $client = static::createClient();
            $client->followRedirects();

            $userRepository = static::getContainer()->get(StudentRepository::class);
            $testUser = $userRepository->findOneBy(['username' => 'integration_test_new_user']);
            $client->loginUser($testUser);

            $crawler = $client->request('GET', '/profile');

            $this->assertEquals("integration_test_new_user@integration_test_new_user.com", $crawler->filter('#email-info-display')->text());

            $form = $crawler->filter('#email-edit-confirm')->form();
            $form['edit-email-password'] = 'incorrect_password';
            $form['edit-email'] = 'integration_test_new_user_NEWNAME@integration_test_new_user_NEWNAME.com';
            $client->submit($form);


            $this->assertSame(200, $client->getResponse()->getStatusCode());
            $crawler = $client->request('GET', '/profile');
            $this->assertEquals("integration_test_new_user@integration_test_new_user.com", $crawler->filter('#email-info-display')->text());


        } catch (\Exception $e) {
            // Handle the exception gracefully, for example:
            $this->fail('Exception caught during test: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        } finally {
            // Restore the previous exception handler
            set_exception_handler($prevHandler);
        }
    }


    public function testEditPasswordBackNForth()
    {
        // PHPUnit 11 checks for any leftovers in error handlers, manual cleanup
        $prevHandler = set_exception_handler(null);

        try {
            $client = static::createClient();
            $client->followRedirects();
            $crawler = $client->request('GET', '/login');

            //login using old pass
            $form = $crawler->selectButton('Login')->form();
            $form['_username'] = "integration_test_new_user";
            $form['_password'] = "integration_test_new_user";
            $form['_remember_me']->tick();
            $client->submit($form);
            $this->assertSame(200, $client->getResponse()->getStatusCode());
            //test login successful
            $crawler = $client->request('GET', '/home');
            $this->assertSelectorTextContains('.container-title', 'StudHub!');
            $this->assertCount(1, $crawler->filter('a[href="/study"] input[type="button"][value="Study Now!"]'));
            $crawler = $client->request('GET', '/profile');
            // Fill the form with a new pass and submit it
            $form = $crawler->filter('#password-edit-confirm')->form();
            $form['edit-password1'] = 'new_password';
            $form['edit-password2'] = 'new_password';
            $form['edit-password-old'] = 'integration_test_new_user';
            $client->submit($form);

            //logout and login again to test password
            $client->request('GET', '/logout');
            $crawler = $client->request('GET', '/home');
            $this->assertResponseStatusCodeSame(200);
            $this->assertSelectorTextContains('.container-title', 'StudHub!');
            $this->assertCount(1, $crawler->filter('a[href="/register"] input[type="button"][value="Join Now"]'));
            //login with new pass
            $crawler = $client->request('GET', '/login');
            $form = $crawler->selectButton('Login')->form();
            $form['_username'] = "integration_test_new_user";
            $form['_password'] = "new_password";
            $form['_remember_me']->tick();
            $client->submit($form);
            //test if new pass valid
            $this->assertSame(200, $client->getResponse()->getStatusCode());
            $crawler = $client->request('GET', '/home');
            $this->assertSelectorTextContains('.container-title', 'StudHub!');
            $this->assertCount(1, $crawler->filter('a[href="/study"] input[type="button"][value="Study Now!"]'));

            //change it back and logout and login again
            $crawler = $client->request('GET', '/profile');
            // Fill the form with a new pass and submit it
            $form = $crawler->filter('#password-edit-confirm')->form();
            $form['edit-password1'] = 'integration_test_new_user';
            $form['edit-password2'] = 'integration_test_new_user';
            $form['edit-password-old'] = 'new_password';
            $client->submit($form);
            //logout and login again to test password
            $client->request('GET', '/logout');
            $crawler = $client->request('GET', '/home');
            $this->assertResponseStatusCodeSame(200);
            $this->assertSelectorTextContains('.container-title', 'StudHub!');
            $this->assertCount(1, $crawler->filter('a[href="/register"] input[type="button"][value="Join Now"]'));
            //final login to check if it was changed back
            $crawler = $client->request('GET', '/login');
            $form = $crawler->selectButton('Login')->form();
            $form['_username'] = "integration_test_new_user";
            $form['_password'] = "integration_test_new_user";
            $form['_remember_me']->tick();
            $client->submit($form);
            $this->assertSame(200, $client->getResponse()->getStatusCode());
            //test final login successfun
            $crawler = $client->request('GET', '/home');
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


    public function testEditPasswordInvalid()
    {
        // PHPUnit 11 checks for any leftovers in error handlers, manual cleanup
        $prevHandler = set_exception_handler(null);

        try {
            $client = static::createClient();
            $client->followRedirects();
            $crawler = $client->request('GET', '/login');

            //login using old pass
            $form = $crawler->selectButton('Login')->form();
            $form['_username'] = "integration_test_new_user";
            $form['_password'] = "integration_test_new_user";
            $form['_remember_me']->tick();
            $client->submit($form);
            $this->assertSame(200, $client->getResponse()->getStatusCode());
            //test login successful
            $crawler = $client->request('GET', '/home');
            $this->assertSelectorTextContains('.container-title', 'StudHub!');
            $this->assertCount(1, $crawler->filter('a[href="/study"] input[type="button"][value="Study Now!"]'));
            $crawler = $client->request('GET', '/profile');
            // Fill the form with a new pass and submit it
            $form = $crawler->filter('#password-edit-confirm')->form();
            $form['edit-password1'] = 'new_password';
            $form['edit-password2'] = 'new_password';
            $form['edit-password-old'] = 'new_password';
            $client->submit($form);

            //logout and login again to test password
            $client->request('GET', '/logout');
            $crawler = $client->request('GET', '/home');
            $this->assertResponseStatusCodeSame(200);
            $this->assertSelectorTextContains('.container-title', 'StudHub!');
            $this->assertCount(1, $crawler->filter('a[href="/register"] input[type="button"][value="Join Now"]'));
            //login with new pass
            $crawler = $client->request('GET', '/login');
            $form = $crawler->selectButton('Login')->form();
            $form['_username'] = "integration_test_new_user";
            $form['_password'] = "new_password";
            $form['_remember_me']->tick();
            $client->submit($form);
            //test if new pass valid
            $this->assertSame(200, $client->getResponse()->getStatusCode());
            $crawler = $client->request('GET', '/home');
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

    public function testUnauthenticatedEditPassword()
    {
        // PHPUnit 11 checks for any leftovers in error handlers, manual cleanup
        $prevHandler = set_exception_handler(null);

        try {
            $client = static::createClient();
            $client->followRedirects();

            $userRepository = static::getContainer()->get(StudentRepository::class);
            $testUser = $userRepository->findOneBy(['username' => 'integration_test_new_user']);
            $client->loginUser($testUser);

            $crawler = $client->request('GET', '/profile');
            $this->assertEquals("integration_test_new_user@integration_test_new_user.com", $crawler->filter('#email-info-display')->text());


            $form = $crawler->filter('#password-edit-confirm')->form();
            $form['edit-password1'] = 'new_password';
            $form['edit-password2'] = 'new_password';
            $form['edit-password-old'] = 'new_password';
            $crawler = $client->request('GET', '/logout');
            $client->submit($form);

            $this->assertSame(500, $client->getResponse()->getStatusCode());

        } catch (\Exception $e) {
            // Handle the exception gracefully, for example:
            $this->fail('Exception caught during test: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        } finally {
            // Restore the previous exception handler
            set_exception_handler($prevHandler);
        }
    }

    public function testEditPasswordMismatch()
    {
        // PHPUnit 11 checks for any leftovers in error handlers, manual cleanup
        $prevHandler = set_exception_handler(null);

        try {
            $client = static::createClient();
            $client->followRedirects();

            $userRepository = static::getContainer()->get(StudentRepository::class);
            $testUser = $userRepository->findOneBy(['username' => 'integration_test_new_user']);
            $client->loginUser($testUser);

            $crawler = $client->request('GET', '/profile');
            $this->assertEquals("integration_test_new_user@integration_test_new_user.com", $crawler->filter('#email-info-display')->text());


            $form = $crawler->filter('#password-edit-confirm')->form();
            $form['edit-password1'] = 'new_password1';
            $form['edit-password2'] = 'new_password2';
            $form['edit-password-old'] = 'new_password';
            $client->submit($form);

            $this->assertSame(200, $client->getResponse()->getStatusCode());

            $client->request('GET', '/logout');
            $crawler = $client->request('GET', '/home');
            $this->assertResponseStatusCodeSame(200);
            $this->assertSelectorTextContains('.container-title', 'StudHub!');
            $this->assertCount(1, $crawler->filter('a[href="/register"] input[type="button"][value="Join Now"]'));
            //login using old pass
            $crawler = $client->request('GET', '/profile');
            $form = $crawler->selectButton('Login')->form();
            $form['_username'] = "integration_test_new_user";
            $form['_password'] = "integration_test_new_user";
            $form['_remember_me']->tick();
            $client->submit($form);
            $this->assertSame(200, $client->getResponse()->getStatusCode());
            //test login successful
            $crawler = $client->request('GET', '/home');
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

    //in this test, examine whether the redirecting is successful while a unauthorized user is trying to access study page
    public function testUnauthenticatedStudyRedirect()
    {
        // PHPUnit 11 checks for any leftovers in error handlers, manual cleanup
        $prevHandler = set_exception_handler(null);

        try {
            $client = static::createClient();

            $client->request('GET', '/logout');

            $client->request('GET', '/home');
            $this->assertResponseStatusCodeSame(200);
            $this->assertSelectorTextContains('.container-title', 'StudHub!');

            $crawler = $client->request('GET', '/study');
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


    public function testAuthenticatedStudyRedirect()
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

    public function testLogoutPageRedirectSuccessful()
    {
        // PHPUnit 11 checks for any leftovers in error handlers, manual cleanup
        $prevHandler = set_exception_handler(null);

        try {
            $client = static::createClient();

            $crawler=$client->request('GET', '/logout');
            $client->followRedirects();

            $this->assertResponseStatusCodeSame(302);
        } catch (\Exception $e) {
            // Handle the exception gracefully, for example:
            $this->fail('Exception caught during test: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        } finally {
            // Restore the previous exception handler
            set_exception_handler($prevHandler);
        }
    }

}
