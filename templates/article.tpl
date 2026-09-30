{extends file="layout.tpl"}

{block name="title"}{$article.title|escape} — Блог разработчика{/block}

{block name="content"}
    <article class="article">
        <h1 class="article__title">{$article.title|escape}</h1>

        <div class="article__meta">
            <span>{$article.published_at|date_ru}</span>
            <span>{$article.views} {$article.views|plural:'просмотр':'просмотра':'просмотров'}</span>
            {foreach $categories as $category}
                <a class="tag" href="/category/{$category.id}">{$category.name|escape}</a>
            {/foreach}
        </div>

        <img class="article__image" src="{$article.image|escape}" alt="{$article.title|escape}">

        <div class="article__content">
            {$article.content|nl2br}
        </div>
    </article>

    {if count($similar) > 0}
        <section class="category-section">
            <h2 class="section-title">Похожие статьи</h2>
            <div class="post-grid">
                {foreach $similar as $article}
                    {include file="parts/post-card.tpl" article=$article}
                {/foreach}
            </div>
        </section>
    {/if}
{/block}
