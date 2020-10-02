<?php

namespace App\Controller;

use App\Entity\Pin;
use App\Form\CreatePinType;
use App\Repository\PinRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PinsController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(PinRepository $pinRepository)
    {
       $pins= $pinRepository->findBy([],['createdAt' => 'DESC']);
        
        return $this->render('pins/index.html.twig', [
            'pins' => $pins
        ]);
    }

    
    /**
     * show
     *
     * @Route("/pins/{id<[0-9]+>}", name="app_pin_show" )  // {id<[0-9]+>} signifie que le id doit etre un nombre
     */
    public function show(Pin $pin) : Response
    {
        


        return $this->render('pins/show.html.twig', [
            'pin' => $pin
        ]);
    }

    /**
     * 
     *@Route("/pins/{id<[0-9]+>}/edit",name="app_pin_edit")
     * @Route("/pins/create", name="app_pin_create" )  // {id<[0-9]+>} signifie que le id doit etre un nombre
     */

    public function create(Pin $pin,Request $request,EntityManagerInterface $manager) : Response
    {
        if (!$pin) {
         $pin=new Pin;
        }
        $form=$this->createForm(CreatePinType::class,$pin)
        ;
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($pin);
            $manager->flush();

         if (!$pin) {
            return $this->redirectToRoute('app_home');   
   
         }else{
            return $this->redirectToRoute('app_pin_edit',['id' => '']);   
 
         }

        }

        return $this->render('pins/create_pin.html.twig', [
            'createPin' => $form->createView()
            
        ]);
    }


}
