<?php
namespace application\controllers\admin;

use application\models\Article;
use application\models\Category;
use application\models\Subcategory;
use application\models\UserModel;
use ItForFree\SimpleMVC\Config;

class ArticlesController extends \ItForFree\SimpleMVC\MVC\Controller
{
    public string $layoutPath = 'admin-main.php';
    
    protected array $rules = [
        ['allow' => true, 'roles' => ['admin'], 'actions' => ['index', 'add', 'edit', 'delete']],
    ];
    
    /**
     * Добавление статьи
     */
    public function addAction()
    {
        $Url = Config::get('core.router.class');
        
        if (!empty($_POST)) {
            if (!empty($_POST['saveNewNote'])) { 
                try {
                    $Article = new Article();
                    
                    $Article->storeFormValues($_POST);

                    if (isset($_POST['authorIds']) && is_array($_POST['authorIds'])) {
                        $Article->authors = array_filter($_POST['authorIds'], function($id) {
                            return !empty($id) && is_numeric($id) && $id > 0;
                        });
                    }
                    
                    $Article->insert();
                    
                    if (!empty($Article->authors) && $Article->id) {
                        $this->saveArticleAuthors($Article->id, $Article->authors);
                    }
                    
                    $this->redirect($Url::link("admin/articles/index"));
                    
                } catch (\Exception $e) {
                    error_log("Ошибка при сохранении статьи: " . $e->getMessage());
                    $this->view->addVar('errorMessage', 'Ошибка при сохранении статьи: ' . $e->getMessage());
                    
                    $this->reloadFormData();
                    $this->view->render('admin/articles/add.php');
                }
                
            } elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/articles/index"));
            }
        } else {
            $this->reloadFormData();
            $this->view->render('admin/articles/add.php');
        }
    }
    
    /**
     * Загрузка данных для формы
     */
    private function reloadFormData(): void
    {
        $Category = new Category();
        $categories = $Category->getList()['results'];
        
        $Subcategory = new Subcategory();
        $subcategories = $Subcategory->getList()['results'];
        
        $users = $this->loadActiveUsers();
        
        $this->view->addVar('categories', $categories);
        $this->view->addVar('subcategories', $subcategories);
        $this->view->addVar('users', $users);
        $this->view->addVar('addArticleTitle', 'Добавление новой статьи');
        $this->view->addVar('title', 'Добавить статью');
    }

    private function loadActiveUsers(): array
    {
        try {
            $UserModel = new UserModel();
            
            if (method_exists($UserModel, 'getAllActive')) {
                return $UserModel->getAllActive();
            }
            
            $sql = "SELECT * FROM users WHERE active = 1 ORDER BY login";
            $st = $UserModel->pdo->prepare($sql);
            $st->execute();
            
            $users = [];
            while ($row = $st->fetch()) {
                $user = new UserModel($row);
                $users[] = $user;
            }
            
            return $users;
            
        } catch (\Exception $e) {
            error_log("Ошибка загрузки пользователей: " . $e->getMessage());
            return [];
        }
    }
    /**
 * Сохранение авторов статьи
 */
private function saveArticleAuthors(int $articleId, array $authorIds): void
{
    try {
        $articleModel = new Article();
        
        $sql = "DELETE FROM article_authors WHERE article_id = :articleId";
        $st = $articleModel->pdo->prepare($sql);
        $st->bindValue(":articleId", $articleId, \PDO::PARAM_INT);
        $st->execute();
        
        if (!empty($authorIds)) {
            foreach ($authorIds as $authorId) {
                echo "Добавляем автора ID: $authorId<br>";
                
                $sql = "INSERT INTO article_authors (user_id, article_id) VALUES (:userId, :articleId)";
                $st = $articleModel->pdo->prepare($sql);
                $st->bindValue(":userId", $authorId, \PDO::PARAM_INT);
                $st->bindValue(":articleId", $articleId, \PDO::PARAM_INT);
                $st->execute();
            }
        } else {
        }
        
    } catch (\Exception $e) {
        error_log("Ошибка сохранения авторов: " . $e->getMessage());
    }
}
    /**
     * Редактирование статьи
     */
    public function editAction()
    {
        $id = $_GET['id'] ?? null;
        $Url = Config::get('core.router.class');
        
        if (!$id) {
            $this->redirect($Url::link("admin/articles/index"));
            return;
        }
        
        $Article = new Article();
        
        if (!empty($_POST)) {
            if (!empty($_POST['saveChanges'])) {
                try {
                    $article = $Article->getById($id);
                    
                    if (!$article) {
                        throw new \Exception("Статья не найдена");
                    }
                    
                    $article->storeFormValues($_POST);
                    
                    if (isset($_POST['authorIds']) && is_array($_POST['authorIds'])) {
                        $article->authors = array_filter($_POST['authorIds'], function($id) {
                            return !empty($id) && is_numeric($id) && $id > 0;
                        });
                    }
                    
                    $article->update();
                    
                    if (!empty($article->authors)) {
                        $this->saveArticleAuthors($article->id, $article->authors);
                    }
                    
                    $this->redirect($Url::link("admin/articles/index"));
                    
                } catch (\Exception $e) {
                    error_log("Ошибка при обновлении: " . $e->getMessage());
                    $this->view->addVar('errorMessage', 'Ошибка при обновлении: ' . $e->getMessage());
                    
                    $this->reloadEditFormData($id);
                    $this->view->render('admin/articles/edit.php');
                }
            } elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/articles/index"));
            }
        } else {
            $this->reloadEditFormData($id);
            $this->view->render('admin/articles/edit.php');
        }
    }
    
    /**
     * Загрузка данных для формы редактирования
     */
    private function reloadEditFormData($id): void
    {
        $Article = new Article();
        $Category = new Category();
        $Subcategory = new Subcategory();
        
        $article = $Article->getById($id);
        
        if (!$article) {
            $Url = Config::get('core.router.class');
            $this->redirect($Url::link("admin/articles/index"));
            return;
        }
        
        $authorIds = $this->loadArticleAuthors($id);
        
        $categories = $Category->getList()['results'];
        $subcategories = $Subcategory->getList()['results'];
        $users = $this->loadActiveUsers();
        
        $this->view->addVar('article', $article);
        $this->view->addVar('authorIds', $authorIds);
        $this->view->addVar('categories', $categories);
        $this->view->addVar('subcategories', $subcategories);
        $this->view->addVar('users', $users);
        $this->view->addVar('editArticleTitle', 'Редактирование статьи');
        $this->view->addVar('title', 'Редактировать статью');
    }
    
