<style> 
    textarea{
        height: 200%;
        width: 1110px;
        color: #003300;
    }
</style>

<?php 
use ItForFree\SimpleMVC\Config;

$Url = Config::getObject('core.router.class');
$User = Config::getObject('core.user.class');
?>

<?php include('includes/admin-articles-nav.php'); ?>

<h2><?= $editArticleTitle ?></h2>
<form id="editArticle" method="post" action="<?= \ItForFree\SimpleMVC\Router\WebRouter::link("admin/articles/edit&id={$article->id}") ?>"> 
    <input type="hidden" name="id" value="<?= $article->id ?>">
    
    <div class="form-group">
        <label for="title">Название</label>
        <input type="text" class="form-control" name="title" id="title" 
               placeholder="Имя статьи" required 
               value="<?= htmlspecialchars($article->title ?? '') ?>">
    </div>
    
    <div class="form-group">
        <label for="summary">Краткое описание</label><br>
        <textarea name="summary" id="summary" class="form-control" rows="3" required><?= 
            htmlspecialchars($article->summary ?? '') ?></textarea>
    </div>
    
    <div class="form-group">
        <label for="content">Содержание</label><br>
        <textarea name="content" id="content" class="form-control" rows="10" required><?= 
            $article->content ?? '' ?></textarea>
    </div>

    <?php if (!empty($categories)): ?>
    <div class="form-group">
        <label for="categoryId"><strong>Категория</strong></label><br>
        <select name="categoryId" id="categoryId" class="form-control">
            <option value="0">-- Без категории --</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category->id ?>" 
                    <?= ($article->categoryId == $category->id) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($category->name) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <?php endif; ?>
    
    <?php if (!empty($subcategories)): ?>
    <div class="form-group">
        <label for="subcategoryId"><strong>Подкатегория</strong></label><br>
        <select name="subcategoryId" id="subcategoryId" class="form-control">
            <option value="">-- Без подкатегории --</option>
            <?php foreach ($subcategories as $subcategory): ?>
                <option value="<?= $subcategory->id ?>"
                    <?= ($article->subcategoryId == $subcategory->id) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($subcategory->name) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <?php endif; ?>

    <div class="form-group">
        <label for="publicationDate">Дата публикации</label><br>
        <input type="date" name="publicationDate" id="publicationDate" class="form-control" required 
               value="<?= !empty($article->publicationDate) ? date('Y-m-d', strtotime($article->publicationDate)) : date('Y-m-d') ?>">
    </div>

    <?php if (!empty($users)): ?>
    <div class="form-group">
        <label for="authorIds"><strong>Авторы</strong></label><br>
        <select name="authorIds[]" id="authorIds" multiple class="form-control" size="5">
            <?php foreach ($users as $user): ?>
                <option value="<?= $user->id ?>"
                    <?= (in_array($user->id, $authorIds ?? [])) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($user->login) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <small class="text-muted">Удерживайте Ctrl (Cmd на Mac) для выбора нескольких авторов</small>
    </div>
    <?php endif; ?>
    
    <div class="form-group form-check">
        <input type="checkbox" name="active" id="active" value="1" class="form-check-input" 
               <?= (!empty($article->active) && $article->active == 1) ? 'checked' : '' ?>>
        <label for="active" class="form-check-label"><strong>Статья активна</strong></label>
    </div>

    <input type="submit" class="btn btn-primary" name="saveChanges" value="Сохранить">
    <input type="submit" class="btn btn-secondary" name="cancel" value="Назад">
</form>