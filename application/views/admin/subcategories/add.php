<br><h2>Добавление подкатегории</h2>

<form method="post" action="<?= \ItForFree\SimpleMVC\Router\WebRouter::link('admin/subcategories/add') ?>">
    <div style="margin-bottom: 15px;">
        <label>Название подкатегории:</label><br>
        <input type="text" name="name" required style="width: 300px; padding: 5px;">
    </div>
    
    <div style="margin-bottom: 15px;">
        <label>Категория:</label><br>
        <select name="categoryId" required style="width: 300px; padding: 5px;">
            <option value="">-- Выберите категорию --</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category->id ?>"><?= htmlspecialchars($category->name) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <div>
        <input type="submit" name="saveNewSubcategory" value="Сохранить">
        <input type="submit" name="cancel" value="Отмена">
    </div>
</form>