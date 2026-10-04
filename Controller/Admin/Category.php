<?php

/**
 * This file is part of the Bono CMS
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Banner\Controller\Admin;

use Krystal\Stdlib\VirtualEntity;
use Cms\Controller\Admin\AbstractController;

final class Category extends AbstractController
{
    /**
     * Creates a form
     * 
     * @param \Krystal\Stdlib\VirtualEntity $category
     * @param string $title
     * @return string
     */
    private function createForm(VirtualEntity $category, $title)
    {
        // Append a breadcrumb
        $this->view->getBreadcrumbBag()->addOne('Banner', 'Banner:Admin:Banner@gridAction')
                                       ->addOne($title);

        return $this->view->render('category.form', [
            'category' => $category
        ]);
    }

    /**
     * Renders empty form
     * 
     * @return string
     */
    public function addAction()
    {
        return $this->createForm(new VirtualEntity(), 'Add category');
    }

    /**
     * Renders edit form
     * 
     * @param string $id
     * @return string
     */
    public function editAction($id)
    {
        $category = $this->getModuleService('categoryManager')->fetchById($id);

        if ($category !== false) {
            return $this->createForm($category, $this->translator->translate('Edit the category "%s"', $category->getName()));
        } else {
            return false;
        }
    }

    /**
     * Deletes a category by its associated ID
     * 
     * @param string $id
     * @return string The response
     */
    public function deleteAction($id)
    {
        $service = $this->getModuleService('categoryManager');
        $service->deleteById($id);

        $this->flashBag->set('success', 'Selected element has been removed successfully');

        return $this->json([
            'refresh' => true
        ]);
    }

    /**
     * Persists a category
     * 
     * @return string
     */
    public function saveAction()
    {
        $validator = $this->createValidation();
        
        $validator->field('category.name', 'Name')
                  ->required()
                  ->addRule('minlength', null, ['min' => 2]);

        if ($validator->isPassed()) {
            $service = $this->getModuleService('categoryManager');
            $input = $this->request->getPost('category');

            if (!empty($input['id'])) {
                if ($service->update($input)) {
                    $this->flashBag->set('success', 'The element has been updated successfully');

                    return $this->json([
                        'refresh' => true
                    ]);
                }

            } else {
                if ($service->add($input)) {
                    $this->flashBag->set('success', 'The element has been created successfully');

                    return $this->json([
                        'redirect' => $this->createUrl('Banner:Admin:Category@editAction', [$service->getLastId()]),
                    ]);
                }
            }

        } else {
            return $this->json([
                'errors' => $validator->getErrors()
            ]);
        }
    }
}