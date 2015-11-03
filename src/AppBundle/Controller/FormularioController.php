<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use AppBundle\Entity\Category;
use AppBundle\Entity\Task;
use AppBundle\Entity\Product; //así importas la clase

class FormularioController extends Controller
{
	/**
	* @Route("/form/")
	*/
	public function newAction(Request $request)
	{
		$task = new Task();
		/*
		$task->setTask('Write a blog post');
		$task->setDueDate(new \DateTime('tomorrow'));
		*/
		$form = $this->createFormBuilder($task)
			->add('task', 'text')
			->add('dueDate', 'date', 
				array('widget' => 'single_text',
					'label' => 'Due Date',
					))
			->add('save', 'submit', array('label' => 'Create Task'))
			->add('saveAndAdd', 'submit', array('label' => 'Save and Add'))
			->getForm();

		$form->handleRequest($request);
		if ($form->isValid()) {
			// perform some action, such as saving the task to the database
			
			// si hay más de un botón comprobamos con cual se clickeó
			$nextAction = $form->get('saveAndAdd')->isClicked()
						? 'task_new'
						: 'task_success';

			return $this->redirectToRoute($nextAction);
		}
		return $this->render('default/new.html.twig', array(
			'form' => $form->createView(),
		));
	}
}