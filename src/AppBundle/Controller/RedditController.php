<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 04/08/2017
 * Time: 15:35
 */

namespace AppBundle\Controller;

use AppBundle\Entity\RedditPost;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RedditController extends Controller
{
    /**
     * @Route("/", name="list")
     */
    public function listAction()
    {
        $posts = $this->getDoctrine()->getRepository('AppBundle:RedditPost')->findAll();

        return $this->render(':reddit:index.html.twig', [
            'posts' => $posts
        ]);
    }

    /**
     * @Route("/create/{text}", name="create")
     */
    public function createAction($text)
    {
        $em = $this->getDoctrine()->getManager();

        $post = new RedditPost();
        $post->setTitle('hello ' . $text);

        $em->persist($post);
        $em->flush();

        return $this->redirectToRoute('list');
    }

    /**
     * @Route("/update/{id}/{text}", name="update")
     */
    public function updateAction($id, $text)
    {
        $em = $this->getDoctrine()->getManager();

        $post = $em->getRepository('AppBundle:RedditPost')->find($id);
        if (!$post){
            throw $this->createNotFoundException('That is not a record !');
        }
        /** @var $post RedditPost */
        $post->setTitle('updated title ' . $text);
        $em->flush();

        return $this->redirectToRoute('list');
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $post = $em->getRepository('AppBundle:RedditPost')->find($id);
        if (!$post){
            throw $this->createNotFoundException('That is not a record !');
        }
        /** @var $post RedditPost */
        $em->remove($post);
        $em->flush();
        return $this->redirectToRoute('list');
    }
}