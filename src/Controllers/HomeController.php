<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Repositories\CategoryRepository;
use App\View;

class HomeController
{
    public function index(): void
    {
        $categories = (new CategoryRepository())->findWithLatestArticles(3);

        (new View())->render('index.tpl', [
            'categories' => $categories,
        ]);
    }
}
