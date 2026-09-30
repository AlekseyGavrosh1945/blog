{extends file="layout.tpl"}

{block name="title"}{$category.name|escape} — Блог разработчика{/block}

{block name="content"}
    <div class="section-head">
        <h1 class="section-title">{$category.name|escape}</h1>
        <p class="section-description">{$category.description|escape}</p>
    </div>

    <div class="toolbar">
        <span class="toolbar__label">Сортировать:</span>
        <a {if $sort === 'date'}class="active"{/if} href="/category/{$category.id}?sort=date">по дате</a>
        <a {if $sort === 'views'}class="active"{/if} href="/category/{$category.id}?sort=views">по просмотрам</a>
    </div>

    {if count($articles) > 0}
        <div class="post-grid">
            {foreach $articles as $article}
                {include file="parts/post-card.tpl" article=$article}
            {/foreach}
        </div>

        {if $paginator->totalPages() > 1}
            <nav class="pagination">
                {if $paginator->currentPage() > 1}
                    <a class="pagination__arrow" href="/category/{$category.id}?sort={$sort}&amp;page={$paginator->currentPage() - 1}">&larr;</a>
                {/if}
                {foreach $paginator->pages() as $page}
                    {if $page === $paginator->currentPage()}
                        <span class="pagination__page active">{$page}</span>
                    {else}
                        <a class="pagination__page" href="/category/{$category.id}?sort={$sort}&amp;page={$page}">{$page}</a>
                    {/if}
                {/foreach}
                {if $paginator->currentPage() < $paginator->totalPages()}
                    <a class="pagination__arrow" href="/category/{$category.id}?sort={$sort}&amp;page={$paginator->currentPage() + 1}">&rarr;</a>
                {/if}
            </nav>
        {/if}
    {else}
        <p class="empty-note">В этой категории пока нет статей.</p>
    {/if}
{/block}
