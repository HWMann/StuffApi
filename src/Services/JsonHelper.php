<?php

namespace App\Services;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class JsonHelper
{
    private ManagerRegistry $managerRegistry;
    private EntityManagerInterface $entityManager;

    public function __construct(ManagerRegistry $managerRegistry, EntityManagerInterface $entityManager)
    {
        $this->managerRegistry = $managerRegistry;
        $this->entityManager = $entityManager;
    }

    public function list(string $className,array $fields, $criteria):array {

        $result=[];

        $metaData=$this->entityManager->getClassMetadata($className);

        $repo=new $metaData->customRepositoryClassName($this->managerRegistry);
        $data=$repo->matching($criteria);

        foreach($data as $d)
        {
            $row=[];
            foreach($fields as $field) {
                $getter="get".$field;
                if(isset($metaData->fieldMappings[$field]))
                {
                    $row[$field]=$d->$getter();
                } else {
                    if($d->$getter()!==null) {
                        $row[$field]=$d->$getter()->getId();
                    } else {
                        $row[$field]=null;
                    }

                }
            }
            $result[]=$row;
        }
        return $result;
    }
}