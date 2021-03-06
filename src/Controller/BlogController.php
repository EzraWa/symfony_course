<?php
/**
 * Created by PhpStorm.
 * User: ezrawaalboer
 * Date: 12/02/2019
 * Time: 22:23
 */

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;

/**
 * @Route("/blog")
 * Class BlogController
 * @package App\Controller
 */
class BlogController
{

    /**
     * @var \Twig_Environment
     */
    private $twig;
    /**
     * @var SessionInterface
     */
    private $session;
    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(
        \Twig_Environment $twig,
        SessionInterface $session,
        RouterInterface $router
    )
    {
        $this->twig = $twig;
        $this->session = $session;
        $this->router = $router;
    }

    /**
     * @Route("/", name="blog_index")
     * @param $name
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function index()
    {
        $html = $this->twig->render(
            'blog/index.html.twig',
            [
                'posts' => $this->session->get('posts')
            ]
        );

        return new Response($html);
    }

    /**
     * @Route("/add", name="blog_add")
     */
    public function add()
    {

        $posts = $this->session->get('posts');
        $posts[uniqid()] = [
            'title' => 'A random title ' . rand(1, 500),
            'text' => 'Some random text nr ' . rand(1, 500),
            'date' => new \DateTime()
        ];
        $this->session->set('posts', $posts);

        return new RedirectResponse($this->router->generate('blog_index'));

    }

    /**
     * @Route("/show/{id}", name="blog_show")
     */
    public function show($id)
    {
        $posts = $this->session->get('posts');

        if (is_null($posts) || false == isset($posts[$id])) {
            throw new NotFoundHttpException('Post not found');
        }

        $html = $this->twig->render(
            'blog/post.html.twig',
            [
                'id' => $id,
                'post' => $posts[$id]
            ]
        );

        return new Response($html);

    }

}