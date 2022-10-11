<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Form\ClassroomType;
use App\Entity\Student;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ClubRepository;
use App\Repository\StudentRepository;
use App\Repository\ClassroomRepository;

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
    #[Route('/clubs', name: 'app_club')]
    public function listClub(ClubRepository $repository)
    {
        $club=$repository->findAll();
        return $this->render("club/listClub.html.twig",array ("tabClub"=>$club));
    }


    #[Route('/students', name: 'liststudents')]
    public function listStudents(StudentRepository $repository)
    {
        $student=$repository->findAll();
        return $this->render("club/listStudent.html.twig",array ("tabStudent"=>$student));
    }

    #[Route('/listclassroom', name: 'listclassroom')]
    public function listclassroom(ClassroomRepository $repository)
    {
        $classroom=$repository->findAll();
        return $this->render("club/listclassroom.html.twig",array ("tabclassroom"=>$classroom));
    }
    #[Route('/AjouterClassroom', name: 'AjouterClassroom')]
    public function create(Request $request){
        $class = new Classroom();
        $form = $this->createForm(ClassroomType::class, $class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($class);
            $entityManager->flush();

            return $this->redirectToRoute('listclassroom');
        }

        return $this->render('club/AjouterClassroom.html.twig',[
            'form' => $form->createView()
        ]);
    }

    #[Route('/ModifierClassroom/{id}', name: 'ModifierClassroom')]

    public function update(Request $request, $id){
        $class = $this->getDoctrine()->getRepository(Classroom::class)->find($id);
        $form = $this->createForm(ClassroomType::class, $class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($class);
            $entityManager->flush();

            return $this->redirectToRoute('listclassroom');
        }

        return $this->render('club/ModifierClassroom.html.twig',[
            'form' => $form->createView()
        ]);
    }
    

    #[Route('/SupprimerClassroom/{id}', name: 'SupprimerClassroom')]

    public function delete($id){
        $class = $this->getDoctrine()->getRepository(Classroom::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($class);
        $entityManager->flush();
        return $this->redirectToRoute('listclassroom');
    }
/*

    #[Route('/AjouterStudent', name: 'AjouterStudent')]
    public function createS(Request $request){
        $class = new Student();
        $form = $this->createForm(ClassroomType::class, $class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($class);
            $entityManager->flush();

            return $this->redirectToRoute('liststudents');
        }

        return $this->render('club/AjouterStudent.html.twig',[
            'form' => $form->createView()
        ]);
    }

*/












    
}
