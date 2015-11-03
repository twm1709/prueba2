<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;


class BlogController extends Controller{

	/**
	* @Route("/blog/{slug}", name="blog_show")
	*/
	public function showAction($slug){
		
		return $this->render(
		'blogs/index.html.twig',
		array('slug' => $slug)
		);
        

	}

}