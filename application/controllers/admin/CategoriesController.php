<?php
namespace application\controllers\admin;

use application\models\Category;
use ItForFree\SimpleMVC\Config;
use ItForFree\SimpleMVC\Router\WebRouter;

class CategoriesController extends \ItForFree\SimpleMVC\MVC\Controller
{
    public string $layoutPath = 'admin-main.php';
    
    protected array $rules = [
        ['allow' => true, 'roles' => ['admin'], 'actions' => ['index', 'add', 'edit', 'delete']],
    ];
    
    /**
     * Список всех категорий
     */
    public function indexAction()
    {
        $Category = new Category();
        $data = $Category->getList();
        
        $this->view->addVar('categories', $data['results']);
        $this->view->addVar('totalRows', $data['totalRows']);
        $this->view->addVar('title', 'Управление категориями');
        
        $this->view->render('admin/categories/index.php');
    }
    
    /**
     * Добавление новой категории
     */
    public function addAction()
    {
        $Url = Config::get('core.router.class');
        
        if (!empty($_POST)) {
            if (!empty($_POST['saveNewCategory'])) {
                $Category = new Category();
                $category = $Category->loadFromArray($_POST);
                $category->insert();
                
                $this->redirect($Url::link("admin/categories/index"));
            } elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/categories/index"));
            }
        } else {
            $this->view->addVar('title', 'Добавление категории');
            $this->view->render('admin/categories/add.php');
        }
    }
    
    /**
     * Редактирование категории
     */
    public function editAction()
    {
        $id = $_GET['id'] ?? null;
        $Url = Config::get('core.router.class');
        
        if (!$id) {
            $this->redirect($Url::link("admin/categories/index"));
            return;
        }
        
        if (!empty($_POST)) {
            if (!empty($_POST['saveChanges'])) {
                $Category = new Category();
                $category = $Category->loadFromArray($_POST);
                $category->update();
                
                $this->redirect($Url::link("admin/categories/index"));
            } elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/categories/index"));
            }
        } else {
            $Category = new Category();
            $category = $Category->getById($id);
            
            if (!$category) {
                $this->redirect($Url::link("admin/categories/index"));
                return;
            }
            
            $this->view->addVar('category', $category);
            $this->view->addVar('title', 'Редактирование категории');
            
            $this->view->render('admin/categories/edit.php');
        }
    }
    
    /**
     * Удаление категории
     */
    public function deleteAction()
    {
        $id = $_GET['id'] ?? null;
        $Url = Config::get('core.router.class');
        
        if (!$id) {
            $this->redirect($Url::link("admin/categories/index"));
            return;
        }
        
        if (!empty($_POST)) {
            if (!empty($_POST['deleteCategory'])) {
                $Category = new Category();
                $category = $Category->getById($id);
                if ($category) {
                    $category->delete();
                }
                $this->redirect($Url::link("admin/categories/index"));
            } elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/categories/edit&id=$id"));
            }
        } else {
            $Category = new Category();
            $category = $Category->getById($id);
            
            if (!$category) {
                $this->redirect($Url::link("admin/categories/index"));
                return;
            }
            
            $this->view->addVar('category', $category);
            $this->view->addVar('title', 'Удаление категории');
            
            $this->view->render('admin/categories/delete.php');
        }
    }
}