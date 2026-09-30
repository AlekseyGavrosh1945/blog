<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{block name="title"}Блог разработчика{/block}</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <header class="site-header">
        <div class="container site-header__inner">
            <a class="logo" href="/">Блог разработчика</a>
        </div>
    </header>

    <main class="container">
        {block name="content"}{/block}
    </main>

    <footer class="site-footer">
        <div class="container">
            Блог на PHP, Smarty и MySQL
        </div>
    </footer>
</body>
</html>
