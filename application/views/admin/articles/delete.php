<?php 
use ItForFree\SimpleMVC\Config;

$Url = Config::getObject('core.router.class');
?>

<?php include('includes/admin-articles-nav.php'); ?>

<h2><?= $deleteArticleTitle ?></h2>

<form method="post" action="<?= $Url::link("admin/articles/delete&id=". $_GET['id'])?>" >
    Вы уверены, что хотите удалить статю?    
    <input type="hidden" name="id" value="<?= $article->id ?>">
    <input type="submit" name="deleteArticle" value="Удалить">
    <input type="submit" name="cancel" value="Вернуться"><br>
</form>