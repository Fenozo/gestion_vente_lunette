<?php

namespace Acme\Bundle\BlogBundle\Controller;

use Acme\Bundle\BlogBundle\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Article controller.
 *
 * @Route("article")
 */
class ArticleController extends Controller
{
    /**
     * Lists all article entities.
     *
     * @Route("/", name="public_articles")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $articles = $em->getRepository('AcmeBundleBlogBundle:Article')->findAll();

        return $this->render('AcmeBundleBlogBundle:Article:index.html.twig', array(
            'articles' => $articles,
        ));
    }

    /**
     * Finds and displays a article entity.
     *
     * @Route("/{id}/details", name="public_article_detail")
     * @Method("GET")
     */
    public function showAction(Article $article)
    {
        //$deleteForm = $this->createDeleteForm($article);

        if (empty($article)) {
            $article = new Article();
        }

        return $this->render('AcmeBundleBlogBundle:article:show.html.twig', array(
            'article' => $article,
            //'delete_form' => $deleteForm->createView(),
        ));
    }

}
