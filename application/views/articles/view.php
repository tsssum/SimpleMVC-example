<div class="row">
    <div class="col">
        <h1><?= htmlspecialchars($article->title) ?></h1>
        
        <div class="article-summary">
            <p class="lead"><?= htmlspecialchars($article->summary) ?></p>
        </div>        
        <div class="article-content">
            <?= $article->content ?>
        </div>
        

        <div class="article-meta">

        <span class="pubDate"> Published on <?= date('j F Y', strtotime($article->publicationDate)) ?> </span>    

         <?php if ($category): ?>
                <span class="category-1"> <a href="<?= \ItForFree\SimpleMVC\Router\WebRouter::link("articles/index&categoryId={$category->id}") ?>">
                        <?= htmlspecialchars($category->name) ?>
                    </a>, 
                </span>
            <?php endif; ?>
            
            <?php if ($subcategory): ?>
                <span class="subcategory-1"><a href="<?= \ItForFree\SimpleMVC\Router\WebRouter::link("articles/index&subcategoryId={$subcategory->id}") ?>">
                        <?= htmlspecialchars($subcategory->name) ?>
                    </a>
                </span>
            <?php endif; ?>        
        </div>

        <?php if (!empty($article->authors)): ?>
            <br><div class="authors">
                <strong>Авторы:</strong>
                <?php 
                $authorNames = [];
                foreach ($article->authors as $author) {
                    if (is_array($author)) {
                        $name = $author['username'] ?? $author['login'] ?? $author['name'] ?? 'Неизвестный автор';
                    } elseif (is_object($author)) {
                        $name = $author->username ?? $author->login ?? $author->name ?? 'Неизвестный автор';
                    } else {
                        $name = 'Неизвестный автор';
                    }
                    if ($name !== null) {
                        $authorNames[] = htmlspecialchars($name);
                    }
                }
                if (!empty($authorNames)) {
                    echo implode(', ', $authorNames);
                } else {
                }
                ?>
            </div>
        <?php endif; ?>

        <br><div class="mt-4">
            <a href="<?= \ItForFree\SimpleMVC\Router\WebRouter::link("articles/index") ?>" 
               class="btn btn-secondary">
            Вернуться на главную
            </a>           
            
        </div>
    </div>
</div>

<style>
.authors{
    font-style: normal !important;
    font-size: 100% !important;
    color: #000000ff !important;
}
.article-summary, .article-content {
    font-style: italic;
    font-weight: normal;
    font-size: 100% !important;
    color: #000000ff;
    display: block;
    line-height: 2em;
}

.article-summary,
.article-content,
.article-meta,
.authors {
    margin: 0;
    padding: 0;
}

.article-summary p {
    margin: 0;
}

.article-meta {
    font-size: 14px !important;
    text-transform: capitalize;
    display: inline-block; 
    margin-top: 10px; 
}

.category-1, .subcategory-1 {
  font-style: italic;
  color: #999;
}

.category-1 a, .subcategory-1 a{
  color: #999;
  text-decoration: underline;
}

.pubDate {
    font-size: 14px !important;
    color: #eb6841;
}
</style>