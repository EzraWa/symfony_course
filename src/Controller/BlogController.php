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

class BlogController extends AbstractController
{

    /**
     * @var Greeting
     */
    private $greeting;

    public function __construct(Greeting $greeting)
    {
        $this->greeting = $greeting;
    }

    /**
     * @Route("/", name="blog_index")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request)
    {
        return $this->render('base.html.twig', ['message' => $this->greeting->greet($request->get('name'))]);

    }

}