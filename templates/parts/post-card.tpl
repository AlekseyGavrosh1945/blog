<a class="post-card" href="/article/{$article.id}">
    <img class="post-card__image" src="{$article.image|escape}" alt="{$article.title|escape}">
    <div class="post-card__body">
        <h3 class="post-card__title">{$article.title|escape}</h3>
        <p class="post-card__text">{$article.description|escape}</p>
        <div class="post-card__meta">
            <span>{$article.published_at|date_ru}</span>
            <span>{$article.views} {$article.views|plural:'просмотр':'просмотра':'просмотров'}</span>
        </div>
    </div>
</a>
