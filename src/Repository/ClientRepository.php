<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

final class ClientRepository
{
    private ObjectRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository(Client::class);
    }

    public function findOneById(int $id): ?Client
    {
        /** @var Client|null $client */
        $client = $this->repository->find($id);

        return $client;
    }
}
