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

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

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

    #[Route('/home', name: 'user_login_check')]
    public function loginCheck(AuthenticationUtils $authenticationUtils,Request $request,UserPasswordHasherInterface $passwordHasher)
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


        printf("user: %s, password:%s, hashed password: %s",$username,$password,$password_hash);

        // This method is only used to define the route for login form submission.
        // Symfony's security system will handle the actual authentication process.
//        throw new \RuntimeException('You must configure the check path to be handled by the firewall using form_login in your security firewall configuration.');

        return $this->render('home.html.twig', [
            'username' => $username,
            'error' => $error,
        ]);
    }



//====================================================================================================================//
//              REGISTER FUNCTIONS
//====================================================================================================================//

    #[Route('/register', name: 'user_register_index')]
    public function registerPage(): Response
    {
        return $this->render('register.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }


    #[Route('/register',name: 'user_register_confirm', methods: ['POST'])]
    public function registerCheck(AuthenticationUtils $authenticationUtils, Request $request,UserPasswordHasherInterface $passwordHasher): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        $username = $request->request->get('_username');
        $password1 = $request->request->get('_password_1');
        $password2 = $request->request->get('_password_2');

        if(!$password1!==($password2)){
            printf("mis matching password!!");
            return $this->render('register.html.twig', [
                'controller_name' => 'UserController',
                '_username' =>$username,
                '_password_1' => "",
                '_password_2' => ""
            ]);
        }


        // ... e.g. get the user data from a registration form
        $user = new User("admin","","email");
        $plaintextPassword = $password1;

        // hash the password (based on the security.yaml config for the $user class)
        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $plaintextPassword
        );
        $user->setPassword($hashedPassword);

        //need some form stuff
        printf("register successful! user: %s, password:%s, hashed password: %s",$username,$plaintextPassword,$hashedPassword);

        return $this->render('register/register.html.twig', [
            'controller_name' => 'UserController',
            'error' => $error
        ]);
    }
}
