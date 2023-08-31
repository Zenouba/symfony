<?php

namespace App\Controller;

use App\Repository\AnnoncesRepository;
use App\Repository\CategoriesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(CategoriesRepository $catsRepo)
    {
        $categories = $catsRepo->findAll();

        return $this->render('main/index.html.twig', [
            'categories' => $categories,
            // dd($categories)
            'hello' => "Hello"
        ]);
    }

    #[Route('/Catégories', name: 'app_standard')]
    public function standard(CategoriesRepository $catsRepo)
    {
        return $this->render('main/standard.html.twig', [
            'categories' => $catsRepo->findAll()
        ]);
    }

    #[Route('/A-Propos', name: 'app_about')]
    public function about()
    {
        return $this->render('main/about.html.twig');
    }

    
    #[Route('/Contact', name: 'app_contact')]
    public function contact()
    {
        return $this->render('main/contact.html.twig');
    }

    #[Route('/search', name: 'annonce_search')]
    public function searchAnnonces(Request $request, AnnoncesRepository $annoncesRepo)
    {
        $searchTerm = $request->query->get('search');
        // dd($searchTerm);
        
        if ($searchTerm) {
            $annonces = $annoncesRepo->searchByTitleOrText($searchTerm);
        } else {
            $annonces = []; 
        }

        return $this->render('main/search.html.twig', [
            'searchTerm' => $searchTerm,
            'ads' => $annonces,
        ]);
    }
}