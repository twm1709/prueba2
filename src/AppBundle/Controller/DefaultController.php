<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use AppBundle\Entity\Category;
use AppBundle\Entity\Product; //así importas la clase


class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
       $session = $request->getSession();
       // store an attribute for reuse during a later user request
       $session->set('wooo','wiii');
       // get the attribute set by another controller in another request
       $wooowiii = $session->get('wooowiii');
       // use a default value if the attribute doesn't exist
        $filters = $session->get('filters', array());
        $this->addFlash(
        'notice',
        'Your changes were saved!'
        );
        $name = 'pepe';
        // create a simple Response with a 200 status code (the default)
        $response = new Response('Hello '.$name, Response::HTTP_OK);

        // create a JSON-response with a 200 status code
        $response = new Response(json_encode(array('name' => $name)));
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }

    // ACCIONES DE BASE DE DATOS CON DOCTRINE

    /**
     * @Route("/db/", name="database")
     */
    public function createAction()
    {
      $product = new Product();
      $product->setName('A Foo Bar');
      $product->setPrice('19.99');
      $product->setDescription('Lorem ipsum dolor');
      $em = $this->getDoctrine()->getManager();
      $em->persist($product); //Se utiliza al crear un objeto
      $em->flush();
      return new Response('Created product id '.$product->getId());
    }

    /**
     * @Route("/db/{id}")
     */

    public function showAction($id)
    {
      $product = $this->getDoctrine()
        ->getRepository('AppBundle:Product')
        ->find($id);
      if (!$product) {
        throw $this->createNotFoundException(
          'No product found for id '.$id
        );
      }
      // ... do something, like pass the $product object into a template
      $response = new Response('Hello '.$product->getCategory()->getName(), Response::HTTP_OK);
      return $response;
    }

    /**
     * @Route("/db/update/{id}")
     */
    public function updateAction($id)
    {
      $em = $this->getDoctrine()->getManager();
      $product = $em->getRepository('AppBundle:Product')->find($id);
      if (!$product) {
        throw $this->createNotFoundException(
          'No product found for id '.$id
        );
      }
      $product->setName('New product name!');
      $em->flush();
      $response = new Response($product->getId() . " Actualizado!", Response::HTTP_OK);
      return $response;
    }

    /**
     * @Route("/db/delete/{id}")
     */
    public function deleteAction($id)
    {
      $em = $this->getDoctrine()->getManager();
      $product = $em->getRepository('AppBundle:Product')->find($id);
      if (!$product) {
        throw $this->createNotFoundException(
          'No product found for id '.$id
        );
      }
      $em->remove($product);
      $em->flush();
      $response = new Response($id . " Eliminado!", Response::HTTP_OK);
      return $response;
    }

    /**
     * @Route("/db/find/complex")
     */
    public function complexQueryAction(){
      $em = $this->getDoctrine()->getManager();
      $query = $em->createQuery(
        'SELECT p
        FROM AppBundle:Product p
        WHERE p.price >= :price
        ORDER BY p.price ASC'
      )->setParameter('price', '19.99');
      $products = $query->getResult();
      return $this->render(
      'prueba/prueba.html.twig',
      array('products' => $products)
      );
      
    }

    /**
     * @Route("/db/find/custom")
     */
    public function customQueryAction(){
      $em = $this->getDoctrine()->getManager();
      $products = $em->getRepository('AppBundle:Product')
      ->findAllOrderedByName();

      return $this->render(
      'prueba/prueba.html.twig',
      array('products' => $products)
      );
      
    }

    /**
    *@Route("/db/create/custom")
    */

    public function createProductAction()
    {
      $category = new Category();
      $category->setName('Main Products');
      $product = new Product();
      $product->setName('Foo');
      $product->setPrice(19.99);
      $product->setDescription('Lorem ipsum dolor');
      // relate this product to the category
      $product->setCategory($category);
      $em = $this->getDoctrine()->getManager();
      $em->persist($category);
      $em->persist($product);
      $em->flush();
      return new Response(
        'Created product id: '.$product->getId()
        .' and category id: '.$category->getId()
        );
    }

    /**
    * @Route("/admin")
    */
    
    public function adminAction()
    {
      return new Response('<html><body>Admin page!</body></html>');
    }
}
