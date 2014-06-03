<?php

namespace SmartInformationSystems\TagsBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * Обработчик событий Doctrine.
 *
 */
class DoctrineListener
{
    /**
     * Обработчик события "postLoad".
     *
     * @param LifecycleEventArgs $args
     *
     * @return void
     */
    public function postLoad(LifecycleEventArgs $args)
    {
    }
}
