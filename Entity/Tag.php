<?php

namespace SmartSystems\TagsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Тег.
 *
 * @ORM\Entity(repositoryClass="SmartSystems\TagsBundle\Entity\TagRepository")
 * @ORM\Table(name="sis_tag")
 * @ORM\HasLifecycleCallbacks()
 */
class Tag
{
    /**
     * Идентификатор.
     *
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned"=true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Название.
     *
     * @var string
     *
     * @ORM\Column(unique=true)
     */
    protected $title;

    /**
     * Дата создания.
     *
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    protected $createdAt;

    /**
     * Дата последнего изменения.
     *
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    protected $updatedAt;

    /**
     * Связи.
     *
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="TagRelation", mappedBy="tag", cascade="all", orphanRemoval=true)
     */
    protected $relations;

    /**
     * Конструктор.
     *
     */
    public function __construct()
    {
        $this->relations = new ArrayCollection();
    }

    /**
     * Возвращает идентификатор.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Устанавливает название.
     *
     * @param string $title Название
     *
     * @return Tag
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Возвращает название.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Устанавливает дату создания.
     *
     * @param \DateTime $createdAt Дата создания
     *
     * @return Tag
     */
    private function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Возвращает дату создания.
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Устанавливает дату последнего изменения.
     *
     * @param \DateTime $updatedAt Дата последнего изменения
     * @return Tag
     */
    private function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Возвращает дату последнего изменения.
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Выполняется перед сохранением в БД.
     *
     * @ORM\PrePersist
     */
    public function prePersistHandler()
    {
        $this->setCreatedAt(new \DateTime());
    }

    /**
     * Автоматическая установка даты обновления.
     *
     * @ORM\PreUpdate
     */
    public function preUpdateHandler()
    {
        $this->setUpdatedAt(new \DateTime());
    }

    /**
     * Преобразует в строку.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getTitle();
    }

    /**
     * Добавляет свзяь.
     *
     * @param TagRelation $relation Связь
     *
     * @return Tag
     */
    public function addRelation(TagRelation $relation)
    {
        $this->relations[] = $relation;

        return $this;
    }

    /**
     * Удаляет свзяь.
     *
     * @param TagRelation $relation Связь
     *
     * @return Tag
     */
    public function removeRelation(TagRelation $relation)
    {
        $this->relations->removeElement($relation);

        return $this;
    }

    /**
     * Возвращает связи.
     *
     * @return ArrayCollection
     */
    public function getRelations()
    {
        return $this->relations;
    }
}
