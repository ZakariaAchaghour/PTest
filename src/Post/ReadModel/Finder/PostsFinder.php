<?php
declare(strict_types=1);

namespace Post\ReadModel\Finder;

use PDO;

class PostsFinder 
{
     /**
     * @var PDO
     */
    private $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    
    
    public function findAll(): array
    {
        
        return $this->connection->query('SELECT * FROM posts')->fetchAll();
    }

    
}
