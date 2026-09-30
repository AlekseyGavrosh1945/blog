<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Exceptions\NotFound;
use App\Repositories\ArticleRepository;
use App\View;

class ArticleController
{
    public function show(int $id): void
    {
        $articles = new ArticleRepository();

        $article = $articles->find($id);

        if ($article === null) {
            throw new NotFound();
        }

        // атомарный инкремент в базе, на единицу больше показанного значения
        $articles->incrementViews($id);
        $article['views']++;

        (new View())->render('article.tpl', [
            'article' => $article,
            'categories' => $articles->findCategories($id),
            'similar' => $articles->findSimilar($id, 3),
        ]);
    }
}
