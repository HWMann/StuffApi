<?php

namespace App\Repository;

use App\Entity\Thing;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Thing|null find($id, $lockMode = null, $lockVersion = null)
 * @method Thing|null findOneBy(array $criteria, array $orderBy = null)
 * @method Thing[]    findAll()
 * @method Thing[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ThingRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Thing::class);
    }


    public function list() {
        $q=$this->createQueryBuilder("t");

        $data=$q->select(
            "t.id","t.name"
        )
            ->getQuery()
            ->execute();

        return $data;

    }

    /**
     * @param string|null $searchTerm
     * @return array|null
     */
    public function search(?string $searchTerm): array|null
    {
        if($searchTerm===null) return null;

        $q=$this->createQueryBuilder("t");
        $_data = $q
            ->where("t.name LIKE :searchTerm")
            ->setParameter("searchTerm","%".$searchTerm."%","string")
            ->getQuery()
            ->getResult();
        ;

        if(count($_data)===0) return null;

        $data=[];

        foreach($_data as $d) {
            $data[]=[
                "id" => $d->getId(),
                "name" => $d->getName(),
                "stored" => $this->collectStoredIn($d->getStoredIn())
            ];
        }
        return $data;
    }

    /**
     * @param Collection $storedIn
     * @return array
     */
    private function collectStoredIn(Collection $storedIn):array
    {
        $storedInBoxes=[];

        foreach($storedIn as $stored)
        {
            $storedInBoxes[]=[
                "id" => $stored->getBox()->getId(),
                "name" => $stored->getBox()->getName(),
                "short" => $stored->getBox()->getShort(),
                "quantity" => $stored->getQty()
            ];
        }

        return $storedInBoxes;
    }
}
