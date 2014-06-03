<?php

namespace SmartInformationSystems\TagsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Репозиторий связей тегов.
 *
 */
class TagRelationRepository extends EntityRepository
{
    /**
     * Возвращает связь тега с сущностью.
     *
     * @param Tag $tag Тег
     * @param object $entity Сущность
     *
     * @return TagRelation
     */
    public function getOneForTagAndEntity(Tag $tag, $entity)
    {
        return $this->findOneBy(array(
            'tag' => $tag,
            'entityClass' => get_class($entity),
            'entityId' => $entity->getId(),
        ));
    }

    /**
     * Возвращает список связей для сущности.
     *
     * @param object $entity Сущность
     *
     * @return ArrayCollection|TagRelation[]
     */
    public function getForEntity($entity)
    {
        return new ArrayCollection($this->findBy(
            array(
                'entityClass' => get_class($entity),
                'entityId' => $entity->getId(),
            ),
            array(
                'priority' => 'ASC',
            )
        ));
    }

    /**
     * Возвращает идентификаторы связанных с тегом сущностей.
     *
     * @param Tag $tag Тег
     * @param string $entityClass Класс сущности
     *
     * @return array
     */
    public function getEntityIdsForTag(Tag $tag, $entityClass)
    {
        $result = $this->createQueryBuilder('r')
            ->select('r.entityId')
            ->where('r.tag = :tag and r.entityClass = :entity_class')
            ->setParameter('tag', $tag)
            ->setParameter('entity_class', $entityClass)
            ->getQuery()
            ->getScalarResult();

        return array_map('current', $result);
    }
}
