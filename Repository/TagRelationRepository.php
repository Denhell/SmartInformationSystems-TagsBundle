<?php
namespace SmartInformationSystems\TagsBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use SmartInformationSystems\TagsBundle\Entity\Tag;
use SmartInformationSystems\TagsBundle\Entity\TagRelation;

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
        /** @var TagRelation $tagRelation */
        $tagRelation = $this->findOneBy([
            'tag' => $tag,
            'entityClass' => get_class($entity),
            'entityId' => $entity->getId(),
        ]);

        return $tagRelation;
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
            [
                'entityClass' => get_class($entity),
                'entityId' => $entity->getId(),
            ],
            [
                'priority' => 'ASC',
            ]
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
