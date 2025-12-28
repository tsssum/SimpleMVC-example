<?php
namespace application\controllers;

use application\models\Article;
use application\models\Category;
use application\models\Subcategory;

class ArticlesController extends \ItForFree\SimpleMVC\MVC\Controller
{
    /**
     * Просмотр статьи
     */
    public function viewAction()
    {
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            $this->redirect(\ItForFree\SimpleMVC\Router\WebRouter::link("homepage/index"));
            return;
        }
        
        $Article = new Article();
        $Category = new Category();
        $Subcategory = new Subcategory();
        
        $article = $Article->getById((int)$id);
        
        if (!$article) {
            $this->redirect(\ItForFree\SimpleMVC\Router\WebRouter::link("homepage/index"));
            return;
        }
        
        $article->authors = $this->loadArticleAuthors($article->id);
        
        $category = null;
        if ($article->categoryId) {
            $category = $Category->getById($article->categoryId);
        }
        
        // Получаем подкатегорию
        $subcategory = null;
        if ($article->subcategoryId) {
            $subcategory = $Subcategory->getById($article->subcategoryId);
        }
        
        $this->view->addVar('article', $article);
        $this->view->addVar('category', $category);
        $this->view->addVar('subcategory', $subcategory);
        $this->view->addVar('title', $article->title);
        
        $this->view->render('articles/view.php');
    }
    
    private function loadArticleAuthors(int $articleId): array
    {
        try {
            $articleModel = new Article();
            
            $sql = "SELECT u.id, u.login 
                    FROM users u 
                    INNER JOIN article_authors aa ON u.id = aa.user_id 
                    WHERE aa.article_id = :articleId";
            
            $st = $articleModel->pdo->prepare($sql);
            $st->bindValue(":articleId", $articleId, \PDO::PARAM_INT);
            $st->execute();
            
            $authors = [];
            while ($row = $st->fetch()) {
                $username = $row['username'] ?? $row['login'] ?? 'Неизвестный автор';
                
                $authors[] = [
                    'id' => $row['id'],
                    'username' => $username
                ];
            }
            
            return $authors;
            
        } catch (\Exception $e) {
            error_log("Ошибка загрузки авторов статьи $articleId: " . $e->getMessage());
            return [];
        }
    }
    
    public function indexAction()
    {
        $Article = new Article();
        $Category = new Category();
        $Subcategory = new Subcategory();
        
        $categoryId = $_GET['categoryId'] ?? null;
        $subcategoryId = $_GET['subcategoryId'] ?? null;
        
        $articlesData = $Article->getList(20, $categoryId, $subcategoryId);
        $articles = $articlesData['results'];
        $totalRows = $articlesData['totalRows'];
        
        $categoriesData = $Category->getList();
        $categories = $categoriesData['results'];
        
        $subcategoriesData = $Subcategory->getList();
        $subcategories = $subcategoriesData['results'];
        
        $this->view->addVar('articles', $articles);
        $this->view->addVar('totalRows', $totalRows);
        $this->view->addVar('categories', $categories);
        $this->view->addVar('subcategories', $subcategories);
        $this->view->addVar('title', 'Статьи');
        
        $this->view->render('articles/index.php');
    }
}