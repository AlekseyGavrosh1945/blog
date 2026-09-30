{extends file="layout.tpl"}

{block name="content"}
    {foreach $categories as $category}
        <section class="category-section">
            <div class="section-head">
                <h2 class="section-title"><a href="/category/{$category.id}">{$category.name|escape}</a></h2>
                <p class="section-description">{$category.description|escape}</p>
            </div>

            <div class="post-grid">
                {foreach $category.articles as $article}
                    {include file="parts/post-card.tpl" article=$article}
                {/foreach}
            </div>

            <a class="button" href="/category/{$category.id}">Все статьи</a>
        </section>
    {foreachelse}
        <p class="empty-note">В базе пока нет статей. Запустите сидер: <code>php bin/seed.php</code></p>
    {/foreach}
{/block}
