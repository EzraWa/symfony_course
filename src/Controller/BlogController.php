<?php
/**
 * Created by PhpStorm.
 * User: ezrawaalboer
 * Date: 12/02/2019
 * Time: 22:23
 */

namespace App\Controller;

use App\Service\Greeting;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/blog")
 * Class BlogController
 * @package App\Controller
 */
class BlogController
{

    /**
     * @var Greeting
     */
    private $greeting;
    /**
     * @var \Twig_Environment
     */
    private $twig;

    public function __construct(Greeting $greeting, \Twig_Environment $twig)
    {
        $this->greeting = $greeting;
        $this->twig = $twig;
    }

    /**
     * @Route("/{name}", name="blog_index")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index($name)
    {
        $html = $this->twig->render('base.html.twig', ['message' => $this->greeting->greet($name)]);
        return new Response($html);

    }

}