<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Service;
use App\Entity\Contact;
use App\Entity\Stats;
use App\Entity\Post;
use App\Form\ContactType;


class MainController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $serviceRepository = $this->getDoctrine()->getRepository(Service::class);
        $postRepository = $this->getDoctrine()->getRepository(Post::class);
        $posts = $postRepository->findAll();
        $services = $serviceRepository->findBy([], ['id' => 'DESC'], 4);
        $statRepository = $this->getDoctrine()->getRepository(Stats::class);
        $stats = $statRepository->findAll();
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact, ['action' => $this->generateUrl('save_contact'), 'method' => 'POST']);
        return $this->render('main/index.html.twig', ['services' => $services, 'posts' => $posts, 'stats' => $stats, 'form' => $form->createView()]);
    }
    /**
     * @Route("/page1", name="page1")
     */
    public function page1(): Response
    {
        return $this->render('main/page1.html.twig');
    }
    /**
     * @Route("/services", name="all_services")
     */
    public function services(): Response
    {
        $serviceRepository = $this->getDoctrine()->getRepository(Service::class);
        $services = $serviceRepository->findAll();
        return $this->render('main/services.html.twig', ['services' => $services]);
    }
    /**
     * @Route("/save_contact", name="save_contact")
     */
    public function saveContact(Request $request): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();
            $this->addFlash('success', 'Votre message a été bien enregistré');
            return $this->redirectToRoute('index');
        }

        return $this->redirectToRoute('index');

    }
}