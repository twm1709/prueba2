<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller; //permite acceso a métodos "helper"

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route; //informacion de ruteo
use Symfony\Component\HttpFoundation\Response; // Permite crear objetos de respuesta

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method; //para definir método


class PruebaController extends Controller{
	/**
	* @Route("/prueba/{page}", defaults={"page" = 1})
	*/
	public function holaAction($page){
		return $this->render(
		'prueba/prueba.html.twig',
		array('nombre_persona' => $app->getUser())
		);
		

	}

	/**
	* @Route("chau")
	*/
	public function chauAction(){
		return $this->redirectToRoute('homepage');
		

	}


	/**
	* @Route("/news")
	* @Method("GET")
	*/
	public function newsAction()
	{
	// ... display your news
	}
	

	/**
	* @Route("/contact")
	* @Method({"GET", "POST"})
	*/
	public function contactFormAction()
	{
	// ... display and process a contact form
	}

}