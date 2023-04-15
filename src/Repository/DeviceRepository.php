<?php

namespace App\Repository;

use App\Entity\Device;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tag>
 */
class DeviceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Device::class);
    }

    /**
     * @return array
     */
    public function getList(): array
    {
        $q=$this->createQueryBuilder("a");
        return $q->select("a.id","a.name","a.statusTopic","a.lastAliveMessage","a.ip")->orderBy("a.name","ASC")->getQuery()->getResult();
    }

}
