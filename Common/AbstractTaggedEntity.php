<?php
namespace SmartInformationSystems\TagsBundle\Common;

use Doctrine\Common\Collections\ArrayCollection;
use SmartInformationSystems\TagsBundle\Entity\Tag;

/**
 * Абстрактный класс сущностей с поддержкой тегов
 */
abstract class AbstractTaggedEntity
{
    /**
     * Список тегов
     *
     * @var ArrayCollection
     */
    private $tags;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    /**
     * @return integer
     */
    abstract public function getId();

    /**
     * @param Tag $tag Тег
     *
     * @return AbstractTaggedEntity
     */
    public function addTag(Tag $tag)
    {
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * @param array $tags
     *
     * @return AbstractTaggedEntity
     */
    public function setTags($tags)
    {
        $this->tags = new ArrayCollection();
        foreach ($tags as $tag) {
            $this->addTag($tag);
        }

        return $this;
    }

    /**
     * @param Tag $tag Тег
     *
     * @return AbstractTaggedEntity
     */
    public function removeTag(Tag $tag)
    {
        $this->tags->removeElement($tag);

        return $this;
    }

    /**
     * @return ArrayCollection|Tag[]
     */
    public function getTags()
    {
        return $this->tags;
    }
}
