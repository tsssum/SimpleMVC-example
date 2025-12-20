<?php
use ItForFree\SimpleMVC\Config;
use ItForFree\SimpleMVC\Router\WebRouter;

$User = Config::getObject('core.user.class');
?>

<div class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= WebRouter::link("homepage/index") ?>">Главная</a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?= WebRouter::link("notes/index") ?>">Заметки</a>
            </li>
            <li class="breadcrumb-item active"><?= htmlspecialchars($note->title) ?></li>
        </ol>
    </nav>

    <h1 class="mb-4"><?= htmlspecialchars($note->title) ?></h1>
    
    <div class="card mb-4">
        <div class="card-body">
            <p class="card-text"><?= nl2br(htmlspecialchars($note->content)) ?></p>
            <p class="text-muted">
                <small>Дата публикации: <?= $note->publicationDate ?></small>
            </p>
        </div>
    </div>
    
    <div class="alert alert-info">
        <h6>Статистика просмотров:</h6>
        <p>Вы просмотрели: <strong><?= $viewCount ?></strong> заметок из 5 доступных</p>
        
    </div>
    
    <div class="mt-3">
        <a href="<?= WebRouter::link("notes/index") ?>" class="btn btn-secondary">
            ← Назад к списку заметок
        </a>
        <a href="<?= WebRouter::link("homepage/index") ?>" class="btn btn-primary">
            На главную
        </a>
    </div>
</div>