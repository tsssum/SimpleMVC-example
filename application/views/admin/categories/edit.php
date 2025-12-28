<style> 
    
    textarea{
        height: 200%;
        width: 1110px;
        color: #003300;
    }
   
</style>
<div class="container mt-4">
    <h2>Редактирование категории</h2>
    
    <form method="post" action="<?= \ItForFree\SimpleMVC\Router\WebRouter::link('admin/categories/edit&id=' . $category->id) ?>">
        <input type="hidden" name="id" value="<?= $category->id ?>">
        
        <div class="form-group">
            <label for="name">Название категории:</label>
            <input type="text" class="form-control" id="name" name="name" 
                   value="<?= htmlspecialchars($category->name ?? '') ?>" required>
        </div>
        
        <div class="form-group">
            <label for="description">Описание:</label>
            <textarea class="form-control" id="description" name="description" rows="3"><?= htmlspecialchars($category->description ?? '') ?></textarea>
        </div>
        
        <div class="form-group">
            <input type="submit" class="btn btn-primary" name="saveChanges" value="Сохранить изменения">
            <input type="submit" class="btn btn-secondary" name="cancel" value="Отмена">
        </div>
    </form>
</div>