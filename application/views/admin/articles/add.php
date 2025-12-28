<?php include('includes/admin-articles-nav.php'); ?>
<h2><?= $addArticleTitle ?? 'Добавление статьи' ?></h2>

<?php if (!empty($errorMessage)): ?>
    <div class="alert alert-danger">
        <?= htmlspecialchars($errorMessage) ?>
    </div>
<?php endif; ?>

<form id="addArticle" method="post" action="<?= \ItForFree\SimpleMVC\Router\WebRouter::link("admin/articles/add") ?>"> 
    <div class="form-group">
        <label for="title">Название</label>
        <input type="text" class="form-control" name="title" id="title" placeholder="Имя статьи" required>
    </div>
    
    <div class="form-group">
        <label for="summary">Краткое описание</label><br>
        <textarea name="summary" id="summary" class="form-control" rows="3" required></textarea>
    </div>
    
    <div class="form-group">
        <label for="content">Содержание</label><br>
        <textarea name="content" id="content" class="form-control" rows="10" required></textarea>
    </div>

    <?php if (!empty($categories)): ?>
    <div class="form-group">
        <label for="categoryId"><strong>Категория</strong></label><br>
        <select name="categoryId" id="categoryId" class="form-control">
            <option value="0">-- Без категории --</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category->id ?>"><?= htmlspecialchars($category->name) ?></option>
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
                <option value="<?= $subcategory->id ?>"><?= htmlspecialchars($subcategory->name) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <?php endif; ?>

    <div class="form-group">
        <label for="publicationDate">Дата публикации</label><br>
        <input type="date" name="publicationDate" id="publicationDate" class="form-control" required 
               value="<?= date('Y-m-d') ?>">
    </div>

    <?php if (!empty($users)): ?>
    <div class="form-group">
        <label for="authorIds"><strong>Авторы</strong></label><br>
        <select name="authorIds[]" id="authorIds" multiple class="form-control" size="5">
            <?php foreach ($users as $user): ?>
                <option value="<?= $user->id ?>">
                    <?= htmlspecialchars($user->login) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <?php endif; ?>
    
    <div class="form-group form-check">
        <input type="checkbox" name="active" id="active" value="1" class="form-check-input" checked>
        <label for="active" class="form-check-label"><strong>Статья активна</strong></label>
    </div>

    <input type="submit" class="btn btn-primary" name="saveNewNote" value="Сохранить">
    <input type="submit" class="btn btn-secondary" name="cancel" value="Назад">
</form>

<style> 
    textarea.form-control {
        height: auto;
        min-height: 150px;
        width: 100%;
        color: #003300;
    }
</style>
