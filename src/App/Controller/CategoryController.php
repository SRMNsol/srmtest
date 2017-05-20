<?php

namespace App\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use App\Entity\Category;
use App\Form\CategoryType;

class CategoryController
{
    protected $categoryRepository;
    protected $em;

    public function __construct(EntityRepository $categoryRepository, EntityManager $em)
    {         
        $this->categoryRepository = $categoryRepository;
        $this->em = $em;
    }

    public function listCategories(Application $app)
    {   
        $categories = $this->categoryRepository->findBy([], ['name' => 'ASC']);
/*

            $em = $app['orm.em'];
            $connection = $em->getConnection();

            $RAW_QUERY = 'SELECT * , count(m.category_id) as tot FROM Category as c  INNER JOIN Merchant as m ON c.id=m.category_id GROUP BY m.category_id';

            $statement = $connection->prepare($RAW_QUERY);
            $statement->execute();
            $custom = $statement->fetchAll();
echo '<pre>';
            echo count($custom ); exit;
*/

     
     
       
        return new Response($app['twig']->render('category_list.html.twig', [
            'categories' => $categories,
        ]));
    }

    public function editCategory(Category $category = null, Request $request, Application $app)
    {
        $form = $app['form.factory']->create(new CategoryType(), $category);
        $form->handleRequest($request);

        if ($form->isValid()) {
            try {
                $category = $form->getData();
                $this->em->persist($category);
                $this->em->flush();
                $app['session']->getFlashBag()->add('success', 'Category updated');

                return $app->redirect($app['url_generator']->generate('category_edit', ['category' => $category->getId()]));
            } catch (\Exception $e) {
                $app['session']->getFlashBag()->add('danger', 'Update failed');
            }
        }

        return new Response($app['twig']->render('category_edit.html.twig', [
            'form' => $form->createView(),
        ]));
    }

    public function deleteCategory(Category $category, Application $app)
    {
        try {
            $this->em->remove($category);
            $this->em->flush();
            $app['session']->getFlashBag()->add('success', sprintf('Category \'%s\' deleted', $category->getName()));
        } catch (\Exception $e) {
            $app['session']->getFlashBag()->add('danger', sprintf('Failed deleting category \'%s\'', $category->getName()));
        }

        return $app->redirect($app['url_generator']->generate('category_list'));
    }
}
