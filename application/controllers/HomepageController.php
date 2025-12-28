<?php

namespace application\controllers;
use ItForFree\SimpleMVC\Router\WebRouter;

/**
 * Контроллер для домашней страницы
 */
class HomepageController extends \ItForFree\SimpleMVC\MVC\Controller
{
    /**
     * @var string Название страницы
     */
    public $homepageTitle = "Домашняя страница";
    
    /**
     * @var string Пусть к файлу макета 
     */
    public string $layoutPath = 'main.php';
      
    public function indexAction()
    {
        $this->redirect(WebRouter::link("articles/index"));
    }
}

