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
use Knp\Component\Pager\PaginatorInterface;


class MainController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $serviceRepository = $this->getDoctrine()->getRepository(Service::class);
        $postRepository = $this->getDoctrine()->getRepository(Post::class);
        $posts = $postRepository->findBy([], ['id' => 'DESC']);
        $services = $serviceRepository->findBy([], ['id' => 'DESC'], 4);
        $statRepository = $this->getDoctrine()->getRepository(Stats::class);
        $stats = $statRepository->findBy([], ['id' => 'DESC']);
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact, ['action' => $this->generateUrl('save_contact'), 'method' => 'POST']);
        return $this->render('main/index.html.twig', ['services' => $services, 'posts' => $posts, 'stats' => $stats, 'form' => $form->createView()]);
    }
    /**
     * @Route("/about", name="about")
     */
    public function about(): Response
    {
        return $this->render('main/about.html.twig');
    }
    /**
     * @Route("/guestbook", name="guestbook")
     */
    public function guestbook(Request $request, PaginatorInterface $paginator): Response
    {
        $contactRepository = $this->getDoctrine()->getRepository(Contact::class);
        $data = $contactRepository->findBy([], ['id' => 'DESC']);
        $contacts = $paginator->paginate($data, $request->query->getInt('page', 1), 7);
        $total = count($data);
        $contacts->setCustomParameters([
            'align' => 'center', # center|right (for template: twitter_bootstrap_v4_pagination and foundation_v6_pagination)
            'style' => 'bottom',
            'span_class' => 'whatever',
        ]);
        return $this->render('main/guestbook.html.twig', ['contacts' => $contacts, 'total' => $total]);
    }
    /**
     * @Route("/services", name="all_services")
     */
    public function services(): Response
    {
        $serviceRepository = $this->getDoctrine()->getRepository(Service::class);
        $services = $serviceRepository->findBy([], ['id' => 'DESC']);
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
            $this->addFlash('success', 'Your message has been saved.
');
            return $this->redirectToRoute('index');
        }

        return $this->redirectToRoute('index');

    }
    /**
     * @Route("/post/{id}", name="post")
     */
    public function post(int $id): Response
    {
        $post = $this->getDoctrine()->getRepository(Post::class)->find($id);
        return $this->render('main/post.html.twig', ['post' => $post ]);
    }
}
