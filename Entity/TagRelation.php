<?php
namespace SmartInformationSystems\TagsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Связи с тегами
 *
 * @ORM\Entity(repositoryClass="SmartInformationSystems\TagsBundle\Repository\TagRelationRepository")
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
     * Идентификатор
     *
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned"=true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Тег
     *
     * @var Tag
     *
     * @ORM\ManyToOne(targetEntity="Tag", inversedBy="relations")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    private $tag;

    /**
     * Класс связанноый сущности
     *
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $entityClass;

    /**
     * Идентификатор связанноый сущности
     *
     * @var integer
     *
     * @ORM\Column(type="integer", options={"unsigned"=true})
     */
    private $entityId;

    /**
     * Приоритет
     *
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $priority;

    /**
     * Дата создания
     *
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * Дата последнего изменения
     *
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $entityClass
     *
     * @return TagRelation
     */
    public function setEntityClass($entityClass)
    {
        $this->entityClass = $entityClass;

        return $this;
    }

    /**
     * @return string
     */
    public function getEntityClass()
    {
        return $this->entityClass;
    }

    /**
     * @param integer $entityId
     *
     * @return TagRelation
     */
    public function setEntityId($entityId)
    {
        $this->entityId = $entityId;

        return $this;
    }

    /**
     * @return integer
     */
    public function getEntityId()
    {
        return $this->entityId;
    }

    /**
     * @param integer $priority
     *
     * @return TagRelation
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * @return integer
     */
    public function getPriority()
    {
        return $this->priority;
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
     * @param Tag $tag
     *
     * @return TagRelation
     */
    public function setTag(Tag $tag)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * @return Tag
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersistHandler()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdateHandler()
    {
        $this->updatedAt = new \DateTime();
    }
}
