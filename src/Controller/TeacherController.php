<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeacherController extends AbstractController
{
    #[Route('/teacher', name: 'app_teacher')]
    public function index(): Response
    {
        return $this->render('teacher/index.html.twig', [
            'controller_name' => 'TeacherController',
        ]);
    }
    #[Route('/show/{name}', name: 'show_Teacher')]
    public function showTeacher($name){
        return new Response ("Hello teacher :".$name);
        
    }
    #[Route('/interface/{name}', name: 'interface_Teacher')]
    public function interfaceTeacher($name){
        return $this->render('teacher/showTeacher.html.twig',[
        'name' => $name,

        ]);
    }
    
}
