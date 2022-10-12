<?php

namespace App\Controller;
use App\Form\ClubType;
use App\Entity\Club;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ClubRepository;


class ClubController extends AbstractController
{
    #[Route('/club', name: 'app_club')]
    public function index(): Response
    {
        return $this->render('club/index.html.twig', [
            'controller_name' => 'ClubController',
        ]);
    }
    #[Route('/club/listformation', name: 'list_club')]
    public function formations (){
        $var1='3A29';
        $var2='J23';
        $formations = array(
                array('ref' => 'form147', 'Titre' => 'Formation Symfony
                4','Description'=>'pratique',
                'date_debut'=>'12/06/2020', 'date_fin'=>'19/06/2020',
                'nb_participants'=>19) ,
                array('ref'=>'form177','Titre'=>'Formation SOA' ,
                'Description'=>'theorique','date_debut'=>'03/12/2020','date_fin'=>'10/12/2020',
                'nb_participants'=>0),
                array('ref'=>'form178','Titre'=>'Formation Angular' ,
                'Description'=>'theorique','date_debut'=>'10/06/2020','date_fin'=>'14/06/2020',
                'nb_participants'=>12));
                return $this->render('club/listformation.html.twig',array('classe'=>$var1,'salle'=>$var2,'tab_formations'=>$formations));
    }

    #[Route('/reservation/{nullformation}', name: 'app_reservation')]
    public function reservation($nullformation)
    {
        return $this->render('club/detail.html.twig',[
            'nullformation' => $nullformation,
    
            ]);
    }
    #[Route('/listClub', name: 'listClub')]
    public function listClub(ClubRepository $repository)
    {
        $club=$repository->findAll();
        return $this->render("club/listClub.html.twig",array ("tabClub"=>$club));
    }



    #[Route('/AjouterClub', name: 'AjouterClub')]
    public function create(Request $request){
        $club = new Club();
        $form = $this->createForm(ClubType::class, $club);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($club);
            $entityManager->flush();

            return $this->redirectToRoute('listClub');
        }

        return $this->render('Club/AjouterClub.html.twig',[
            'form' => $form->createView()
        ]);
    }

    #[Route('/ModifierClub/{id}', name: 'ModifierClub')]

    public function update(Request $request, $id){
        $club = $this->getDoctrine()->getRepository(Club::class)->find($id);
        $form = $this->createForm(ClubType::class, $club);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($club);
            $entityManager->flush();

            return $this->redirectToRoute('listClub');
        }

        return $this->render('Club/ModifierClub.html.twig',[
            'form' => $form->createView()
        ]);
    }
    

    #[Route('/SupprimerClub/{id}', name: 'SupprimerClub')]

    public function delete($id){
        $club = $this->getDoctrine()->getRepository(Club::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($club);
        $entityManager->flush();
        return $this->redirectToRoute('listClub');
    }


    
}
