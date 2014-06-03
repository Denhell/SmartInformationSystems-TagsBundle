<?php

namespace SmartInformationSystems\TagsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityManager;

use SmartInformationSystems\TagsBundle\Form\DataTransformer\TagsTransformer;

/**
 * Тип поля - "теги".
 *
 */
class TagsType extends AbstractType
{
    /**
     * Подключение к БД.
     *
     * @var EntityManager
     */
    private $om;

    /**
     * Конструктор.
     *
     * @param EntityManager $entityManager Подключение к БД
     *
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->om = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(
            new TagsTransformer(
                $this->om,
                $options['relativeEntity']
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(array(
            'relativeEntity',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'text';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sis_tags_type';
    }
}
