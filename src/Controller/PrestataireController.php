<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Compte;
use App\Form\UserType;
use App\Form\CompteType;
use App\Entity\Prestataire;
use App\Form\PrestataireType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PrestataireRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



/**
 * @Route("/prestataire")
 */
class PrestataireController extends AbstractController
{
    /**
     * @Route("/", name="prestataire_index", methods={"GET"})
     */
    public function index(PrestataireRepository $prestataireRepository): Response
    {
        return $this->render('prestataire/index.html.twig', [
            'prestataires' => $prestataireRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="prestataire_new", methods={"GET","POST"})
     */
    public function new(SerializerInterface $ser, PrestataireRepository $prestataireRepository,Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        
        $prestataire = new Prestataire();
        $form = $this->createForm(PrestataireType::class, $prestataire);
        $form->handleRequest($request);
        $rep=$request->request ->all();
        $rep += ['roles' => ['ROLES_PRESTATAIRE']];
        $form->submit($rep);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($prestataire);

        $user = new User;
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $form->submit($rep);
        
        $user->setIdprestataire($prestataire);
        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);

        $compte = new Compte;
        $form = $this->createForm(CompteType::class, $compte); 
        $form->handleRequest($request); 
        $form->submit($rep);
        $jour = date('d');
        $mois = date('m');
        $annee = date('Y');
        $heure = date('H');
        $minute = date('i');
        $seconde = date('s');
        $generer = $jour.$mois.$annee.$heure.$minute.$seconde;
        if (isset($generer)) {
            $compte->setNumcompte($generer);
            $compte->setMontant(75000);
            $compte->setIdprestataire($prestataire);

            $entityManager->persist($compte);
            $entityManager->flush();
            $reponse = $ser->serialize('json');
            return new Response($reponse);
        }
       
    }

    /**
     * @Route("/{id}", name="prestataire_show", methods={"GET"})
     */
    public function show(Prestataire $prestataire): Response
    {
        return $this->render('prestataire/show.html.twig', [
            'prestataire' => $prestataire,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="prestataire_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Prestataire $prestataire): Response
    {
        $form = $this->createForm(PrestataireType::class, $prestataire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('prestataire_index');
        }

        return $this->render('prestataire/edit.html.twig', [
            'prestataire' => $prestataire,
            'form' => $form->createView(),
        ]);
    }
}
