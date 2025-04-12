<?php
namespace SmartInformationSystems\TagsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Тег
 */
#[ORM\Table(name: 'sis_tag')]
#[ORM\Entity(repositoryClass: \SmartInformationSystems\TagsBundle\Repository\TagRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Tag
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
     * Название
     *
     * @var string
     */
    #[ORM\Column(type: 'string', unique: true)]
    private ?string $title = null;

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
     * Связи
     *
     * @var ArrayCollection
     */
    #[ORM\OneToMany(targetEntity: \TagRelation::class, mappedBy: 'tag')]
    private \Doctrine\Common\Collections\Collection $relations;

    /**
     * Приоритет. Не сохраняется в БД
     *
     * @var integer
     */
    private $priority;

    public function __construct()
    {
        $this->relations = new ArrayCollection();
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $title
     *
     * @return Tag
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
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

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->title;
    }

    /**
     * @param TagRelation $relation
     *
     * @return Tag
     */
    public function addRelation(TagRelation $relation)
    {
        $this->relations[] = $relation;

        return $this;
    }

    /**
     * @param TagRelation $relation
     *
     * @return Tag
     */
    public function removeRelation(TagRelation $relation)
    {
        $this->relations->removeElement($relation);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getRelations()
    {
        return $this->relations;
    }

    /**
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param int $priority
     *
     * @return Tag
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }
}
