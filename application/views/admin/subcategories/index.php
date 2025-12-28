<div style="margin-bottom: 20px;">
    <a href="<?= \ItForFree\SimpleMVC\Router\WebRouter::link('admin/subcategories/add') ?>" >
        + Добавить подкатегорию
    </a>
</div>

<h2>Управление подкатегориями</h2>

<?php if (!empty($subcategories)): ?>
    <table class="table">
        <tr>
            <th>Название</th>
            <th>Категория</th>
            <th>Действия</th>
        </tr>
        <?php foreach ($subcategories as $subcategory): ?>
        <tr>
            <td>
                <a href="<?= \ItForFree\SimpleMVC\Router\WebRouter::link("admin/subcategories/edit&id={$subcategory->id}") ?>"><?= htmlspecialchars($subcategory->name) ?></a></td>
            <td>
                <?php 
                $categoryName = 'Нет';
                if (isset($categories[$subcategory->categoryId])) {
                    $categoryName = $categories[$subcategory->categoryId]->name;
                }
                echo htmlspecialchars($categoryName);
                ?>
            </td>
            <td>
                <a href="<?= \ItForFree\SimpleMVC\Router\WebRouter::link("admin/subcategories/delete&id={$subcategory->id}") ?>" 
                   onclick="return confirm('Удалить подкатегорию?')">Удалить</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>    
<?php else: ?>
    <p>Подкатегорий пока нет.</p>
<?php endif; ?>