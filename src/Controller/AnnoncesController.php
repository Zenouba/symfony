<?php

namespace App\Controller;

use App\Entity\Annonces;
use App\Entity\Categories;
use App\Form\AnnonceType;
use App\Entity\AnnonceImmobilier;
use App\Form\AnnonceImmobilierType;
use App\Repository\AnnoncesRepository;
use App\Repository\CategoriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;


class AnnoncesController extends AbstractController
{
    private $annoncesRepo;
    private $flashMessage;
    private $entityManager;
    
    public function __construct(AnnoncesRepository $annoncesRepo,FlashBagInterface $flashMessage,EntityManagerInterface  $entityManager){
        $this->annoncesRepo=$annoncesRepo;
        $this->flashMessage=$flashMessage;
        $this->entitymanager=$entityManager;
    }
    
    #[Route('/annonces', name: 'annonces_home')]
    public function index(AnnoncesRepository $annoncesRepo, Request $request)
    {
        $annonces = $annoncesRepo->findAll();
        return $this->render('annonces/index.html.twig',[
            "annonces" => $annonces
        ]);
    }

    #[Route('/')]
    public function home(AnnoncesRepository $annoncesRepo,CategoriesRepository $categoriesRepo)
    {
        $firstThreeAnnonces = $annoncesRepo->findRecent(3);
        $categories = $categoriesRepo->findAll();
        return $this->render('main/index.html.twig', [
            'annonces' => $firstThreeAnnonces,
            'categories' => $categories,
        ]);
    }

    #[Route('/annonces/{id}', name: 'annonces_show')]
    public function showannonce($id)
    {
        $annonces = $this->annoncesRepo->find($id);
        return $this->render('annonces/show.html.twig',[
            "annonces" => $annonces
        ]);
    }

    #[Route('/annonces/{categorie}/edit/{id}', name: 'annonces_edit')]
    public function editAnnonce(Annonces $annonce,Request $request,string $categorie ,CategoriesRepository $categoryRepo)
    {

        if (!($this->getUser())) {
            return $this->redirectToRoute('app_login');
        }
        $category = $categoryRepo->findOneBy(['nom' => $categorie]);
        $form = $this->createForm(AnnonceType::class,$annonce, [
            'is_immobilier' => ($categorie === 'Immobilier'),
            'is_vm' => ($categorie === 'Voitures & Motos'),
            'is_service' => ($categorie === 'Service'),
            'is_vetements' => ($categorie === 'Vêtements'),
            'is_mt' => ($categorie === 'Mobiles & Tablettes'),
            'is_autre' => ($categorie === 'Autre'),
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
        
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($annonce);
            $entityManager->flush();

            $this->addFlash('success', 'Annonce modifiée !');
            return $this->redirectToRoute('annonces_show', ['id' => $annonce->getId()]);
        }
            return $this->renderForm('annonces/edit.html.twig', [
                'form' => $form,
                'categorie' => $categorie,
            ]);
    }

    #[Route('/annonces/delete/{id}', name: 'annonces_delete')]
    public function deleteAnnonce(Annonces $annonce)
    {
            if (!($this->getUser())) {
                return $this->redirectToRoute('app_login');
            }
             // Get the photo filename
            $photoFilename = $annonce->getPhoto();

            // Delete the photo file from the folder
            $photoPath = $this->getParameter('kernel.project_dir') . '/public/uploads/' . $photoFilename;
            if (file_exists($photoPath)) {
                unlink($photoPath);
            }
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($annonce);
            $entityManager->flush();
            $this->flashMessage->add("success","Annonce supprimée !");
            return $this->redirectToRoute('annonces_home');
    }

    #[Route('/annonces/show/{categorie}', name:'app_annonce_by_category')]
    public function annoncesByCategorie(string $categorie, AnnoncesRepository $annoncesRepo)
    {
        $annonces = $annoncesRepo->findByCategorienom($categorie);
        return $this->render('annonces/annonces.html.twig', [
            'annonces' => $annonces,
            'categorie' =>  $categorie
        ]);
    }

}