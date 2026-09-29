<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

use App\Controllers\ArticleController;
use App\Controllers\CategoryController;
use App\Controllers\HomeController;
use App\Exceptions\NotFound;
use App\View;

$view = new View();

$path = trim((string) parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

try {
    if ($path === '') {
        (new HomeController())->index();
    } elseif (preg_match('#^category/(\d+)$#', $path, $m)) {
        (new CategoryController())->show((int) $m[1]);
    } elseif (preg_match('#^article/(\d+)$#', $path, $m)) {
        (new ArticleController())->show((int) $m[1]);
    } else {
        throw new NotFound();
    }
} catch (NotFound) {
    http_response_code(404);
    $view->render('404.tpl');
} catch (Throwable) {
    http_response_code(500);
    echo 'Внутренняя ошибка сервера. Попробуйте обновить страницу позже';
}