private function loadArticleAuthors(int $articleId): array
{
    try {
        $articleModel = new Article();                
        $sql = "SELECT user_id FROM article_authors WHERE article_id = :articleId";
        $st = $articleModel->pdo->prepare($sql);
        $st->bindValue(":articleId", $articleId, \PDO::PARAM_INT);
        $st->execute();
        
        $authorIds = [];
        while ($row = $st->fetch()) {
            $authorIds[] = (int)$row['user_id'];
        }
        
        return $authorIds;
        
    } catch (\Exception $e) {
        error_log("Ошибка загрузки авторов: " . $e->getMessage());
        return [];
    }
}
    /**
     * Удаление статьи
     */
    public function deleteAction()
    {
        $id = $_GET['id'] ?? null;
        $Url = Config::get('core.router.class');
        
        if (!$id) {
            $this->redirect($Url::link("admin/articles/index"));
            return;
        }
        
        if (!empty($_POST)) {
            if (!empty($_POST['deleteArticle'])) {
                $Article = new Article();
                $article = $Article->getById($id);
                if ($article) {
                    $this->deleteArticleAuthors($id);
                    $article->delete();
                }
                $this->redirect($Url::link("admin/articles/index"));
            } elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/articles/edit&id=$id"));
            }
        } else {
            $Article = new Article();
            $article = $Article->getById($id);
            
            if (!$article) {
                $this->redirect($Url::link("admin/articles/index"));
                return;
            }
            
            $this->view->addVar('article', $article);
            $this->view->addVar('deleteArticleTitle', 'Удаление статьи');
            $this->view->addVar('title', 'Удалить статью');
            
            $this->view->render('admin/articles/delete.php');
        }
    }
    
    /**
     * Удаление авторов статьи
     */
private function deleteArticleAuthors(int $articleId): void
{
    try {
        $articleModel = new Article();
        
        $sql = "DELETE FROM article_authors WHERE article_id = :articleId";
        $st = $articleModel->pdo->prepare($sql);
        $st->bindValue(":articleId", $articleId, \PDO::PARAM_INT);
        $st->execute();        
    } catch (\Exception $e) {
        error_log("Ошибка удаления авторов: " . $e->getMessage());
    }
}
    
    /**
     * Список статей в админке
     */
    public function indexAction()
    {
        $Article = new Article();
        $Category = new Category();
        $Subcategory = new Subcategory();
        
        $articlesData = $Article->getList(1000000, null, null, false);
        $articles = $articlesData['results'];
        
        $categoriesData = $Category->getList();
        $categories = [];
        foreach ($categoriesData['results'] as $category) {
            $categories[$category->id] = $category;
        }
        
        $subcategoriesData = $Subcategory->getList();
        $subcategories = [];
        foreach ($subcategoriesData['results'] as $subcategory) {
            $subcategories[$subcategory->id] = $subcategory;
        }
        
        $this->view->addVar('articles', $articles);
        $this->view->addVar('categories', $categories);
        $this->view->addVar('subcategories', $subcategories);
        $this->view->addVar('title', 'Управление статьями');
        
        $this->view->render('admin/articles/index.php');
    }
}