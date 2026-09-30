# Блог на PHP + Smarty + MySQL

Блог с категориями и статьями без фреймворков: чистый PHP 8.1+, шаблонизатор Smarty, база MySQL.

## Возможности

- **Главная** — категории, в которых есть статьи; в каждой по 3 последних поста и кнопка «Все статьи»
- **Категория** — название, описание, список статей с сортировкой (по дате / по просмотрам) и пагинацией
- **Статья** — полная информация, счётчик просмотров, 3 похожие статьи (подбор по общим категориям)
- **Сидер** — тестовые категории и статьи, svg-картинки генерируются локально
- **Docker** — nginx + php-fpm + MySQL, стили на SCSS

## Структура

```
├── bin/seed.php           # сидер
├── docker/                # Dockerfile php-fpm, конфиг nginx
├── docker-compose.yml
├── public/
│   ├── index.php          # точка входа и роутинг
│   ├── assets/css/        # скомпилированный css
│   └── uploads/           # картинки статей (создаёт сидер)
├── sass/style.scss        # исходник стилей
├── sql/schema.sql         # схема базы
├── src/
│   ├── Controllers/       # контроллеры страниц
│   ├── Repositories/      # sql-запросы
│   ├── Database.php       # PDO-подключение
│   ├── Paginator.php
│   ├── View.php           # обёртка над Smarty
│   └── helpers.php        # модификаторы шаблонов
└── templates/             # шаблоны Smarty
```

## Запуск через Docker

```bash
docker compose up -d --build
docker compose run --rm php composer install
docker compose exec php php bin/seed.php
```

Сайт: http://localhost:8080

Если порт 8080 занят — переопределите порт в `docker-compose.override.yml`:

```yaml
services:
    nginx:
        ports: !override
            - "8088:80"
```

## Запуск без Docker

Нужны PHP 8.1+ (pdo_mysql, mbstring) и MySQL.

```sql
CREATE DATABASE blog CHARACTER SET utf8mb4;
CREATE USER 'blog'@'localhost' IDENTIFIED BY 'secret';
GRANT ALL PRIVILEGES ON blog.* TO 'blog'@'localhost';
```

```bash
composer install
php bin/seed.php
php -S localhost:8000 server.php
```

Сайт: http://localhost:8000

## Стили

Скомпилированный css закоммичен. Пересборка:

```bash
sass sass/style.scss public/assets/css/style.css
```
