<?php

namespace App\Repository;

use App\Entity\Screen;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tag>
 */
class ScreenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Screen::class);
    }

    /**
     * @return array
     */
    public function getList(): array
    {
        $q=$this->createQueryBuilder("s");
        return $q->select("s.id","s.name")->orderBy("s.name","ASC")->getQuery()->getResult();
    }
}
