<?php
$User = \ItForFree\SimpleMVC\Config::getObject('core.user.class');
?>

<style>
.article-list {
    list-style: none;
    padding-left: 0;
}

.article-item {
    margin-bottom: 20px;
}

h2 a {
    text-decoration: none;
}
h2 {
    margin: 0;
    padding: 0;
}

.pubDate {
    font-size: 0.5em !important;
    margin-right: 30px;
    color: #eb6841;
    text-transform: uppercase;
    vertical-align: top; 
    display: inline-block; 
}

.category, .subcategory{
  font-style: italic;
  font-weight: normal;
  font-size: 90% !important;
  color: #999;
  display: block;
  line-height: 2em;
}

.read-more {
    font-size: 0.9em; 
    float: right; 
    margin-right: 100px;
}

</style>

<?php if (!empty($articles)): ?>
    <ul class="article-list">
        <?php foreach ($articles as $article): ?>
            <li class="article-item">
                <h2>
                    <span class="pubDate">
                        <?= date('j F', strtotime($article->publicationDate)) ?>
                    </span>
                    
                    <a href="<?= \ItForFree\SimpleMVC\Router\WebRouter::link("articles/view&id={$article->id}") ?>" 
                       class="article-title">
                        <?= htmlspecialchars($article->title) ?>
                    </a>
                </h2>
                
                <div class="article-meta">
                    
                    <?php if ($article->categoryId && !empty($categories)): ?>
                        <?php 
                        $categoryName = '';
                        foreach ($categories as $cat) {
                            if ($cat->id == $article->categoryId) {
                                $categoryName = $cat->name;
                                break;
                            }
                        }
                        if ($categoryName): ?>
                        <span class="category">
                            в категории 
                            <a href="<?= \ItForFree\SimpleMVC\Router\WebRouter::link("articles/index&categoryId={$article->categoryId}") ?>">
                                <?= htmlspecialchars($categoryName) ?>
                            </a>
                        </span>
                        <?php endif; ?>
                    <?php endif; ?>   
                    
                    <?php if ($article->subcategoryId && !empty($subcategories)): ?>
                        <?php 
                        $subcategoryName = '';
                        foreach ($subcategories as $scat) {
                            if ($scat->id == $article->subcategoryId) {
                                $subcategoryName = $scat->name;
                                break;
                            }
                        }
                        if ($subcategoryName): ?>
                        <span class="subcategory">
                            в подкатегории 
                            <a href="<?= \ItForFree\SimpleMVC\Router\WebRouter::link("articles/index&subcategoryId={$article->subcategoryId}") ?>">
                                <?= htmlspecialchars($subcategoryName) ?>
                            </a>
                        </span>
                        <?php endif; ?>
                    <?php endif; ?>   
                </div>
                
                <br><div class="article-summary">
                    <?= htmlspecialchars(mb_substr($article->summary, 0, 200)) ?>
                    <?= mb_strlen($article->summary) > 200 ? '...' : '' ?>
                </div>
                
                <a href="<?= \ItForFree\SimpleMVC\Router\WebRouter::link("articles/view&id={$article->id}") ?>" 
                   class="read-more">
                    Читать далее
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Статей пока нет.</p>
<?php endif; ?>

