<?php
/**
 * Created by PhpStorm.
 * User: ezrawaalboer
 * Date: 08/03/2019
 * Time: 16:56
 */

namespace App\Controller;

use App\Entity\MicroPost;
use App\Form\MicroPostType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class MicroPostController
 * @package App\Controller
 * @Route("/micro-post")
 */
class MicroPostController extends AbstractController
{

    /**
     * @var \App\Repository\MicroPostRepository
     */
    private $microPostRepository;
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var RouterInterface
     */
    private $router;
    /**
     * @var FlashBagInterface
     */
    private $flashBag;

    public function __construct(
        \App\Repository\MicroPostRepository $microPostRepository,
        FormFactoryInterface $formFactory,
        EntityManagerInterface $entityManager,
        RouterInterface $router,
        FlashBagInterface $flashBag
    ) {
        $this->microPostRepository = $microPostRepository;
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
        $this->router = $router;
        $this->flashBag = $flashBag;
    }

    /**
     * @Route("/", name="micro_post_index")
     */
    public function index()
    {

        return $this->render('micro-post/index.html.twig', [
            'posts' => $this->microPostRepository->findBy([], ['time' => 'desc'])
        ]);
    }

    /**
     * @Route("/edit/{id}", name="micro_post_edit")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(MicroPost $microPost, Request $request)
    {

        $form = $this->formFactory->create(MicroPostType::class, $microPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return new RedirectResponse($this->router->generate('micro_post_index'));
        }

        return $this->render(
            'micro-post/add.html.twig',
            [
                'form' => $form->createView()
            ]);

    }

    /**
     * @Route("/add", name="micro_post_add")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function add(
        Request $request
    ) {
        $microPost = new MicroPost();
        $microPost->setTime(new \DateTime());

        $form = $this->formFactory->create(MicroPostType::class, $microPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($microPost);
            $this->entityManager->flush();

            return new RedirectResponse($this->router->generate('micro_post_index'));
        }

        return $this->render(
            'micro-post/add.html.twig',
            [
                'form' => $form->createView()
            ]);
    }

    /**
     * @Route("/delete/{id}", name="micro_post_delete")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delete(MicroPost $microPost, Request $request)
    {
        $this->entityManager->remove($microPost);
        $this->entityManager->flush();

        $this->flashBag->add('notice', 'Micro post was deleted');

        return new RedirectResponse($this->router->generate('micro_post_index'));
    }


    /**
     * @Route("/{id}", name="micro_post_post")
     */
    public function post(
        MicroPost $post
    ) {
        return $this->render(
            'micro-post/post.html.twig',
            [
                'post' => $post
            ]
        );
    }

}
