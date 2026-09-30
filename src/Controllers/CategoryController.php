<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Exceptions\NotFound;
use App\Paginator;
use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;
use App\View;

class CategoryController
{
    public function show(int $id): void
    {
        $category = (new CategoryRepository())->find($id);

        if ($category === null) {
            throw new NotFound();
        }

        // белый список вариантов сортировки
        $sort = ($_GET['sort'] ?? '') === 'views' ? 'views' : 'date';
        $page = (int) ($_GET['page'] ?? 1);

        $articles = new ArticleRepository();
        $paginator = new Paginator($articles->countByCategory($id), $page);

        (new View())->render('category.tpl', [
            'category' => $category,
            'articles' => $articles->findByCategory($id, $sort, $paginator->limit(), $paginator->offset()),
            'sort' => $sort,
            'paginator' => $paginator,
        ]);
    }
}
