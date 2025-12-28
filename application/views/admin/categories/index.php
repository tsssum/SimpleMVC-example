<div style="margin-bottom: 20px;">
    <a href="<?= \ItForFree\SimpleMVC\Router\WebRouter::link('admin/categories/add') ?>">
        + Добавить категорию
    </a>
</div>

<h2>Управление категориями</h2>

<?php if (!empty($categories)): ?>
    <table class="table">
        <tr>
            <th>Название</th>
            <th>Описание</th>
            <th>Действия</th>
        </tr>
        <?php foreach ($categories as $category): ?>
        <tr>
            <td>
                <a href="<?= \ItForFree\SimpleMVC\Router\WebRouter::link("admin/categories/edit&id={$category->id}") ?>"><?= htmlspecialchars($category->name) ?>.</a></td>
            <td><?= htmlspecialchars(mb_substr($category->description, 0, 100)) ?></td>
            <td>
                <a href="<?= \ItForFree\SimpleMVC\Router\WebRouter::link("admin/categories/delete&id={$category->id}") ?>" 
                   onclick="return confirm('Удалить категорию?')">Удалить</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>Категорий пока нет.</p>
<?php endif; ?>