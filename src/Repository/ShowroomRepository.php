<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\Showroom;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

final class ShowroomRepository
{
    private ObjectRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository(Showroom::class);
    }

    public function findOneExistById(int $id): ?Showroom
    {
        /** @var Showroom|null $showroom */
        $showroom = $this->repository
            ->createQueryBuilder('s')
            ->where('s.id = :id')
            ->setParameter('id', $id)
            ->andWhere('s.count > 0')
            ->getQuery()
            ->getOneOrNullResult();

        return $showroom;
    }

    public function findAllByBrand(string $brand)
    {
        return $this->repository
            ->createQueryBuilder('s')
            ->leftJoin('s.car', 'c')
            ->where('c.brand = :brand')
            ->setParameter('brand', $brand)
            ->andWhere('s.count > 0')
            ->andWhere('c.new = true')
            ->getQuery()
            ->getResult();
    }
}
