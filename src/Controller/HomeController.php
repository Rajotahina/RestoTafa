<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    #[Route('/menu', name: 'menu')]
    public function menu(ProductRepository $productRepository): Response
    {
        return $this->render('home/menu.html.twig', [
            'products' => $productRepository->findAll()
        ]);

    }

//    #[Route('/menu' , name:'menu' )]
//    public function menu():Response
//    {
//         return $this->render('home/menu.html.twig',[
//             'controller_name' =>'HomeController',
//         ]);
//    }
   //#[Route('/food', name:'product')]
//    public function food():Response
//    {
//     $product= $repository->findAll();
//     return $this->render('home/food/menu.html.twig' ,[

//     ]);
//    }
}
