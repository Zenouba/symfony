<?php

namespace App\Controller;

use App\Entity\Annonces;
use App\Form\AnnonceType;
use App\Form\EditProfileType;
use App\Repository\AnnoncesRepository;
use App\Repository\CategoriesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index()
    {
        return $this->render('user/index.html.twig');
    }
    

    #[Route('/user/annonces/{categorie}/ajout', name: 'user_annonces_ajout')]
    public function ajoutAnnonce(Request $request,string $categorie ,CategoriesRepository $categoryRepo)
    {
        if (!($this->getUser())) {
            return $this->redirectToRoute('app_login');
        }
        $category = $categoryRepo->findOneBy(['nom' => $categorie]);
        $annonce = new Annonces();
        $form = $this->createForm(AnnonceType::class,$annonce, [
            'is_immobilier' => ($categorie === 'Immobilier'),
            'is_vm' => ($categorie === 'Voitures & Motos'),
            'is_service' => ($categorie === 'Service'),
            'is_vetements' => ($categorie === 'Vêtements'),
            'is_mt' => ($categorie === 'Mobiles & Tablettes'),
            'is_autre' => ($categorie === 'Autre'),
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            /** @var UploadFile $uploadfile */
            $uploadfile = $form['photo']->getData();
            $destination = $this->getParameter('kernel.project_dir').'/public/uploads';
            $originalFilename = pathinfo($uploadfile->getClientOriginalName(),PATHINFO_FILENAME) ; 
            $newFilename = uniqid().'.'.$uploadfile->getClientOriginalExtension();
            $uploadfile->move(
                $destination,
                $newFilename
            );
            $annonce->setPhoto($newFilename);
            $annonce->setUser($this->getUser());
            $annonce->setCategorie($category);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($annonce);
            $em->flush();

            $this->addFlash('success', 'Annonce Ajouté Avec Succès');
            return $this->redirectToRoute('app_annonce_by_category', ['categorie' => $categorie]);
        }
        
        return $this->render('user/annonces/ajout.html.twig', [
            'form' => $form->createView(),
            'categorie' => $categorie,
        ]);
    }
    
    #[Route('/user/profil/edit', name: 'user_profil_edit')]
    public function editProfil(Request $request)
    {
        if (!($this->getUser())) {
            return $this->redirectToRoute('app_login');
        }
        
        $user = $this->getUser();
        $form = $this->createForm(EditProfileType::class,$user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $this->addFlash('message','Profil mis à jour');
            return $this->redirectToRoute('app_user');
        }
        
        return $this->render('user/editprofile.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/user/pass/edit', name: 'user_pass_edit')]
    public function editPass(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        if (!($this->getUser())) {
            return $this->redirectToRoute('app_login');
        }

        if($request->isMethod('POST')){
            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            // On vérifie si les 2 mots de passe sont identiques
            if($request->request->get('pass') == $request->request->get('pass2')){
                $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('pass')));
                $em->flush();
                if (in_array('ROLE_ADMIN', $user->getRoles())) {
                    $this->addFlash('message', 'Mot de passe mis à jour avec succès');
                    return $this->redirectToRoute('admin_profil'); 
                }
                $this->addFlash('message', 'Mot de passe mis à jour avec succès');
                return $this->redirectToRoute('app_user');
            }else{
                $this->addFlash('error', 'Les deux mots de passe ne sont pas identiques');
            }
        }
        return $this->render('user/editpass.html.twig');
    }

}