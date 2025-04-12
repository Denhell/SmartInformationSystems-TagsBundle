<?php
namespace SmartInformationSystems\TagsBundle\Form\DataTransformer;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\DataTransformerInterface;
use SmartInformationSystems\TagsBundle\Entity\Tag;

class TagsTransformer implements DataTransformerInterface
{
    /**
     * Подключение к БД.
     *
     * @var EntityManager
     */
    private $entityManager;

    /**
     * Связанный объект.
     *
     * @var object
     */
    private $relativeEntity;

    public function __construct(EntityManager $entityManager, $relativeEntity)
    {
        $this->entityManager = $entityManager;
        $this->relativeEntity = $relativeEntity;
    }

    /**
     * {@inheritdoc}
     */
    public function transform(mixed $value): mixed
    {
        if (empty($tags)) {
            return '';
        }

        $tagTitles = [];
        /** @var Tag $tag */
        foreach ($tags as $tag) {
            $tagTitles[] = $tag->getTitle();
        }

        return implode(',', $tagTitles);
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform(mixed $value): mixed
    {
        if (empty($value) || !is_string($value)) {
            return [];
        }

        $titles = explode(',', $value);
        array_walk($titles, 'trim');
        error_log(print_r($titles, true));

        $repository = $this->entityManager->getRepository(Tag::class);
        $tags = [];

        $priority = 1;
        foreach ($titles as $title) {
            if (!($tag = $repository->getByTitle($title))) {
                $tag = new Tag();
                $tag->setTitle($title);
                $this->entityManager->persist($tag);
            }
            $tag->setPriority($priority++);
            $tags[] = $tag;
        }

        foreach ($tags as $tag) {
            error_log(print_r((string)$tag, true));
        }

        return $tags;
    }
}
