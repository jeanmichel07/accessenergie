<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\OffreElectricite;
use App\Entity\PerimetreElectricite;
use App\Entity\PermetreGaz;
use App\Entity\Vendeur;
use App\Repository\ClientRepository;
use App\Repository\ListOffreParFounisseurRepository;
use App\Repository\VendeurRepository;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Tests\Encoder\PasswordEncoder;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class AdminController
 * @package App\Controller
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    /**
     * @Route("/", name="admin")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    /**
     * @Route("/clien.list.html", name="listeclient")
     * @param ClientRepository $repository
     * @return Response
     */
    public function listClient(ClientRepository $repository){
        $client = $repository->findAll();
        return $this->render('admin/listClient.html.twig',[
            'client'=>$client
        ]);
    }
    /**
     * @param Request $request
     * @return Response
     * @Route("/client.new.html", name="newClient")
     */
    public function newClient(Request $request){
        $client = new Client();
        $form = $this->createFormBuilder($client)
            ->add('raisonSocial', TextType::class,['required'=>true])
            ->add('nomSignataire', TextType::class,['required'=>true])
            ->add('prenomSignataire', TextType::class,['required'=>true])
            ->add('fonctionSignataire', TextType::class,['required'=>true])
            ->add('telephone', TextType::class,['required'=>true])
            ->add('email', TextType::class,['required'=>true])
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $infos = $request->get('form');
            $client->setRaisonSocial($infos['raisonSocial'])
                   ->setNomSignataire($infos['nomSignataire'])
                   ->setPrenomSignataire($infos['prenomSignataire'])
                   ->setFonctionSignataire($infos['fonctionSignataire'])
                   ->setTelephone($infos['telephone'])
                   ->setEmail($infos['email']);
            $this->em->persist($client);
            $this->em->flush();
            return $this->redirectToRoute('addPerimetreElec',['id'=>$client->getId()]);
        }
        return $this->render('admin/newClient.html.twig',[
            'form' => $form->createView()
        ]);
    }
    /**
     * @param Client $client
     * @param Request $request
     * @return Response
     * @throws \Exception
     * @Route("/add/perimetre.electricite-{id}.html", name="addPerimetreElec")
     */
    public function addPerimetreElec(Client $client, Request $request){
        $perElec = new PerimetreElectricite();
        $from = $this->createFormBuilder($perElec)
            ->add('dateFourniture',DateTimeType::class, ['widget' => 'single_text','label'=>'Date de début de fourniture '])
            ->add('PDL', TextType::class,['label'=>'PDL:'])
            ->add('nomPtLivraison', TextType::class,['label'=>'Nom du point de livraison:'])
            ->add('segmentation', ChoiceType::class, ['choices'=>[
                    'Choisissez votre segmentation'=>'',
                    'BT>13'=>'BT>13',
                    'HTA'=>'HTA'
                ]])
            ->add('pte', TextType::class,['label'=>'Pte:'])
            ->add('HPH', TextType::class,['label'=>'HPH:'])
            ->add('HCH', TextType::class,['label'=>'HCH:'])
            ->add('HPE', TextType::class,['label'=>'HPE:'])
            ->add('HCE', TextType::class,['label'=>'HCE:'])
            ->getForm();
        $from->handleRequest($request);
        if($from->isSubmitted() && $from->isValid()){
            $gaz = $request->get('gaz');
                // return $this->redirectToRoute('addGazElec', ['id'=>$client->getId()]);
                $infos = $request->get('form');
                $perElec
                    ->setClient($client)
                    ->setDateFourniture(new \DateTime($infos['dateFourniture']))
                    ->setPDL($infos['PDL'])
                    ->setNomPtLivraison($infos['nomPtLivraison'])
                    ->setSegmentation($infos['segmentation'])
                    ->setPte($infos['pte'])
                    ->setHCE($infos['HCE'])
                    ->setHCH($infos['HCH'])
                    ->setHPE($infos['HPE'])
                    ->setHPH($infos['HPH'])
                    ->setTotal($infos['total']);
                $this->em->persist($perElec);
                $this->em->flush();
                return $this->redirectToRoute('addPerimetreElec',['id'=>$client->getId()]);

        }
        return $this->render('admin/newPerElec.html.twig',[
            'form'=>$from->createView(),
            'client'=>$client
        ]);
    }

    /**
     * @param Client $client
     * @param Request $request
     * @return Response
     * @throws \Exception
     * @Route("/add/perimetre.gaz-{id}.html", name="addGazElec")
     */
    public function addPerimetreGaz(Client $client, Request $request){
        $perGaz = new PermetreGaz();
        $form = $this->createFormBuilder($perGaz)
            ->add('dateFourniture', DateTimeType::class, ['widget' => 'single_text','label'=>'Date de début de fourniture '])
            ->add('PCE', TextType::class,['label'=>'PCE'])
            ->add('nomPtLivraison', TextType::class, ['label'=>'Nom du point de livraison '])
            ->add('CAR', TextType::class, ['label'=>'CAR'])
            ->add('profil', ChoiceType::class, [
                'choices'=>['T1'=>'T1','T2'=>'T2','T3'=>'T3'],
                'label'=>'Profil'])
            ->add('tarifDistribution', ChoiceType::class, [
                'choices'=>['PO11'=>'PO11','PO12'=>'PO12','PO13'=>'PO13','PO14'=>'PO14','PO15'=>'PO15','PO16'=>'PO16','PO17'=>'PO17','PO18'=>'PO18','PO19'=>'PO19',],
                'label'=>'Tarif de distribution '])
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $infos = $request->get('form');
            $perGaz->setClient($client)
                ->setDateFourniture(new \DateTime($infos['dateFourniture']))
                ->setCAR($infos['CAR'])
                ->setPCE($infos['PCE'])
                ->setTarifDistribution($infos['tarifDistribution'])
                ->setNomPtLivraison($infos['nomPtLivraison'])
                ->setProfil($infos['profil']);
            $this->em->persist($perGaz);
            $this->em->flush();
            return $this->redirectToRoute('addGazElec', ['id'=>$client->getId()]);
        }
        return $this->render('admin/newPerGaz.html.twig', [
            'form'=>$form->createView(),
            'client'=>$client
        ]);
    }
    /**
     * @Route("/detailles/client-{id}.html", name="detailleClient")
     * @param Client $client
     * @return Response
     */
    public function detailClient(Client $client){
        return $this->render('admin/detailleClient.html.twig',['c'=>$client]);
    }
    /**
     * @param \Swift_Mailer $mailer
     * @param Request $request
     * @param Client $client
     * @param UserPasswordEncoderInterface $encoder
     * @return RedirectResponse
     * @Route("/send/email.client-{id}.html", name="sendemailclient")
     */
    public function sendEmail(\Swift_Mailer $mailer, Request $request, Client $client, UserPasswordEncoderInterface $encoder){
        $plainPassword = date("Y").'clt'.$client->getId().$client->getPrenomSignataire();
        $encoded = $encoder->encodePassword($client, $plainPassword);
        $client->setUsername('clt'.$client->getId().''.date("Y"))->setPassword($encoded);
        $this->em->persist($client);
        $this->em->flush();
        $message = (new \Swift_Message('Votre information d\'identification'))
            ->setFrom('tombokely@gmail.com')
            ->setTo($client->getEmail())
            ->setBody(
                $this->renderView(
                    'admin/emailClient.html.twig',[
                        'username'=>'clt'.$client->getId().''.date("Y"),
                        'password'=>$plainPassword
                    ]
                ),
                'text/html'
            );
        $mailer->send($message);
        return $this->redirectToRoute('listeclient');
    }
    /**
     * @Route("/vendeur.list.html", name="listVendeur")
     * @param VendeurRepository $repository
     * @return Response
     */
    public function indexVendeur(VendeurRepository $repository){
        $vendeur = $repository->findAll();
        return $this->render('admin/listVendeur.html.twig',['v'=>$vendeur]);
    }
    /**
     * @param Request $request
     * @return Response
     * @Route("/vendeur.new.html", name="newVendeur")
     */
    public function newVendeur(Request $request){
        $vendeur = new Vendeur();
        $form = $this->createFormBuilder($vendeur)
            ->add('nom')
            ->add('prenom')
            ->add('fonction')
            ->add('email')
            ->add('contact')->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $infos = $request->get('form');
            $vendeur->setNom($infos['nom'])
                ->setPrenom($infos['prenom'])
                ->setFonction($infos['fonction'])
                ->setContact($infos['contact']);
            $this->em->persist($vendeur);
            $this->em->flush();
            return $this->redirectToRoute('sendemailVendeur',['id'=>$vendeur->getId()]);
        }
        return $this->render('admin/newVendeur.html.twig',['form'=>$form->createView()]);
    }

    /**
     * @param \Swift_Mailer $mailer
     * @param Request $request
     * @param Vendeur $vendeur
     * @param UserPasswordEncoderInterface $encoder
     * @return RedirectResponse
     * @Route("/send/email.vendeur-{id}.html", name="sendemailVendeur")
     */
    public function sendEmailVendeur(\Swift_Mailer $mailer, Request $request, Vendeur $vendeur, UserPasswordEncoderInterface $encoder){
        $plainPassword = date("Y").'vdr'.$vendeur->getId().$vendeur->getPrenom();
        $encoded = $encoder->encodePassword($vendeur, $plainPassword);
        $vendeur->setUsername('vdr'.$vendeur->getId().''.date("Y"))->setPassword($encoded);
        $this->em->persist($vendeur);
        $this->em->flush();
        $message = (new \Swift_Message('Votre information d\'identification'))
            ->setFrom('tombokely@gmail.com')
            ->setTo($vendeur->getEmail())
            ->setBody(
                $this->renderView(
                    'admin/emailClient.html.twig',[
                        'username'=>'vdr'.$vendeur->getId().''.date("Y"),
                        'password'=>$plainPassword
                    ]
                ),
                'text/html'
            );
        $mailer->send($message);
        return $this->redirectToRoute('listVendeur');
    }
}