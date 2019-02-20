<?php

namespace App\Controller;


use App\Entity\Contact;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ContactController extends AbstractController
{

    public function index()
    {
    	$contacts = $this->getDoctrine()->getRepository(Contact::class)->findAll();

        return $this->render('contacts/index.html.twig', array('contacts' => $contacts));
    }


    public function new(Request $request)
    {
    	$contact = new Contact();

    	$form = $this->createFormBuilder($contact)
    		->add("name",TextType::class, array('attr'=>
    			array('class' => 'form-control')
    		))

    		->add("address",TextType::class, array('attr'=>
    			array('class' => 'form-control')
    		))

    		->add("phone",TextType::class, array('attr'=>
    			array('class' => 'form-control')
    		))

    		->add("save", SubmitType::class,array(
    			'label'=>'Create Contact',
    			'attr' => array('class'=>'btn btn-primary')
    		))->getForm();

    	$form->handleRequest($request);

    	if($form->isSubmitted() && $form->isValid())
    	{
    		$contact= $form->getData();

    		$entityManager = $this->getDoctrine()->getManager();
    		$entityManager->persist($contact);
    		$entityManager->flush();

    		return $this->redirectToRoute("index");
    	}

		return $this->render('contacts/new.html.twig',array(
			'form'=> $form->createView()
		));
    }


    public function edit(Request $request,$id)
    {
    	$contact = new Contact();

    	$contact = $this->getDoctrine()->getRepository(Contact::class)->find($id);

    	$form = $this->createFormBuilder($contact)
    		->add("name",TextType::class, array('attr'=>
    			array('class' => 'form-control')
    		))

    		->add("address",TextType::class, array('attr'=>
    			array('class' => 'form-control')
    		))

    		->add("phone",TextType::class, array('attr'=>
    			array('class' => 'form-control')
    		))

    		->add("update", SubmitType::class,array(
    			'label'=>'Update Contact',
    			'attr' => array('class'=>'btn btn-primary')
    		))->getForm();

    	$form->handleRequest($request);

    	if($form->isSubmitted() && $form->isValid())
    	{

    		$entityManager = $this->getDoctrine()->getManager();
    		$entityManager->flush();

    		return $this->redirectToRoute("index");
    	}

		return $this->render('contacts/edit.html.twig',array(
			'form'=> $form->createView()
		));
    }



    public function delete(Request $request,$id)
    {
    	$contact = $this->getDoctrine()->getRepository(Contact::class)->find($id);

    	$entityManager = $this->getDoctrine()->getManager();
		$entityManager->remove($contact);
		$entityManager->flush();

		// $response = new response();
		// $response->send();

		return $this->redirectToRoute("index");
    }


    // public function save()
    // {
    // 	$entityManager = $this->getDoctrine()->getManager();

    // 	$contact = new Contact();
    // 	$contact->setName('Name1');
    // 	$contact->setAddress('Address1');
    // 	$contact->setPhone('8899998888');

    // 	$entityManager->persist($contact);
    // 	$entityManager->flush();

    // 	return new Response("Saved");
    // }

    public function show($id)
    {
    	$contact = $this->getDoctrine()->getRepository(Contact::class)->find($id);
    	return $this->render('contacts/show.html.twig', array('contact' => $contact));
    }


    public function lucky()
    {
    	$number = random_int(0, 100);
    	return $this->render('contacts/lucky.html.twig',[ 'number' => $number,]);
    }
}

