<?php
namespace SmartInformationSystems\TagsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Связи с тегами
 */
#[ORM\Table(name: 'sis_tag_relation')]
#[ORM\Index(name: 'i_entity', columns: ['entity_class', 'entity_id'])]
#[ORM\UniqueConstraint(name: 'ui_relation', columns: ['tag_id', 'entity_class', 'entity_id'])]
#[ORM\Entity(repositoryClass: \SmartInformationSystems\TagsBundle\Repository\TagRelationRepository::class)]
#[ORM\HasLifecycleCallbacks]
class TagRelation
{
    /**
     * Идентификатор
     *
     * @var int
     */
    #[ORM\Id]
    #[ORM\Column(type: 'integer', options: ['unsigned' => true])]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private ?int $id = null;

    /**
     * Тег
     *
     * @var Tag
     */
    #[ORM\JoinColumn(referencedColumnName: 'id', nullable: false)]
    #[ORM\ManyToOne(targetEntity: \Tag::class, inversedBy: 'relations')]
    private ?\SmartInformationSystems\TagsBundle\Entity\Tag $tag = null;

    /**
     * Класс связанноый сущности
     *
     * @var string
     */
    #[ORM\Column(type: 'string')]
    private ?string $entityClass = null;

    /**
     * Идентификатор связанноый сущности
     *
     * @var integer
     */
    #[ORM\Column(type: 'integer', options: ['unsigned' => true])]
    private ?int $entityId = null;

    /**
     * Приоритет
     *
     * @var integer
     */
    #[ORM\Column(type: 'integer')]
    private ?int $priority = null;

    /**
     * Дата создания
     *
     * @var \DateTimeInterface
     */
    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $createdAt = null;

    /**
     * Дата последнего изменения
     *
     * @var \DateTimeInterface
     */
    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

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

    #[ORM\PrePersist]
    public function prePersistHandler()
    {
        $this->createdAt = new \DateTime();
    }

    #[ORM\PreUpdate]
    public function preUpdateHandler()
    {
        $this->updatedAt = new \DateTime();
    }
}
