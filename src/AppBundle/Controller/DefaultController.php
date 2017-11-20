<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Product;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $products = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findAll();

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * @Route("/create", name="product_create")
     * @Method({"POST"})
     */
    public function createAction(Request $request)
    {
        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to your action: createAction(EntityManagerInterface $em)
        $em = $this->getDoctrine()->getManager();

        $name = $request->request->get('name', 'Unknown');
        $price = $request->request->get('price');
        $description = $request->request->get('description');

        $product = new Product();
        $product->setName($name);
        $product->setPrice($price);
        $product->setDescription($description);

        // tells Doctrine you want to (eventually) save the Product (no queries yet)
        $em->persist($product);

        // actually executes the queries (i.e. the INSERT query)
        $em->flush();

        // replace this example code with whatever you need
        return $this->redirectToRoute('product_show', [
            'productId' => $product->getId()
        ]);
    }

    /**
     * @Route("/product/{productId}", name="product_show", requirements={"productId" = "\d+"})
     */
    public function showAction($productId)
    {
        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->find($productId);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$productId
            );
        }

        // replace this example code with whatever you need
        return $this->render('default/show.html.twig', [
            'product' => $product
        ]);
    }
}