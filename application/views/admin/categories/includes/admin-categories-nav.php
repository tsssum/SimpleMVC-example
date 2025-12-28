<?php 
use ItForFree\SimpleMVC\Config;
use ItForFree\SimpleMVC\Router\WebRouter;

$User = Config::getObject('core.user.class');

?>

<ul class="nav">
    
    <?php  if ($User->isAllowed("admin/categories/index")): ?>
    <li class="nav-item ">
        <a class="nav-link" href="<?= WebRouter::link("admin/categories/index") ?>">Список</a>
    </li>
    <?php endif; ?>
    
    <?php  if ($User->isAllowed("admin/categories/add")): ?>
    <li class="nav-item ">
        <a class="nav-link" href="<?= WebRouter::link("admin/categories/add") ?>"> + Добавить категорию</a>
    </li>
    <?php endif; ?>  
</ul>