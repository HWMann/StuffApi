<?php

namespace App\Repository;

use App\Entity\Widget;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tag>
 */
class WidgetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Widget::class);
    }

    /**
     * @return array
     */
    public function getList(): array
    {
        $q=$this->createQueryBuilder("a");
        return $q->select("a.id","a.name")->orderBy("a.name","ASC")->getQuery()->getResult();
    }
}
