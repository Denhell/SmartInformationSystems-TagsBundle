<?php

namespace SmartInformationSystems\TagsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Тег.
 *
 * @ORM\Entity(repositoryClass="SmartInformationSystems\TagsBundle\Entity\TagRelationRepository")
 * @ORM\Table(
 *   name="sis_tag_relation",
 *   uniqueConstraints={@ORM\UniqueConstraint(name="ui_relation", columns={"tag_id", "entity_class", "entity_id"})},
 *   indexes={
 *     @ORM\Index(name="i_entity", columns={"entity_class", "entity_id"}),
 *   }
 * )
 * @ORM\HasLifecycleCallbacks()
 */
class TagRelation
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
     * Тег.
     *
     * @var Tag
     *
     * @ORM\ManyToOne(targetEntity="Tag", inversedBy="relations")
     * @ORM\JoinColumn(name="tag_id", referencedColumnName="id", nullable=false)
     */
    protected $tag;

    /**
     * Класс связанноый сущности.
     *
     * @var string
     *
     * @ORM\Column(name="entity_class")
     */
    protected $entityClass;

    /**
     * Идентификатор связанноый сущности.
     *
     * @var integer
     *
     * @ORM\Column(type="integer", name="entity_id", options={"unsigned"=true})
     */
    protected $entityId;

    /**
     * Приоритет.
     *
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    protected $priority;

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
     * Возвращает идентификатор.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Устанавливает класс связанной сущности.
     *
     * @param string $entityClass Класс связанной сущности
     *
     * @return TagRelation
     */
    public function setEntityClass($entityClass)
    {
        $this->entityClass = $entityClass;

        return $this;
    }

    /**
     * Возвращает класс связанной сущности.
     *
     * @return string
     */
    public function getEntityClass()
    {
        return $this->entityClass;
    }

    /**
     * Устанавливает идентификатор связанной сущности.
     *
     * @param integer $entityId Идентификатор связанной сущности
     *
     * @return TagRelation
     */
    public function setEntityId($entityId)
    {
        $this->entityId = $entityId;

        return $this;
    }

    /**
     * Возвращает идентификатор связанной сущности.
     *
     * @return integer
     */
    public function getEntityId()
    {
        return $this->entityId;
    }

    /**
     * Устанавливает приоритет.
     *
     * @param integer $priority Приоритет
     *
     * @return TagRelation
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Возвращает приоритет.
     *
     * @return integer
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Устанавливает дату создания.
     *
     * @param \DateTime $createdAt Дата создания
     *
     * @return TagRelation
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
     * Устанавливает тег.
     *
     * @param Tag $tag Тег
     *
     * @return TagRelation
     */
    public function setTag(Tag $tag)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Возвращает тег.
     *
     * @return Tag
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Устанавливает дату последнего обновления.
     *
     * @param \DateTime $updatedAt Дата последнего обновления
     *
     * @return TagRelation
     */
    private function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Возвращает дату последнего обновления.
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
}
