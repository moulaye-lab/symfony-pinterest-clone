<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PinsController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */    
    /**
     * index
     *
     * @param  mixed $pinRepository
     * @return void
     */
    public function index(PinRepository $pinRepository)
    {
        return $this->render('pins/index.html.twig', [
            'controller_name' => 'PinsController',
        ]);
    }
}
