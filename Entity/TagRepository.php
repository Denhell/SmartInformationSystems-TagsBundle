<?php

namespace SmartSystems\TagsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Репозиторий тегов.
 *
 */
class TagRepository extends EntityRepository
{
    /**
     * Поиск тегов по запросу.
     *
     * @param string $query Запрос
     * @param integer $limit Лимит
     *
     * @return Tag[]
     */
    public function search($query, $limit = 10)
    {
        $query = $this->createQueryBuilder('t')
            ->where('t.title like :title')
            ->setParameter('title', '%' . $query . '%')
            ->orderBy('t.title', 'ASC')
            ->setMaxResults($limit)
            ->getQuery();

        return $query->getResult();
    }

    /**
     * Возвращает тег по названию
     *
     * @param string $title Название
     *
     * @return Tag
     */
    public function getByTitle($title)
    {
        return $this->findOneBy(array(
            'title' => $title,
        ));
    }

    /**
     * Возвращает список тегов для сущности.
     *
     * @param object $entity Сущность
     *
     * @return ArrayCollection|Tag[]
     */
    public function getForEntity($entity)
    {
        return new ArrayCollection(
            $this->createQueryBuilder('t')
                ->leftJoin('t.relations', 'r')
                ->where('r.entityClass = :entity_class and r.entityId = :entity_id')
                ->setParameter('entity_class', get_class($entity))
                ->setParameter('entity_id', $entity->getId())
                ->orderBy('r.priority', 'ASC')
                ->getQuery()
                ->getResult()
        );
    }
}
