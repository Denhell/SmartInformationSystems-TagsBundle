<?php
namespace SmartInformationSystems\TagsBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use SmartInformationSystems\TagsBundle\Common\AbstractTaggedEntity;
use SmartInformationSystems\TagsBundle\Service\TagRelationService;

class DoctrineSubscriber implements EventSubscriber
{
    /**
     * @var TagRelationService
     */
    private $tagRelationService;

    /**
     * @param TagRelationService $tagRelationService
     */
    public function setTagRelationService(TagRelationService $tagRelationService)
    {
        $this->tagRelationService = $tagRelationService;
    }

    /**
     * @inheritdoc
     */
    public function getSubscribedEvents()
    {
        return array(
            'postLoad',
            'postPersist',
            'postUpdate',
        );
    }

    /**
     * @param LifecycleEventArgs $args
     *
     * @return void
     */
    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if (!($entity instanceof AbstractTaggedEntity)) {
            return;
        }
        $this->tagRelationService->load($entity);

    }

    /**
     * @param LifecycleEventArgs $args
     *
     * @return void
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if (!($entity instanceof AbstractTaggedEntity)) {
            return;
        }
        $this->tagRelationService->update($entity);
    }

    /**
     * @param LifecycleEventArgs $args
     *
     * @return void
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if (!($entity instanceof AbstractTaggedEntity)) {
            return;
        }
        $this->tagRelationService->update($entity);
    }
}
