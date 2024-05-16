<?php


//===================================================================//
//                      good links
//===================================================================//
//  How to Build a Login Form
//  https://symfony.com/doc/4.x/security/form_login_setup.html
//
//  security doc
//  https://symfony.com/doc/current/security.html
//
///////////////////////////////////////////////////////////////////////
///

namespace App\Controller;

use App\Entity\Student;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;

class UserController extends AbstractController
{



//====================================================================================================================//
//              LOGIN FUNCTIONS
//====================================================================================================================//

    #[Route('/login', name: 'user_login_index')]
    public function loginPage(AuthenticationUtils $authenticationUtils, Request $request,UserPasswordHasherInterface $passwordHasher): Response
    {
        // Get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // Last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();


        return $this->render('login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/login_submit', name: 'user_login_check')]
    public function loginCheck(AuthenticationUtils $authenticationUtils,Request $request,UserPasswordHasherInterface $passwordHasher,Security $security)
    {

        $error = $authenticationUtils->getLastAuthenticationError();

        // Last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        // Retrieve username and password from the form submission
        $username = $request->request->get('_username');
        $password = $request->request->get('_password');
        $user = new User($username,$password,"");
        $password_hash=$passwordHasher->hashPassword(
            $user,
            $password
        );
        $user->setPassword($password_hash);

        // log the user in on the current firewall
        $security->login($user);


        printf("user: %s, password:%s, hashed password: %s",$username,$password,$password_hash);

        // This method is only used to define the route for login form submission.
        // Symfony's security system will handle the actual authentication process.
//        throw new \RuntimeException('You must configure the check path to be handled by the firewall using form_login in your security firewall configuration.');
        //replece with reroute in the future
        return $this->render('login.html.twig', [
            'username' => $username,
            'error' => $error,
        ]);
    }



//====================================================================================================================//
//              REGISTER FUNCTIONS
//====================================================================================================================//

    #[Route('/register', name: 'user_register_index')]
    public function registerPage(AuthenticationUtils $authenticationUtils, Request $request,UserPasswordHasherInterface $passwordHasher): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();


        return $this->render('register.html.twig', [
            'controller_name' => 'UserController',
            'error' => $error
        ]);
    }


    #[Route('/register_submit',name: 'user_register_check', methods: ['POST'])]
    public function registerCheck(AuthenticationUtils $authenticationUtils,SessionInterface $session, Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        $username = $request->request->get('_username');
        $email = $request->request->get('_email');
        $password1 = $request->request->get('_password_1');
        $password2 = $request->request->get('_password_2');
        $specialization = $request->request->get('_specialization');
        $phase = $request->request->get('_phase');

        //check if valid username

        $studentRepository=$entityManager->getRepository(Student::class);
        $inDbStudent=$studentRepository->findBy(['username'=>$username]);
        if (!empty($inDbStudent)) {
            printf($inDbStudent[0]->getEmail());
            printf("\nexisting user name, choose another one!\n");
            return $this->render('register.html.twig', [
                'controller_name' => 'UserController',
                '_username' => $username,
                '_password_1' => '',
                '_password_2' => '',
                'error' => $error
            ]);
        } else {
            printf("No student found with username: %s, creating new account.\n", $username);
        }

        if ($password1 !== $password2) {
            printf("mis matching password!!");
            return $this->render('register.html.twig', [
                'controller_name' => 'UserController',
                '_username' => $username,
                '_password_1' => '',
                '_password_2' => '',
                'error' => $error
            ]);
        }

        $user = new User($username,"dummy_password",$email);
        // Hash the password
        $hashedPassword = $passwordHasher->hashPassword($user, $password1);
        $user->setPassword($hashedPassword);

        //push new student record if valid
        $student=new Student();
        $student->setUsername($username);
        $student->setEmail($email);
        $student->setPassword($hashedPassword);
        $student->setPhase($phase);
        $student->setSpecialisation($specialization);

        $entityManager->persist($student);
        $entityManager->flush();


        // Store the User entity in the session
//        $session->set('user_to_register', $user);

        printf("register successful! user: %s, password:%s, hashed password: %s\n",$username,$password1,$hashedPassword);

        //debug segment
        $isValid = $passwordHasher->isPasswordValid($user, "password");

        // $isPasswordValid will be true if the password matches, false otherwise
        if ($isValid) {
            // Password is valid
            // Proceed with your logic here
            printf("valid passoord");
        } else {
            // Password is invalid
            // Handle the error or inform the user
            printf("WRONG passoord");

        }

        // Redirect to the controller action responsible for persisting the user
//        return $this->redirectToRoute('login');
        return $this->render('register.html.twig', [
            'username' => $username,
            'error' => $error,
        ]);
    }

    public function delete(UserPasswordHasherInterface $passwordHasher, UserInterface $user): void
    {
        // ... e.g. get the password from a "confirm deletion" dialog
        $plaintextPassword = "place_holder()";

        if (!$passwordHasher->isPasswordValid($user, $plaintextPassword)) {
            throw new AccessDeniedHttpException();
        }
    }

//====================================================================================================================//
//              LOGOUT FUNCTIONS
//====================================================================================================================//

    public function logOut(Security $security): Response
    {
        // logout the user in on the current firewall
        $response = $security->logout();

        // ... return $response (if set) or e.g. redirect to the homepage
        return $this->redirectToRoute('login');
    }


}
