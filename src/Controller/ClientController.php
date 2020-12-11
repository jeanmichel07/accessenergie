<?php

namespace App\Controller;

use App\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ClientController
 * @package App\Controller
 * @Route("/client")
 */
class ClientController extends AbstractController
{
    /**
     * @Route("/accueil.html", name="client")
     */
    public function index(): Response
    {
        $client = $this->getUser();
        return $this->render('client/index.html.twig',['c'=>$client]);
    }
    /**
     * @Route("/perimetre-electricite.html", name="perimetreElec")
     */
    public function showPerimElec(){
        $client = $this->getUser();
        return $this->render('client/perimElec.html.twig',[
            'c'=>$client
        ]);
    }
    /**
     * @Route("/perimetre-gaz.html", name="perimetreGaz")
     */
    public function showPerimGaz(){
        $client = $this->getUser();
        return $this->render('client/perimGaz.html.twig',[
            'c'=>$client
        ]);
    }
}
