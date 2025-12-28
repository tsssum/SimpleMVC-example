<?php 
use ItForFree\SimpleMVC\Config;

$Url = Config::getObject('core.router.class');
?>

<?php include('includes/admin-subcategories-nav.php'); ?>

<h2><?= $title ?? 'Удаление подкатегории' ?></h2>

<form method="post" action="<?= $Url::link("admin/subcategories/delete&id=". $_GET['id'])?>" >
    <p>Вы уверены, что хотите удалить подкатегорию <strong>"<?= htmlspecialchars($subcategory->name) ?>"</strong>?</p>    
    
    <input type="hidden" name="id" value="<?= $subcategory->id ?>">
    <input type="submit" name="deleteSubcategory" value="Удалить">
    <input type="submit" name="cancel" value="Вернуться"><br>
</form>