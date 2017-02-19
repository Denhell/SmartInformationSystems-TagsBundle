<?php
namespace SmartInformationSystems\TagsBundle\Service;

use Doctrine\ORM\EntityManager;
use SmartInformationSystems\TagsBundle\Common\AbstractTaggedEntity;
use SmartInformationSystems\TagsBundle\Entity\Tag;
use SmartInformationSystems\TagsBundle\Entity\TagRelation;

class TagRelationService
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param AbstractTaggedEntity $entity
     *
     * @return void
     */
    public function load(AbstractTaggedEntity $entity)
    {
        $entity->setTags(
            $this->entityManager->getRepository(Tag::class)->getForEntity($entity)
        );
    }

    /**
     * @param AbstractTaggedEntity $entity
     *
     * @return void
     */
    public function update(AbstractTaggedEntity $entity)
    {
        // Удалим старые связи
        $qb = $this->entityManager->createQueryBuilder()->delete(TagRelation::class, 'tr');
        $qb
            ->where($qb->expr()->eq('tr.entityClass', ':class'))
            ->andWhere($qb->expr()->eq('tr.entityId', ':id'))
            ->setParameters([
                'class' => get_class($entity),
                'id' => $entity->getId(),
            ])
        ;
        $qb->getQuery()->execute();

        foreach ($entity->getTags() as $tag) {
            $relation = new TagRelation();
            $relation->setTag($tag);
            $relation->setEntityClass(get_class($entity));
            $relation->setEntityId($entity->getId());
            $relation->setPriority($tag->getPriority());
            $this->entityManager->persist($relation);
        }
        $this->entityManager->flush();
    }
}
