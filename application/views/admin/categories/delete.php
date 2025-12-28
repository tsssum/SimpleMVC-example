<?php 
use ItForFree\SimpleMVC\Config;

$Url = Config::getObject('core.router.class');
?>

<?php include('includes/admin-categories-nav.php'); ?>

<h2><?= $title ?? 'Удаление категории' ?></h2>

<form method="post" action="<?= $Url::link("admin/categories/delete&id=". $_GET['id'])?>" >
    <p>Вы уверены, что хотите удалить категорию <strong>"<?= htmlspecialchars($category->name) ?>"</strong>?</p>    
    
    <input type="hidden" name="id" value="<?= $category->id ?>">
    <input type="submit" name="deleteCategory" value="Удалить">
    <input type="submit" name="cancel" value="Вернуться"><br>
</form>