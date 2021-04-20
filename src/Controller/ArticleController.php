<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use JMS\Serializer\SerializationContext;

class ArticleController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    /**
     * @Route("/articles/{id}", name="article_show")
     */
    public function show(Article $article)
    {
        $data = $this->get('jms_serializer')->serialize($article, 'json', SerializationContext::create()->setGroups('detail'));

        $response = new Response($data);
        $response->headers->set('Content-type', 'application/json');

        return $response;
    }

    /**
     * @Route("/articles", name="article_create", methods={"POST"})
     * 
     */
    public function create(Request $request)
    {
        $data = $request->getContent();

        $article = $this->get('jms_serializer')->deserialize($data, Article::class, 'json', SerializationContext::create()->setGroups('list'));

        $this->em->persist($article);
        $this->em->flush();

        return new Response('', Response::HTTP_CREATED);
    }

    /**
     * @Route("/articles", name="article_list", methods={"GET"})
     */
    public function list(ArticleRepository $articleRepository)
    {
        $articles = $articleRepository->findAll();

        $data = $this->get('jms_serializer')->serialize($articles, 'json');

        $response = new Response($data);

        $response->headers->set('Content-type', 'application/json');

        return $response;

    }
}