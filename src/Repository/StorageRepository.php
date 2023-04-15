<?php

namespace App\Repository;

use App\Entity\Storage;
use App\Entity\Thing;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @extends ServiceEntityRepository<Storage>
 */
class StorageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Storage::class);
    }

    /**
     * @param Thing $thing
     * @return array
     */
    public function list(Thing $thing):array
    {
        $q=$this->createQueryBuilder("s");

        $q->select(
            "s.id",
            "s.qty",
            "b.name",
            "b.short"
        )
            ->leftJoin("s.box","b")
            ->where("s.thing = :thing")
            ->setParameter("thing",$thing->getId());

        return $q->getQuery()->execute();
    }
}
