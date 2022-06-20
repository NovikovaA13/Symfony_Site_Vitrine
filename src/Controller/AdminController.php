<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\Service;
use App\Entity\Stats;
use App\Form\PostType;
use App\Form\ServiceType;
use App\Form\StatsType;
use App\Service\ImageUploader;
use App\Controller\AdminAbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AdminAbstractController
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
     * @Route("/admin/add_service", name="admin_add_service")
     */
    public function service_add(Request $request)
    {
        $service = new Service();
        $form = $this->createForm(ServiceType::class, $service);

        return parent::add($request, $service, $form, 'admin_services');
    }
    /**
     * @Route("/admin/edit_service/{id}", name="admin_edit_service")
     */
    public function service_edit(Request $request, int $id)
    {
        $service = $this->getDoctrine()->getRepository(Service::class)->find($id);
        $form = $this->createForm(ServiceType::class, $service);
        return parent::edit($request, $service, $form, 'admin_services', true);

    }
    /**
     * @Route("/admin/service_delete/{id}", name="admin_service_delete")
     */
    public function service_delete(int $id): Response
    {
        $service = $this->getDoctrine()->getRepository(Service::class)->find($id);
        return parent::delete($service, 'admin_services', true);
    }
    /**
     * @Route("/admin/stat_edit/{id}", name="admin_stat_edit")
     */
    public function stat_edit(Request $request, int $id): Response
    {
       $stat = $this->getDoctrine()->getRepository(Stats::class)->find($id);
       $form = $this->createForm(StatsType::class, $stat);
        return parent::edit($request, $stat, $form, 'admin_stats_view', false);

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
     * @Route("/admin/guestbook", name="admin_comments_view")
     */
    public function comments(): Response
    {
       $em = $this->getDoctrine()->getRepository(Comment::class);
       $comments = $em->findBy([], ['id' => 'DESC']);
        return $this->render('admin/guestbook.html.twig',
            ['comments' => $comments]
        );
    }
    /**
     * @Route("/admin/comment_delete/{id}", name="admin_comment_delete")
     */
    public function comment_delete(int $id): Response
    {
        $comment = $this->getDoctrine()->getRepository(Comment::class)->find($id);
        return parent::delete($comment, 'admin_comments_view', false);

    }
    /**
     * @Route("/admin/posts", name="admin_posts")
     */
    public function posts(): Response
    {
        $em = $this->getDoctrine()->getRepository(Post::class);
        $posts = $em->findAll();
        return $this->render('admin/posts.html.twig',
            ['posts' => $posts]
        );
    }
    /**
     * @Route("/admin/post_add", name="admin_add_post")
     */
    public function post_add(Request $request): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        return parent::add($request, $post, $form, 'admin_posts');

    }
    /**
     * @Route("admin/edit_post/{id}", name="admin_edit_post")
     */
    public function post_edit(Request $request, int $id)
    {
        $post = $this->getDoctrine()->getRepository(Post::class)->find($id);
        $form = $this->createForm(PostType::class, $post);
        return parent::edit($request, $post, $form, 'admin_posts', true);
    }

    /**
     * @Route("/admin/post_delete/{id}", name="admin_post_delete")
     */
    public function post_delete(int $id): Response
    {
        $post = $this->getDoctrine()->getRepository(Post::class)->find($id);
        return parent::delete($post, 'admin_posts', true);

    }
}
