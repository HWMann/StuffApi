<?php

namespace App\Repository;

use App\Entity\Port;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tag>
 */
class PortRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Port::class);
    }

    /**
     * @return array
     */
    public function getList(): array
    {
        $q=$this->createQueryBuilder("a");
        return $q->select("a.id","a.name","a.topic","a.statusTopic","a.status")->orderBy("a.name","ASC")->getQuery()->getResult();
    }
}
