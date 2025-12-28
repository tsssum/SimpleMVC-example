<style> 
    
    textarea{
        height: 200%;
        width: 1110px;
        color: #003300;
    }
   
</style>

<div class="container mt-4">
    <h2>Редактирование подкатегории</h2>
    
    <form method="post" action="<?= \ItForFree\SimpleMVC\Router\WebRouter::link('admin/subcategories/edit&id=' . $subcategory->id) ?>">
        <input type="hidden" name="id" value="<?= $subcategory->id ?>">
        
        <div class="form-group">
            <label for="name">Название:</label>
            <input type="text" class="form-control" id="name" name="name" 
                   value="<?= htmlspecialchars($subcategory->name) ?>" required>
        </div>
        
        <div  class="form-group">
            <label>Категория:</label><br>
            <select name="categoryId" required style="width: 300px; padding: 5px;">
                <option value="">-- Выберите категорию --</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category->id ?>"><?= htmlspecialchars($category->name) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <input type="submit" class="btn btn-primary" name="saveChanges" value="Сохранить изменения">
            <input type="submit" class="btn btn-secondary" name="cancel" value="Отмена">
        </div>
    </form>
</div>