<?php

namespace App\Services;

use App\Entity\Tag;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;

class TagService
{

    private TagRepository $tagRepository;
    private EntityManagerInterface $entityManager;

    /**
     * @param TagRepository $tagRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(TagRepository $tagRepository, EntityManagerInterface $entityManager)
    {
        $this->tagRepository = $tagRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @param array $tags
     * @return void
     */
    public function addTags(array $tags) {
        foreach ($tags as $tag) {
            $this->addTag($tag);
        }

        $this->entityManager->flush();
    }

    /**
     * @param string $name
     * @return void
     */
    private function addTag(string $name): void
    {
        if(!$this->tagExists($name)) {
            $tag=new Tag;
            $tag->setName($name);
            $this->entityManager->persist($tag);
        }
    }

    /**
     * @param string $tag
     * @return bool
     */
    private function tagExists(string $tag) {
        return (bool)$this->tagRepository->findOneBy(["name" => $tag]);
    }
}