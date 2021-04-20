<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Author;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class AuthorController extends AbstractController
{

    /**
     * @Route("/authors/{id}", name="author_show")
     */
    public function show(Author $author)
    {

        $data = $this->get('serializer')->serialize($author, 'json');

        $response = new Response($data);
        $response->headers->set('Content-type', 'application/json');

        return $response;
    }

    /**
     * @Route("/authors", name="author_create", methods={"POST"})
     */
    public function create(Request $request)
    {
        $data = $request->getContent();
        $author = $this->get('serializer')->deserialize($data, 'json');

        $em = $this->getDoctrine()->getManager();
        $em->persist($author);
        $em->flush();

        return new Response('', Response::HTTP_CREATED);


    }
}