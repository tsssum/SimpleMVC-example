<?php
namespace application\models;

use ItForFree\SimpleMVC\MVC\Model;

class Subcategory extends Model
{
    public string $tableName = 'subcategories';
    public string $orderBy = 'name ASC';
    
    public ?int $id = null;
    public ?string $name = null;
    public ?int $categoryId = null; 
    
    public function insert(): void
    {
        $sql = "INSERT INTO {$this->tableName} (name, categoryId) 
                VALUES (:name, :categoryId)"; 
        
        $st = $this->pdo->prepare($sql);
        $st->bindValue(':name', $this->name);
        $st->bindValue(':categoryId', $this->categoryId, \PDO::PARAM_INT); 
        $st->execute();
        
        $this->id = $this->pdo->lastInsertId();
    }
    
    public function update(): void
    {
        $sql = "UPDATE {$this->tableName} 
                SET name = :name, categoryId = :categoryId 
                WHERE id = :id";
        
        $st = $this->pdo->prepare($sql);
        $st->bindValue(':name', $this->name);
        $st->bindValue(':categoryId', $this->categoryId, \PDO::PARAM_INT); 
        $st->bindValue(':id', $this->id, \PDO::PARAM_INT);
        $st->execute();
    }
    
    public function getListByCategory($categoryId, $numRows = 1000000): array
    {
        $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM $this->tableName 
                WHERE categoryId = :categoryId 
                ORDER BY $this->orderBy 
                LIMIT :numRows";
        
        $st = $this->pdo->prepare($sql);
        $st->bindValue(":categoryId", $categoryId, \PDO::PARAM_INT);
        $st->bindValue(":numRows", $numRows, \PDO::PARAM_INT);
        $st->execute();
        
        $list = [];
        while ($row = $st->fetch()) {
            $list[] = new Subcategory($row);
        }
        
        $sql = "SELECT FOUND_ROWS() AS totalRows";
        $totalRows = $this->pdo->query($sql)->fetch();
        
        return [
            "results" => $list,
            "totalRows" => $totalRows[0]
        ];
    }
    
    public function getCategory(): ?Category
    {
        if ($this->categoryId) { 
            $categoryModel = new Category();
            return $categoryModel->getById($this->categoryId); 
        }
        return null;
    }
}