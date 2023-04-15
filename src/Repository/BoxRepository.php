<?php

namespace App\Repository;

use App\Entity\Box;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Box|null find($id, $lockMode = null, $lockVersion = null)
 * @method Box|null findOneBy(array $criteria, array $orderBy = null)
 * @method Box[]    findAll()
 * @method Box[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BoxRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Box::class);
    }

    /**
     * @param Box|null $parent
     * @return float|int|mixed|string
     */
    public function root(?Box $parent = null) {
        $q=$this->createQueryBuilder("b");

        $q->select(
            "b.id","b.name","b.short"
        )
            ->where("b.trashed = false")
        ;

        if($parent===null) {
            $q->andWhere("b.parent IS NULL");
        } else {
            $q->andWhere("b.parent = :parent")->setParameter("parent", $parent);
        }

        return $q->getQuery()->execute();
    }


    /**
     * @param string|null $searchTerm
     * @return array|null
     */
    public function search(?string $searchTerm): array|null
    {
        if($searchTerm===null) return null;

        $q=$this->createQueryBuilder("t");
        $data=$q
            ->select("t.id","t.name","t.short")
            ->where("t.name LIKE :searchTerm")
            ->orWhere("t.short LIKE :searchTerm")
            ->setParameter("searchTerm","%".$searchTerm."%","string")
            ->getQuery()
            ->getResult();
        ;

        if(count($data)===0) return null;
        return $data;
    }

}