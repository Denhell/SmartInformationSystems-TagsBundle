<?php

namespace SmartSystems\TagsBundle\Form\DataTransformer;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\DataTransformerInterface;

use SmartSystems\TagsBundle\Entity\Tag;
use SmartSystems\TagsBundle\Entity\TagRelation;
use SmartSystems\TagsBundle\Entity\TagRepository;
use SmartSystems\TagsBundle\Entity\TagRelationRepository;

class TagsTransformer implements DataTransformerInterface
{
    /**
     * Подключение к БД.
     *
     * @var EntityManager
     */
    private $em;

    /**
     * Связанный объект.
     *
     * @var object
     */
    private $relativeEntity;

    /**
     * Конструктор.
     *
     * @param EntityManager $em Подключение к БД
     * @param object $relativeEntity Связанный объект
     */
    public function __construct(EntityManager $em, $relativeEntity)
    {
        $this->em = $em;
        $this->relativeEntity = $relativeEntity;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($value)
    {
        /** @var TagRepository $rep */
        $rep = $this->em->getRepository('SmartSystemsTagsBundle:Tag');

        $value = array();

        foreach ($rep->getForEntity($this->relativeEntity) as $r) {
            $value[] = $r->getTitle();
        }

        return implode(',', $value);
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($value)
    {
        if (!$value) {
            return array();
        }

        if (!is_string($value)) {
            throw new \Exception('Must be a string.');
        }

        $tagTitles = array();
        foreach (explode(',', $value) as $tag) {
            $tag = trim($tag);
            if (!in_array($tag, $tagTitles)) {
                $tagTitles[] = $tag;
            }
        }

        /** @var TagRepository $rep */
        $rep = $this->em->getRepository('SmartSystemsTagsBundle:Tag');

        /** @var TagRelationRepository $repRel */
        $repRel = $this->em->getRepository('SmartSystemsTagsBundle:TagRelation');

        $oldRelations = $repRel->getForEntity($this->relativeEntity);

        $priority = 1;

        $tags = array();

        foreach ($tagTitles as $t) {
            if (!($tag = $rep->getByTitle($t))) {
                $tag = new Tag();
                $tag->setTitle($t);
                $this->em->persist($tag);
            }

            if (!($r = $repRel->getOneForTagAndEntity($tag, $this->relativeEntity))) {
                $r = new TagRelation();
                $r->setEntityClass(get_class($this->relativeEntity));
                $r->setEntityId($this->relativeEntity->getId());
                $r->setTag($tag);
            }

            $r->setPriority($priority++);

            $this->em->persist($r);

            $oldRelations->removeElement($r);

            $tags[] = $tag;
        }

        // Удалим ненужные связи
        foreach ($oldRelations as $r) {
            $this->em->remove($r);
        }

        return $tags;
    }
}
