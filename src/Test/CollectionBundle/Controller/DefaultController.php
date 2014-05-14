<?php

namespace Test\CollectionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Test\CollectionBundle\Form\RatingCollectionForm;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('TestCollectionBundle:Default:index.html.twig', array('name' => $name));
    }

    public function testCollectionAction(Request $request)
    {
        $categories = array();
        $ratingValues = array(0, 1, 10);
        $ratingData = array();
        for ($i = 0; $i < 150; $i++) {
            $ratingEntry = array(
                'category' => $i,
                'rating' => $ratingValues[rand(0,2)],
            );
            $ratingData[] = $ratingEntry;
            $categories[$i] = 'Category ' . $i;
        }
        $ratings = array('ratings' => $ratingData);

        // Create the form with the computed data
        $before = microtime(true);
        $form = $this->createForm(new RatingCollectionForm(), $ratings);
        $after = microtime(true);
        echo 'createForm: ' . ($after-$before) . " sec\n";

        if ('POST' == $request->getMethod()) {
            $before = microtime(true);
            $form->handleRequest($request);
            $after = microtime(true);
            echo 'handleRequest: ' . ($after-$before) . " sec\n";
        }

        $content = $this->renderView('TestCollectionBundle:Default:testCollection.html.twig', array(
            'form' => $form->createView(),
            'categories' => $categories,
        ));

        return new Response($content);
    }
}
