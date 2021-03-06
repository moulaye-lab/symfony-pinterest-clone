<?php

namespace App\Controller;

use App\Entity\Pin;
use App\Form\CreatePinType;
use App\Repository\PinRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PinsController extends AbstractController
{
    /**
     * @Route("/", name="app_home", methods="GET")
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
     * @Route("/pins/{id<[0-9]+>}", name="app_pin_show" ,methods="GET")  // {id<[0-9]+>} signifie que le id doit etre un nombre
     */
    public function show(Pin $pin) : Response
    {
        


        return $this->render('pins/show.html.twig', [
            'pin' => $pin
        ]);
    }

    /**
     * 
     *@Route("/pins/create", name="app_pin_create", methods={"POST","GET"},priority="1" )  
     *@Route("/pins/{id<[0-9]+>}/edit",name="app_pin_edit",methods={"GET","POST"})

     */

    public function create(Pin $pin = null ,Request $request,EntityManagerInterface $manager,UserRepository $user) : Response
    {
        if (!$pin) {
         $pin=new Pin;
        }
        $form=$this->createForm(CreatePinType::class,$pin)
        ;
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $janDoe=$user->findOneBy()
            $manager->persist($pin);
            $manager->flush();


         if ($pin->getId()==null) {
            $this->addFlash('success','Votre Pin a bien été crée');

            return $this->redirectToRoute('app_home');   
   
         }else{
            $this->addFlash('success','Votre Pin a bien été modifié');

            return $this->redirectToRoute('app_pin_edit',['id' => $pin->getId()]);   
 
         }

        }

        return $this->render('pins/create_pin.html.twig', [
            'createPin' => $form->createView(),
             'editMode' =>$pin->getId() !== null
        ]);
    }


    /**
     * delete
     *
     * @Route("/pins/{id<[0-9]+>}", name="app_pin_delete" ,methods="DELETE")  // {id<[0-9]+>} signifie que le id doit etre un nombre
     */
    public function delete(Request $request,Pin $pin,EntityManagerInterface $manager) : Response
    {
        if ($this->isCsrfTokenValid('pin_deletion_'.$pin->getId(), $request->request->get('csrf_token'))) {
           
        }
        $manager->remove($pin);
        $manager->flush();
        
        $this->addFlash('success','Votre Pin a bien été supprimer');

        
        return $this->redirectToRoute('app_home');   

    }

}
