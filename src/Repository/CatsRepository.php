<?php
namespace App\Repository;

class CatsRepository
{
    private \PDO $db;

    public function __construct()
    {
        $this->db = new \PDO('mysql:host=mysql;dbname=catsdb', 'user', 'password');
    }

    public function getAll(): ?array
    {
        return $this
            ->db
            ->query('SELECT * FROM cats;')
            ->fetchAll(\PDO::FETCH_ASSOC) ?: null;
    }

    public function get(int $id): ?array
    {
        $stm = $this
            ->db
            ->prepare('SELECT * FROM cats WHERE id = ?;');
        $stm->execute([$id]);

        return $stm->fetch(\PDO::FETCH_ASSOC) ?: null;
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

    public function update(
        int $id,
        ?string $description
    ): ?array
    {
        $stm = $this
            ->db
            ->prepare('UPDATE cats SET description = ? WHERE id = ?');
        $stm->execute([$description, $id]);

        return $this->get($id);
    }
}