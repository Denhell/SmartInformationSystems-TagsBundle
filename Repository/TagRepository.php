<?php
namespace SmartInformationSystems\TagsBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use SmartInformationSystems\TagsBundle\Common\AbstractTaggedEntity;
use SmartInformationSystems\TagsBundle\Entity\Tag;

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
        $qb = $this->createQueryBuilder('t');
        $qb
            ->where('t.title like :title')
            ->setParameter('title', '%' . $query . '%')
            ->orderBy('t.title', 'ASC')
            ->setMaxResults($limit)
        ;

        return $qb->getQuery()->getResult();
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
        /** @var Tag $tag */
        $tag = $this->findOneBy([
            'title' => $title,
        ]);

        return $tag;
    }

    /**
     * Возвращает список тегов для сущности.
     *
     * @param AbstractTaggedEntity $entity Сущность
     *
     * @return Tag[]
     */
    public function getForEntity($entity)
    {
        $qb = $this->createQueryBuilder('t');
        $qb
            ->leftJoin('t.relations', 'r')
            ->andWhere($qb->expr()->eq('r.entityClass', ':entity_class'))
            ->andWhere($qb->expr()->eq('r.entityId', ':entity_id'))
            ->setParameters([
                'entity_class' => \get_class($entity),
                'entity_id' => $entity->getId(),
            ])
            ->orderBy('r.priority', 'ASC')
        ;

        return $qb->getQuery()->getResult();
    }

    /**
     * Возвращает список тегов для всех сущностей класса
     *
     * @param string $class
     *
     * @return Tag[]
     */
    public function getForClass($class)
    {
        $qb = $this->createQueryBuilder('t');
        $qb
            ->leftJoin('t.relations', 'r')
            ->andWhere($qb->expr()->eq('r.entityClass', ':entity_class'))
            ->setParameter('entity_class', $class)
            ->orderBy('t.title', 'ASC')
        ;

        return $qb->getQuery()->getResult();
    }
}
