<?php
/**
 * Created by PhpStorm.
 * User: ezrawaalboer
 * Date: 2019-05-10
 * Time: 11:23
 */

namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{

    /**
     * @var \Twig_Environment
     */
    private $twig;

    public function __construct(
        \Twig_Environment $twig
    )
    {

        $this->twig = $twig;
    }

    /**
     * @Route("/login", name="security_login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {

        return $this->render(
            'security/login.html.twig',
            [
                'last_username' => $authenticationUtils->getLastUsername(),
                'error' => $authenticationUtils->getLastAuthenticationError()
            ]
        );

    }

    /**
     * @Route("/logout", name="security_logout")
     */
    public function logout()
    {

    }

}
