<?php

namespace App\Controller;

use App\Entity\Service;
use App\Form\ServiceType;
use App\Service\ImageUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminAbstractController extends AbstractController
{
    public function delete($entity, string $route, bool $hasImage)
    {
        $em = $this->getDoctrine()->getManager();
        if ($hasImage) {
            ImageUploader::delete($entity->getImage());
        }
        $em->remove($entity);
        $em->flush();

        return $this->redirectToRoute($route);
    }
    public function add(Request $request, $entity, $form, string $route)
    {
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $newFilename = ImageUploader::upload($imageFile, $this->getParameter('images_directory'));
                $entity->setImage($newFilename);

            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return $this->redirectToRoute($route);
        }
        $name = ltrim(strrchr(get_class($entity), '\\'), '\\');
        return $this->render('admin/add_contenu.html.twig', ['name' => $name,'form' => $form->createView()]);

    }
    public function edit(Request $request, $entity, $form, string $route, bool $hasImage)
    {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($hasImage) {
                $imageFile = $form->get('image')->getData();
                if ($imageFile) {
                    $newFilename = ImageUploader::upload($imageFile, $this->getParameter('images_directory'));
                    $entity->setImage($newFilename);
                }
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return $this->redirectToRoute($route);
        }
        if ($hasImage) {
            $templateName = 'admin/edit_contenu.html.twig';
        }
        else {
            $templateName = 'admin/edit_stats.html.twig';
        }
        $name = ltrim(strrchr(get_class($entity), '\\'), '\\');
        return $this->render($templateName, ['name' => $name, 'form' => $form->createView()]);

    }
}
