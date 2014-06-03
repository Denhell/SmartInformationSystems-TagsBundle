<?php

namespace SmartSystems\TagsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityManager;

use SmartSystems\TagsBundle\Entity\TagRelation;

/**
 * Тип поля - "теги".
 *
 */
class TagRelationsType extends AbstractType
{
    /**
     * Подключение к БД.
     *
     * @var EntityManager
     */
    private $em;

    /**
     * Конструктор.
     *
     * @param EntityManager $entityManager Подключение к БД
     *
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['objects'] = array();

        /** @var TagRelation $r */
        foreach ($view->vars['value'] as $r) {
            $entity = $this->em->getRepository($r->getEntityClass())->find($r->getEntityId());

            $editRoute = 'admin_' . str_replace(
                array(
                    'bundle\\',
                    '\\entity\\',
                    '\\',
                ),
                array(
                    '\\',
                    '\\',
                    '_',
                ),
                strtolower(get_class($entity))
            ) . '_edit';

            $view->vars['objects'][] = array(
                'entity' => $entity,
                'entityClass' => get_class($entity),
                'editRoute' => $editRoute,
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sis_tag_relations_type';
    }
}
