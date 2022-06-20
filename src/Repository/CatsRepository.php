<?php
namespace App\Repository;

class CatsRepository
{
    private \PDO $db;

    public function __construct()
    {
        $this->db = new \PDO('mysql:host=mysql;dbname=catsdb', 'user', 'password');
    }

    public function getAll(): array
    {
        return $this
            ->db
            ->query('SELECT * FROM cats;')
            ->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function create(
        string $name,
        ?string $type,
        ?string $description,
        ?string $specials,
        ?int $vaccination,
    ): int
    {
        $stm = $this
            ->db
            ->prepare('INSERT INTO cats(name, type, description, specials, vaccination) VALUES(?,?,?,?,?)');
        $stm->execute([$name, $type, $description, $specials, $vaccination]);

        return $this->db->lastInsertId();
    }
}