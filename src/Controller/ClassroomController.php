<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Form\ClassroomType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ClassroomRepository;

class ClassroomController extends AbstractController
{
    #[Route('/classroom', name: 'app_classroom')]
    public function index(): Response
    {
        return $this->render('classroom/index.html.twig', [
            'controller_name' => 'ClassroomController',
        ]);
    }

    #[Route('/listclassroom', name: 'listclassroom')]
    public function listclassroom(ClassroomRepository $repository)
    {
        $classroom=$repository->findAll();
        return $this->render("classroom/listclassroom.html.twig",array ("tabclassroom"=>$classroom));
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

        return $this->render('classroom/AjouterClassroom.html.twig',[
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

        return $this->render('classroom/ModifierClassroom.html.twig',[
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
