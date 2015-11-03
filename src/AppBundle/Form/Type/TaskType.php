<?php

// src/AppBundle/Form/Type/TaskType.php
namespace AppBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
class TaskType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('task')
			->add('dueDate', null, array('widget' => 'single_text'))
			->add('acepto', 'checkbox', array('mapped' => false))
			->add('save', 'submit');
	}
	public function getName()
	{
		return 'task';
	}
}