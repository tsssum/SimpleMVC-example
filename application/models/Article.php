<?php
namespace application\models;

use ItForFree\SimpleMVC\MVC\Model;

/**
 * Класс для обработки статей
 */
class Article extends Model
{
    public string $tableName = 'articles';
    public string $orderBy = 'publicationDate DESC';
    
    public ?int $id = null;
    public ?string $publicationDate = null;
    public ?int $categoryId = null;
    public ?int $subcategoryId = null;
    public ?string $title = null;
    public ?string $summary = null;
    public ?string $content = null;
    public ?int $active = 1;
    
    /**
     * Авторы статьи (массив ID пользователей)
     */
    public array $authors = [];
    
    /**
     * Конструктор
     */
    public function __construct(?array $data = null)
    {
        parent::__construct($data);
    }
    
    /**
     * Устанавливает свойства с помощью значений формы редактирования
     */
    public function storeFormValues(array $params): void
    {
        if (is_array($params)) {
            foreach ($params as $key => $value) {
                if (property_exists($this, $key)) {
                    $this->$key = $value;
                }
            }
        }
        
        if (isset($params['publicationDate'])) {
            $this->publicationDate = $params['publicationDate'];
        }
        
        if (isset($params['subcategoryId']) && !empty($params['subcategoryId'])) {
            $this->subcategoryId = (int)$params['subcategoryId'];
        } else {
            $this->subcategoryId = null;
        }
    }
    
    /**
     * Вставка статьи
     */
    public function insert(): void
    {
        $sql = "INSERT INTO $this->tableName 
                (publicationDate, categoryId, subcategoryId, title, summary, content, active) 
                VALUES (:publicationDate, :categoryId, :subcategoryId, :title, :summary, :content, :active)";
        
        $st = $this->pdo->prepare($sql);
        $st->bindValue(":publicationDate", $this->publicationDate, \PDO::PARAM_STR);
        $st->bindValue(":categoryId", $this->categoryId, \PDO::PARAM_INT);
        $st->bindValue(":subcategoryId", $this->subcategoryId, \PDO::PARAM_INT);
        $st->bindValue(":title", $this->title, \PDO::PARAM_STR);
        $st->bindValue(":summary", $this->summary, \PDO::PARAM_STR);
        $st->bindValue(":content", $this->content, \PDO::PARAM_STR);
        $st->bindValue(":active", $this->active, \PDO::PARAM_INT);
        $st->execute();
        
        $this->id = $this->pdo->lastInsertId();
    }
    
    /**
     * Обновление статьи
     */
    public function update(): void
    {
        $sql = "UPDATE $this->tableName SET 
                publicationDate = :publicationDate, 
                categoryId = :categoryId, 
                subcategoryId = :subcategoryId, 
                title = :title, 
                summary = :summary, 
                content = :content, 
                active = :active 
                WHERE id = :id";
        
        $st = $this->pdo->prepare($sql);
        $st->bindValue(":publicationDate", $this->publicationDate, \PDO::PARAM_STR);
        $st->bindValue(":categoryId", $this->categoryId, \PDO::PARAM_INT);
        $st->bindValue(":subcategoryId", $this->subcategoryId, \PDO::PARAM_INT);
        $st->bindValue(":title", $this->title, \PDO::PARAM_STR);
        $st->bindValue(":summary", $this->summary, \PDO::PARAM_STR);
        $st->bindValue(":content", $this->content, \PDO::PARAM_STR);
        $st->bindValue(":active", $this->active, \PDO::PARAM_INT);
        $st->bindValue(":id", $this->id, \PDO::PARAM_INT);
        $st->execute();
    }
    
   /**
 * Получить статью по ID (совместимый метод с родительским классом)
 */
    public function getById(int $id, string $tableName = ''): ?self
    {
        $result = parent::getById($id, $tableName);
    
        return $result ? $result : null;
    }
    /**
     * Получить список статей
     */
    public function getList($numRows = 1000000, $categoryId = null, $subcategoryId = null, $onlyActive = true): array
    {
        $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM $this->tableName";
        $where = [];
        $params = [];
        
        if ($onlyActive) {
            $where[] = "active = 1";
        }
        
        if ($categoryId) {
            $where[] = "categoryId = :categoryId";
            $params[':categoryId'] = $categoryId;
        }
        
        if ($subcategoryId) {
            $where[] = "subcategoryId = :subcategoryId";
            $params[':subcategoryId'] = $subcategoryId;
        }
        
        if (!empty($where)) {
            $sql .= " WHERE " . implode(' AND ', $where);
        }
        
        $sql .= " ORDER BY $this->orderBy LIMIT :numRows";
        
        $st = $this->pdo->prepare($sql);
        $st->bindValue(":numRows", $numRows, \PDO::PARAM_INT);
        
        foreach ($params as $key => $value) {
            $st->bindValue($key, $value, \PDO::PARAM_INT);
        }
        
        $st->execute();
        $list = [];
        
        while ($row = $st->fetch()) {
            $article = new Article($row);
            $list[] = $article;
        }
        
        $sql = "SELECT FOUND_ROWS() AS totalRows";
        $totalRows = $this->pdo->query($sql)->fetch();
        
        return [
            "results" => $list,
            "totalRows" => $totalRows[0]
        ];
    }
    
    /**
     * Удаление статьи
     */
    public function delete(): void
    {
        $sql = "DELETE FROM $this->tableName WHERE id = :id";
        $st = $this->pdo->prepare($sql);
        $st->bindValue(":id", $this->id, \PDO::PARAM_INT);
        $st->execute();
    }
}