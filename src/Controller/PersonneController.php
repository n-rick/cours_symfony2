<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Form\PersonneType;
use App\Form\OnlyPersonneType;
use App\Repository\PersonneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// #[IsGranted('ROLE_ADMIN')] # Restreindre l'accès à toutes les actions du controlleur.
class PersonneController extends AbstractController
{
    #[Route('/personne', name: 'app_personne')]
    public function index(): Response
    {
        return $this->render('personne/index.html.twig', [
            'controller_name' => 'PersonneController',
        ]);
    }

    #[IsGranted('ROLE_ADMIN')] # Restreindre l'accès à une action en particulier.
    #[Route("/personne/add", name: "personne_add")]
    function addForm(Request $request, EntityManagerInterface $em)
    {
        $personne = new Personne();
        $form = $this->createForm(PersonneType::class, $personne);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $personne = $form->getData();
            $em->persist($personne);
            $em->flush();
            return $this->redirectToRoute("personne_show_all");
        }
        return $this->render('personne/add.html.twig', [
            'controller_name' => 'PersonneController',
            'form' => $form->createView(),
        ]);
    }

    #[Route("/onlypersonne/add", name: "only_personne_add")]
    function addFormOnly(Request $request, EntityManagerInterface $em)
    {
        $personne = new Personne();
        $form = $this->createForm(OnlyPersonneType::class, $personne);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $personne = $form->getData();
            $em->persist($personne);
            $em->flush();
            return $this->redirectToRoute("personne_show_all");
        }
        return $this->render('personne/add.html.twig', [
            'controller_name' => 'PersonneController',
            'form' => $form->createView(),
        ]);
    }

    #[Route('/personne/show', name: 'personne_show_all')]
    public function showAllPersonne(PersonneRepository $personneRepository)
    {
        $personnes = $personneRepository->findAll();
        if (!$personnes) {
            throw $this->createNotFoundException('La table est vide');
        }
        return $this->render('personne/show.html.twig', [
            'controller_name' => 'PersonneController',
            'personnes' => $personnes,
        ]);
    }
}
