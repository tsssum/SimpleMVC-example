<?php
// application/views/admin/articles/index.php
?>

<?php include('includes/admin-articles-nav.php'); ?>
<div>
    <h1>Cтатьи</h1>   
    
    <?php if (!empty($articles)): ?>
        <table class="table">
                <tr>
                        <th>Заголовок</th>
                        <th>Дата</th>
                        <th>Категория</th>
                        <th>Подкатегория</th>
                        <th>Статус</th>
                        <th>Действия</th>
                </tr>
                 <?php foreach ($articles as $article): ?>
                        <tr>
                            <td>
                                <a href="<?= \ItForFree\SimpleMVC\Router\WebRouter::link("admin/articles/edit&id={$article->id}") ?>"><?= htmlspecialchars($article->title) ?></a>
                            </td>
                            <td><?= date('d.m.Y', strtotime($article->publicationDate)) ?></td>                            
                            <td>
                                <?php 
                                $categoryName = 'Без категории';
                                if (!empty($categories) && $article->categoryId) {
                                    foreach ($categories as $cat) {
                                        if ($cat->id == $article->categoryId) {
                                            $categoryName = $cat->name;
                                            break;
                                        }
                                    }
                                }
                                ?>
                                <span><?= htmlspecialchars($categoryName) ?></span>
                            </td>
                            <td>
                                <?php 
                                $subcategoryName = 'Без подкатегории';
                                if (!empty($subcategories) && $article->subcategoryId) {
                                    foreach ($subcategories as $scat) {
                                        if ($scat->id == $article->subcategoryId) {
                                            $subcategoryName = $scat->name;
                                            break;
                                        }
                                    }
                                }
                                ?>
                                <span><?= htmlspecialchars($subcategoryName) ?></span>
                            </td>
                            <td>
                                <?php if ($article->active): ?>
                                    <span >Активна</span>
                                <?php else: ?>
                                    <span>Скрыта</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div>
                                    <a href="<?= \ItForFree\SimpleMVC\Router\WebRouter::link("admin/articles/delete&id={$article->id}") ?>">
                                    Удалить
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
            </table>
        
    <?php else: ?>
        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i> Статей пока нет. 
            <a href="<?= \ItForFree\SimpleMVC\Router\WebRouter::link('admin/articles/add') ?>" class="alert-link">
                Добавить первую статью
            </a>
        </div>
    <?php endif; ?>
</div>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
