<br><h2>Добавление категории</h2>

<form method="post" action="<?= \ItForFree\SimpleMVC\Router\WebRouter::link('admin/categories/add') ?>">
    <div style="margin-bottom: 15px;">
        <label>Название категории:</label><br>
        <input type="text" name="name" required style="width: 300px; padding: 5px;">
    </div>
    
    <div style="margin-bottom: 15px;">
        <label>Описание:</label><br>
        <textarea name="description" style="width: 300px; height: 100px; padding: 5px;"></textarea>
    </div>
    
    <div>
        <input type="submit" name="saveNewCategory" value="Сохранить" >
        <input type="submit" name="cancel" value="Отмена" >
    </div>
</form>