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
use App\Repository\ClassroomRepository;
use App\Form\SearchStudentType;

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



    #[Route('/AjouterStudent2', name: 'AjouterStudent2')]
    public function add(Request $request , StudentRepository $repository){
        $student = new Student();
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $repository->add($student ,true);

            return $this->redirectToRoute('listStudent');
        }

        return $this->renderForm('student/AjouterStudent2.html.twig',array ("tabStudent"=>$form));
    }

    #[Route('/SupprimerStudent2/{id}', name: 'SupprimerStudent')]

    public function delete2($id, StudentRepository $repository){
        $student = $this->getDoctrine()->getRepository(Student::class)->find($id);
        $repository->remove($student ,true);
        return $this->redirectToRoute('listStudent');
    }
    #[Route('/showClassroom/{id}', name: 'showClassroom')]
    public function showClassroom(StudentRepository $repo,$id,ClassroomRepository $repository)
    {
        $classroom = $repository->find($id);
       $students= $repo->getStudentsByClassroom($id);
        return $this->render("classroom/showClassroom.html.twig",array(
            'showClassroom'=>$classroom,
            'tabStudent'=>$students
        ));
    }
    #[Route('/listStudent', name: 'list_student')]
    public function listStudentss(Request $request,StudentRepository $repository)
    {
        $students= $repository->findAll();
       // $students= $this->getDoctrine()->getRepository(StudentRepository::class)->findAll();
        $sortByMoyenne= $repository->sortByMoyenne();
       $formSearch= $this->createForm(SearchStudentType::class);
       $formSearch->handleRequest($request);
       $topStudents= $repository->topStudent();
       if($formSearch->isSubmitted()){
           $nce= $formSearch->get('nce')->getData();
           //var_dump($nce).die();
           $result= $repository->searchStudent($nce);
           return $this->renderForm("student/list.html.twig",
               array("tabStudent"=>$result,
                   "sortByMoyenne"=>$sortByMoyenne,
                   "searchForm"=>$formSearch));
       }
         return $this->renderForm("student/list.html.twig",
           array("tabStudent"=>$students,
               "sortByMoyenne"=>$sortByMoyenne,
                "searchForm"=>$formSearch,
               'topStudents'=>$topStudents));
    }

}
