<?php

namespace App\Controller;

use App\Entity\Realisateur;
use App\Form\RealisateurFormType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\RealisateurRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class AdminRealisateurController extends AbstractController
{
    #[Route('/adminRealisateur', name: 'app_admin_realisateur')]
    public function index(RealisateurRepository $repoR): Response
    {
        $realisateurs = $repoR->findAll();
        
        return $this->render('admin_realisateur/index.html.twig', [
            'controller_name' => 'AdminRealisateurController',
            'realisateurs' => $realisateurs
        ]);
    }

    #[Route('/voirRealisateur/{id}', name: 'app_voir_realisateur')]
    public function voirRealisateur(RealisateurRepository $repoR, $id): Response
    {
        $realisateur = $repoR->find($id);
        
        return $this->render('admin_realisateur/voirRealisateur.html.twig', [
            'controller_name' => 'AdminRealisateurController',
            'realisateur' => $realisateur
        ]);
    }

    #[Route('/supprimerRealisateur/{id}', name: 'app_supprimer_realisateur')]
    public function supprimerRealisateur(RealisateurRepository $repoR, EntityManagerInterface $em, $id): Response
    {        
        try {
            if ($repoR->find($id)) {
                $realisateur = $repoR->find($id);
                $em->remove($realisateur);
                $em->flush();
                
                $this->addFlash('success', 'Realisateur retiré.');
                return $this->redirectToRoute('app_admin_realisateur'); 
            }            

        } catch (\Exception $e) {
            $this->addFlash('error', $e->getMessage());
            return $this->redirectToRoute('app_admin_realisateur');
        }
                
        return $this->redirectToRoute('app_admin_realisateur');       

    }

    #[Route('/ajouterRealisateur', name: 'app_ajouter_realisateur')]
    public function ajouterRealisateur(EntityManagerInterface $em, Request $request): Response
    {
        $realisateur = new Realisateur();
        $form = $this->createForm(RealisateurFormType::class, $realisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try {
                $realisateur->setNom(htmlspecialchars(trim($form->get('nom')->getData())));               
                
                $em->persist($realisateur);
                $em->flush();
                $this->addFlash('success', 'Réalisateur enregistré.');

                return $this->redirectToRoute('app_admin_realisateur');
                
            } catch (\Exception $e) {
                $this->addFlash('error', $e->getMessage());
                
                return $this->redirectToRoute('app_admin_realisateur');               
            }
        }
        
        return $this->render('admin_realisateur/ajouterRealisateur.html.twig', [
            'controller_name' => 'RealisateurController',            
            'form' => $form->createView(),
        ]);
    }

    #[Route('/modifierRealisateur/{id}', name: 'app_modifier_realisateur')]
    public function modifierRealisateur(RealisateurRepository $repoR, EntityManagerInterface $em, Request $request, $id): Response
    {
        $realisateur = $repoR->find($id);
        
        $form = $this->createForm(RealisateurFormType::class, $realisateur);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            try {
                if ($form->get('nom')->getData()) {
                    $realisateur->setNom(htmlspecialchars(trim($form->get('nom')->getData())));
                    
                    $em->persist($realisateur);
                    $em->flush();
                    $this->addFlash('success', 'Réalisateur modifié.');

                    return $this->redirectToRoute('app_admin_realisateur');
                }                
                
            } catch (\Exception $e) {
                $this->addFlash('error', $e->getMessage());
                
                return $this->redirectToRoute('app_admin_realisateur');               
            }
        }
            
        return $this->render('admin_realisateur/modifierRealisateur.html.twig', [
            'controller_name' => 'AdminRealisateurController',
            'realisateur' => $realisateur,
            'form' => $form->createView(),
        ]);        
    }
    
}