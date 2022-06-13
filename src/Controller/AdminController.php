<?php

namespace App\Controller;

use App\Entity\Service;
use App\Entity\Stats;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin/main", name="admin_main")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
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
     * @Route("/admin/edit/{id}", name="admin_stat_edit")
     */
    public function stat_edit($id): Response
    {
       $em = $this->getDoctrine()->getRepository(Stats::class);
       $stat = $em->find($id);
       return null;
    }
    /**
     * @Route("/admin/delete/{id}", name="admin_stat_delete")
     */
    public function stat_delete($id): Response
    {
       $em = $this->getDoctrine()->getRepository(Stats::class);
       $stat = $em->remove($id);
       return new Response();
    }
    /**
     * @Route("/admin/stats", name="admin_stats")
     */
    public function stats(): Response
    {
       $em = $this->getDoctrine()->getRepository(Stats::class);
       $stats = $em->findAll();
        return $this->render('admin/stats.html.twig',
            ['stats' => $stats]
        );
    }
}
