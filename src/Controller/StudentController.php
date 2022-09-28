<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

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
}
