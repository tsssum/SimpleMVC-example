<?php 
use ItForFree\SimpleMVC\Config;
use ItForFree\SimpleMVC\Router\WebRouter;

$User = Config::getObject('core.user.class');

?>

<ul class="nav">
    
    <?php  if ($User->isAllowed("admin/subcategories/index")): ?>
    <li class="nav-item ">
        <a class="nav-link" href="<?= WebRouter::link("admin/subcategories/index") ?>">Список</a>
    </li>
    <?php endif; ?>
    
    <?php  if ($User->isAllowed("admin/subcategories/add")): ?>
    <li class="nav-item ">
        <a class="nav-link" href="<?= WebRouter::link("admin/subcategories/add") ?>"> + Добавить подкатегорию</a>
    </li>
    <?php endif; ?>  
</ul>