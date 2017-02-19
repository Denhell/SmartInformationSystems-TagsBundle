<?php
namespace SmartInformationSystems\TagsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Doctrine\ORM\EntityManager;
use SmartInformationSystems\TagsBundle\Entity\TagRelation;

class TagRelationsType extends AbstractType
{
    /**
     * Подключение к БД.
     *
     * @var EntityManager
     */
    private $em;

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
        $view->vars['objects'] = [];

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

            $view->vars['objects'][] = [
                'entity' => $entity,
                'entityClass' => $r->getEntityClass(),
                'editRoute' => $editRoute,
            ];
        }
    }
}
