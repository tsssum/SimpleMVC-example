<?php
namespace application\models;

use ItForFree\SimpleMVC\MVC\Model;

class Category extends Model
{
    public string $tableName = 'categories';
    public string $orderBy = 'name ASC';
    
    public ?int $id = null;
    public ?string $name = null;
    public ?string $description = null;
    
    public function insert(): void
    {
        $sql = "INSERT INTO {$this->tableName} (name, description) 
                VALUES (:name, :description)";
        
        $st = $this->pdo->prepare($sql);
        $st->bindValue(':name', $this->name);
        $st->bindValue(':description', $this->description);
        $st->execute();
        
        $this->id = $this->pdo->lastInsertId();
    }
    
    public function update(): void
    {
        $sql = "UPDATE {$this->tableName} 
                SET name = :name, description = :description
                WHERE id = :id";
        
        $st = $this->pdo->prepare($sql);
        $st->bindValue(':name', $this->name);
        $st->bindValue(':description', $this->description);
        $st->bindValue(':id', $this->id, \PDO::PARAM_INT);
        $st->execute();
    }
}