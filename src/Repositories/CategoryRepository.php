<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Database;
use PDO;

class CategoryRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    public function find(int $id): ?array
    {
        $statement = $this->db->prepare('SELECT * FROM categories WHERE id = ?');
        $statement->execute([$id]);

        return $statement->fetch() ?: null;
    }

    // категории, в которых есть статьи, по N последних статей на каждую
    public function findWithLatestArticles(int $articlesPerCategory): array
    {
        $statement = $this->db->prepare(
            'SELECT c.id, c.name, c.description,
                    a.id AS article_id, a.title, a.description AS article_description,
                    a.image, a.views, a.published_at
             FROM (
                 SELECT ac.category_id, ac.article_id,
                        ROW_NUMBER() OVER (PARTITION BY ac.category_id ORDER BY a.published_at DESC) AS num
                 FROM article_category ac
                 JOIN articles a ON a.id = ac.article_id
             ) ranked
             JOIN categories c ON c.id = ranked.category_id
             JOIN articles a ON a.id = ranked.article_id
             WHERE ranked.num <= ?
             ORDER BY c.name, a.published_at DESC'
        );
        $statement->bindValue(1, $articlesPerCategory, PDO::PARAM_INT);
        $statement->execute();

        $categories = [];
        foreach ($statement->fetchAll() as $row) {
            $id = (int) $row['id'];

            if (!isset($categories[$id])) {
                $categories[$id] = [
                    'id' => $id,
                    'name' => $row['name'],
                    'description' => $row['description'],
                    'articles' => [],
                ];
            }

            $categories[$id]['articles'][] = [
                'id' => (int) $row['article_id'],
                'title' => $row['title'],
                'description' => $row['article_description'],
                'image' => $row['image'],
                'views' => (int) $row['views'],
                'published_at' => $row['published_at'],
            ];
        }

        return array_values($categories);
    }
}
