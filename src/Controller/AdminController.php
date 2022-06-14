<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Service;
use App\Entity\Stats;
use App\Form\ServiceType;
use App\Form\StatsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin/", name="admin_main")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }
    /**
     * @Route("/admin/services", name="admin_services")
     */
    public function services(): Response
    {
       $em = $this->getDoctrine()->getRepository(Service::class);
       $services = $em->findAll();
        return $this->render('admin/services.html.twig',
            ['services' => $services]
        );
    }

    /**
     * @Route("admin/add_service", name="admin_add_service")
     */
    public function service_add(Request $request)
    {
        $service = new Service();
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $originalFileName = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFileName);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
                try {
                    $imageFile->move($this->getParameter('images_directory'), $newFilename);
                } catch (FileException $e){
                    var_dump($e);
                }
                $service->setImage($newFilename);

            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($service);
            $em->flush();
            return $this->redirectToRoute('admin_edit_service', ['id' => $service->getId()]);
        }
        return $this->render('admin/add_service.html.twig', ['form' => $form->createView()]);
    }
    /**
     * @Route("admin/edit_service/{id}", name="admin_edit_service")
     */
    public function service_edit(Request $request, int $id)
    {
        $service = $this->getDoctrine()->getRepository(Service::class)->find($id);
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $originalFileName = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFileName);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
                try {
                    $imageFile->move($this->getParameter('images_directory'), $newFilename);
                } catch (FileException $e){
                    var_dump($e);
                }
                try {
                    unlink('./build/images/'.$service->getImage());
                } catch (Exception $ex) {
                    var_dump($ex);

                }
                $service->setImage($newFilename);

            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($service);
            $em->flush();
            return $this->redirectToRoute('admin_edit_service', ['id' => $service->getId()]);
        }
        return $this->render('admin/edit_service.html.twig', ['form' => $form->createView()]);
    }
    /**
     * @Route("/admin/service_delete/{id}", name="admin_service_delete")
     */
    public function service_delete(int $id): Response
    {
        $service = $this->getDoctrine()->getRepository(Service::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        try {
            unlink('./build/images/'.$service->getImage());
        } catch (Exception $ex) {
            var_dump($ex);

        }
        $em->remove($service);
        $em->flush();

        return $this->redirectToRoute('admin_services');
    }
    /**
     * @Route("/admin/stat_edit/{id}", name="admin_stat_edit")
     */
    public function stat_edit(Request $request, int $id): Response
    {
       $em = $this->getDoctrine()->getRepository(Stats::class);
       $stats = $em->find($id);
       $form = $this->createForm(StatsType::class, $stats);
       $form->handleRequest($request);
       if ($form->isSubmitted() && $form->isValid()) {
           $em = $this->getDoctrine()->getManager();
           $em->flush();
       }
       return $this->render('admin/stats_edit.html.twig', ['form' => $form->createView()]);
    }
    /**
     * @Route("/admin/stats", name="admin_stats_view")
     */
    public function stats(): Response
    {
       $em = $this->getDoctrine()->getRepository(Stats::class);
       $stats = $em->findAll();
        return $this->render('admin/stats.html.twig',
            ['stats' => $stats]
        );
    }
    /**
     * @Route("/admin/contacts", name="admin_contacts_view")
     */
    public function contacts(): Response
    {
       $em = $this->getDoctrine()->getRepository(Contact::class);
       $contacts = $em->findAll();
        return $this->render('admin/contacts.html.twig',
            ['contacts' => $contacts]
        );
    }
    /**
     * @Route("/admin/contact_delete/{id}", name="admin_contact_delete")
     */
    public function contact_delete(int $id): Response
    {
        $contact = $this->getDoctrine()->getRepository(Contact::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($contact);
        $em->flush();
        return $this->redirectToRoute('admin_contacts_view');
    }


}
