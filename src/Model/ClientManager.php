<?php

namespace App\Model;

use App\Service\Entity\Client;

class CLientManager extends AbstractManager
{
    public const TABLE = 'client';

    public function insert(Client $client): void
    {
        $query = "INSERT INTO " . self::TABLE . " (name, email, adress) VALUES (:name, :email, :adress)";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':name', $client->getName(), \PDO::PARAM_STR);
        $statement->bindValue(':email', $client->getEmail(), \PDO::PARAM_STR);
        $statement->bindValue(':adress', $client->getAdress(), \PDO::PARAM_STR);
        $statement->execute();
    }
}
