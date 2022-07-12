<?php
declare(strict_types=1);

namespace Post\ReadModel\Finder;

use Post\App\Queries\FetchPosts;
use Prooph\Common\Messaging\Query;
use React\Promise\Deferred;
use PDO;

class PostsFinder 
{
    /**
     * 
     * @var PDO
     */
    private $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function find(FetchPosts $query,Deferred $deferred): void
    {
        $statement = $this->connection->prepare('SELECT * FROM posts');
        $statement->execute();

        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        $deferred->resolve($results);
    }

    
}
