<?php

namespace App\Controller;
use App\Form\StudentType;
use App\Entity\Student;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\StudentRepository;

class StudentController extends AbstractController
{
    #[Route('/student', name: 'app_student')]
    public function index(): Response
    {
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }
    #[Route('/list', name: 'list_Student')]
    public function listStudent(){
        return new Response ("Bonjour mes étudiants");
    }
    
    #[Route('/redirect', name: 'red_Student')]
    public function red(): RedirectResponse
    {
        return $this->redirect('/student');
    }




    #[Route('/students', name: 'listStudent')]
    public function listStudents(StudentRepository $repository)
    {
        $student=$repository->findAll();
        return $this->render("student/listStudent.html.twig",array ("tabStudent"=>$student));
    }

    #[Route('/AjouterStudent', name: 'AjouterStudent')]
    public function create(Request $request){
        $student = new Student();
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($student);
            $entityManager->flush();

            return $this->redirectToRoute('listStudent');
        }

        return $this->render('student/AjouterStudent.html.twig',[
            'form' => $form->createView()
        ]);
    }

    #[Route('/ModifierStudent/{id}', name: 'ModifierStudent')]

    public function update(Request $request, $id){
        $student = $this->getDoctrine()->getRepository(Student::class)->find($id);
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($student);
            $entityManager->flush();

            return $this->redirectToRoute('listStudent');
        }

        return $this->render('student/ModifierStudent.html.twig',[
            'form' => $form->createView()
        ]);
    }
    

    #[Route('/SupprimerStudent/{id}', name: 'SupprimerStudent')]

    public function delete($id){
        $student = $this->getDoctrine()->getRepository(Student::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($student);
        $entityManager->flush();
        return $this->redirectToRoute('listStudent');
    }
}
