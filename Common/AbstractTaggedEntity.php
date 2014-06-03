<?php

namespace SmartSystems\TagsBundle\Common;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;

use SmartSystems\TagsBundle\Entity\Tag;
use SmartSystems\TagsBundle\Entity\TagRepository;

/**
 * Абстрактный класс сущностей с поддержкой тегов.
 *
 */
abstract class AbstractTaggedEntity
{
    /**
     * Список тегов.
     *
     * @var ArrayCollection
     */
    private $tags;

    /**
     * Конструктор.
     *
     */
    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    /**
     * Добавляет тег.
     *
     * @param Tag $tag Тег
     *
     * @return AbstractTaggedEntity
     */
    public function addTag(Tag $tag)
    {
        $this->getTags()->add($tag);

        return $this;
    }

    /**
     * Устанавливает теги.
     *
     * @param ArrayCollection $tags Теги
     *
     * @return AbstractTaggedEntity
     */
    public function setTags(ArrayCollection $tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * Удаляет тег.
     *
     * @param Tag $tag Тег
     *
     * @return AbstractTaggedEntity
     */
    public function removeTag(Tag $tag)
    {
        $this->getTags()->removeElement($tag);

        return $this;
    }

    /**
     * Возвращает теги.
     *
     * @param EntityManager $em Подключение к БД
     *
     * @return ArrayCollection|Tag[]
     */
    public function getTags(EntityManager $em = NULL)
    {
        if (!($this->tags instanceof ArrayCollection)) {

            if ($em) {
                /** @var TagRepository $tagRepository */
                $tagRepository = $em->getRepository('SmartSystemsTagsBundle:Tag');
                $tagRepository->getForEntity($this);
                $this->setTags($tagRepository->getForEntity($this));
            } else {
                $this->setTags(new ArrayCollection());
            }
        }

        return $this->tags;
    }
}
