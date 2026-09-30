<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Database;
use PDO;

class ArticleRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    public function find(int $id): ?array
    {
        $statement = $this->db->prepare('SELECT * FROM articles WHERE id = ?');
        $statement->execute([$id]);

        return $statement->fetch() ?: null;
    }

    public function findCategories(int $articleId): array
    {
        $statement = $this->db->prepare(
            'SELECT c.id, c.name
             FROM categories c
             JOIN article_category ac ON ac.category_id = c.id
             WHERE ac.article_id = ?
             ORDER BY c.name'
        );
        $statement->execute([$articleId]);

        return $statement->fetchAll();
    }

    public function countByCategory(int $categoryId): int
    {
        $statement = $this->db->prepare(
            'SELECT COUNT(*)
             FROM articles a
             JOIN article_category ac ON ac.article_id = a.id
             WHERE ac.category_id = ?'
        );
        $statement->execute([$categoryId]);

        return (int) $statement->fetchColumn();
    }

    public function findByCategory(int $categoryId, string $sort, int $limit, int $offset): array
    {
        // $sort приходит из белого списка контроллера, в SQL попадает один из двух вариантов
        $orderBy = $sort === 'views'
            ? 'a.views DESC, a.published_at DESC'
            : 'a.published_at DESC';

        $statement = $this->db->prepare(
            "SELECT a.*
             FROM articles a
             JOIN article_category ac ON ac.article_id = a.id
             WHERE ac.category_id = ?
             ORDER BY $orderBy
             LIMIT ? OFFSET ?"
        );
        $statement->bindValue(1, $categoryId, PDO::PARAM_INT);
        $statement->bindValue(2, $limit, PDO::PARAM_INT);
        $statement->bindValue(3, $offset, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    // статьи, у которых больше всего общих категорий с данной
    public function findSimilar(int $articleId, int $limit): array
    {
        $statement = $this->db->prepare(
            'SELECT a.*, COUNT(ac.category_id) AS shared_categories
             FROM articles a
             JOIN article_category ac ON ac.article_id = a.id
             WHERE ac.category_id IN (
                 SELECT category_id FROM article_category WHERE article_id = ?
             )
             AND a.id != ?
             GROUP BY a.id
             ORDER BY shared_categories DESC, a.published_at DESC
             LIMIT ?'
        );
        $statement->bindValue(1, $articleId, PDO::PARAM_INT);
        $statement->bindValue(2, $articleId, PDO::PARAM_INT);
        $statement->bindValue(3, $limit, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function incrementViews(int $id): void
    {
        $this->db
            ->prepare('UPDATE articles SET views = views + 1 WHERE id = ?')
            ->execute([$id]);
    }
}
