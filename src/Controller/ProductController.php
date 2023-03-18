<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use App\Security\Voter\ProductsVoter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



    // ************************* LISTE DES PRODUITS ***************************************
#[Route('/product')]
class ProductController extends AbstractController
{
    #[Route('/', name: 'app_product_index', methods: ['GET'])]
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    // ************************* AJOUTER UN PRODUIT ********************(inscrit)*******************
    #[Route('/new', name: 'app_product_new', methods: ['GET', 'POST'])]
    // il faut etre inscrit pour créer un produit
    #[IsGranted('ROLE_USER', message: 'Impossible d\'accéder sans inscription')]
    public function new(Request $request, ProductRepository $productRepository): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // attribut le produit a l utilisateur connecté
            $product->setOwner($this->getUser());
            $productRepository->save($product, true);

            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('product/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    // ************************* VOIR UN PRODUIT ***************************************
    #[Route('/{id}', name: 'app_product_show', methods: ['GET'])]
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    // ************************* EDITER UN PRODUIT ****************(inscrit et possesseur ou admin)***********************
    #[Route('/{id}/edit', name: 'app_product_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER', message: 'Impossible d\'accéder sans inscription')]
    public function edit(Request $request, Product $product, ProductRepository $productRepository): Response
    {

        // bloque la route si l'utilisateur n'est pas le vendeur ou l admin
        $this->denyAccessUnlessGranted(ProductsVoter::PRODUCT_EDIT, $product);

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productRepository->save($product, true);

            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('product/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

     // ************************* SUPPRIMER UN PRODUIT ****************(inscrit et admin)***********************
    #[Route('/{id}', name: 'app_product_delete', methods: ['POST'])]
    #[IsGranted('ROLE_USER', message: 'Impossible d\'accéder sans inscription')]
    public function delete(Request $request, Product $product, ProductRepository $productRepository): Response
    {
        // bloque la route si l'utilisateur n'est pas le vendeur
        $this->denyAccessUnlessGranted(ProductsVoter::PRODUCT_DELETE, $product);
        if ($this->isCsrfTokenValid('delete' . $product->getId(), $request->request->get('_token'))) {
            $productRepository->remove($product, true);
        }

        return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
    }
}
