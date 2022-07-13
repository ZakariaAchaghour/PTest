<?php

declare (strict_types=1);

namespace Post\ReadModel;

use PDO;
use Prooph\EventStore\Projection\AbstractReadModel;

class PostsReadModel extends AbstractReadModel
{
    /**
     * @var PDO
     */
    private $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function init(): void
    {
        $statement = $this->connection->prepare(<<<SQL
        CREATE TABLE `posts` (
        `id` char(36) COLLATE utf8_unicode_ci NOT NULL,
        `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
        `content` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
    SQL);
        $statement->execute();
    }

    public function isInitialized(): bool
    {
        $statement = $this->connection->prepare('SELECT * FROM posts LIMIT 1');
        $statement->execute();

        if ('00000' === $statement->errorCode()) {
            return true;
        }

        return false;
    }

    public function reset(): void
    {
        $statement = $this->connection->prepare('TRUNCATE posts');
        $statement->execute();
    }

    public function delete(): void
    {
        $statement = $this->connection->prepare('DROP TABLE posts');
        $statement->execute();
    }

    protected function insert(array $data): void
    {
        $statement = $this->connection->prepare('INSERT INTO posts (id, title, content) VALUES (?, ?, ?)');
        $statement->execute([
            $data['id'],
            $data['title'],
            $data['content'],
        ]);
    }

    protected function renamePost(array $data): void
    {
        $stmt = $this->connection->prepare('UPDATE posts SET title=? WHERE id=?');
        $stmt->execute([$data['title'], $data['postId']]);
    }
}