<?php
namespace application\controllers\admin;

use application\models\Category;
use application\models\Subcategory;
use ItForFree\SimpleMVC\Config;

class SubcategoriesController extends \ItForFree\SimpleMVC\MVC\Controller
{
    public string $layoutPath = 'admin-main.php';
    
    protected array $rules = [
        ['allow' => true, 'roles' => ['admin'], 'actions' => ['index', 'add', 'edit', 'delete']],
    ];
    
    public function indexAction()
    {
        $Subcategory = new Subcategory();
        $Category = new Category();
        
        $subcategoriesData = $Subcategory->getList();
        $categoriesData = $Category->getList();
        
        $categories = [];
        foreach ($categoriesData['results'] as $category) {
            $categories[$category->id] = $category;
        }
        
        $this->view->addVar('subcategories', $subcategoriesData['results']);
        $this->view->addVar('totalRows', $subcategoriesData['totalRows']);
        $this->view->addVar('categories', $categories);
        $this->view->addVar('title', 'Управление подкатегориями');
        
        $this->view->render('admin/subcategories/index.php');
    }
    
    public function addAction()
    {
        $Url = Config::get('core.router.class');
        $Category = new Category();
        $categories = $Category->getList()['results'];
        
        if (!empty($_POST)) {
            if (!empty($_POST['saveNewSubcategory'])) {
                $Subcategory = new Subcategory();
                $subcategory = $Subcategory->loadFromArray($_POST);
                $subcategory->insert();
                
                $this->redirect($Url::link("admin/subcategories/index"));
            } elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/subcategories/index"));
            }
        } else {
            $this->view->addVar('categories', $categories);
            $this->view->addVar('title', 'Добавление подкатегории');
            $this->view->render('admin/subcategories/add.php');
        }
    }
    
    public function editAction()
    {
        $id = $_GET['id'] ?? null;
        $Url = Config::get('core.router.class');
        
        if (!$id) {
            $this->redirect($Url::link("admin/subcategories/index"));
            return;
        }
        
        $Category = new Category();
        $categories = $Category->getList()['results'];
        
        if (!empty($_POST)) {
            if (!empty($_POST['saveChanges'])) {
                $Subcategory = new Subcategory();
                $subcategory = $Subcategory->loadFromArray($_POST);
                $subcategory->update();
                
                $this->redirect($Url::link("admin/subcategories/index"));
            } elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/subcategories/index"));
            }
        } else {
            $Subcategory = new Subcategory();
            $subcategory = $Subcategory->getById($id);
            
            if (!$subcategory) {
                $this->redirect($Url::link("admin/subcategories/index"));
                return;
            }
            
            $this->view->addVar('subcategory', $subcategory);
            $this->view->addVar('categories', $categories);
            $this->view->addVar('title', 'Редактирование подкатегории');
            
            $this->view->render('admin/subcategories/edit.php');
        }
    }
    
    public function deleteAction()
    {
    $id = $_GET['id'] ?? null;
    $Url = Config::get('core.router.class');
    
    if (!$id) {
        $this->redirect($Url::link("admin/subcategories/index"));
        return;
    }
    
    if (!empty($_POST)) {
        if (!empty($_POST['deleteSubcategory'])) {
            $Subcategory = new Subcategory();
            $subcategory = $Subcategory->getById($id);
            if ($subcategory) {
                $subcategory->delete();
            }
            $this->redirect($Url::link("admin/subcategories/index"));
        } elseif (!empty($_POST['cancel'])) {
            $this->redirect($Url::link("admin/subcategories/edit&id=$id"));
        }
    } else {
        $Subcategory = new Subcategory();
        $subcategory = $Subcategory->getById($id);
        
        if (!$subcategory) {
            $this->redirect($Url::link("admin/subcategories/index"));
            return;
        }
        
        $Category = new Category();
        $category = $Category->getById($subcategory->categoryId);
        
        $this->view->addVar('subcategory', $subcategory);
        $this->view->addVar('category', $category);
        $this->view->addVar('title', 'Удаление подкатегории');
        
        $this->view->render('admin/subcategories/delete.php');
    }
}
}