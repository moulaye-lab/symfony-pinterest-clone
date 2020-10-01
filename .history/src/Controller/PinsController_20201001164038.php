<?php

namespace App\Controller;

use App\Repository\PinRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PinsController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(PinRepository $pinRepository)
    {
       $pins= $pinRepository->findAll();
        
        return $this->render('pins/index.html.twig', [
            'pins' => $pins
        ]);
    }

    
    /**
     * show
     *
     * @Route("/pins/{id<[0-9]+>}", name="pin_show" )
     */
    public function show()
    {
        


        return $this->render('pins/index.html.twig', [
            'pins' => $pins
        ]);
    }
}
