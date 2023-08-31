<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/users", name="admin_users_")
 * @package App\Controller\Admin
 */
class UsersController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(UserRepository $usersRepo)
    {
        return $this->render('admin/users/index.html.twig', [
            'users' => $usersRepo->findAll()
        ]);
    }

    /**
     * @Route("/supprimer/{id}", name="supprimer")
     */
    public function supprimer(User $user)
    {

        if (!$this->getUser() || !$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_login');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        $this->addFlash('message', 'Compte supprimé avec succès');
        return $this->redirectToRoute('admin_users_home');
    }
}