<?php

namespace SmartInformationSystems\TagsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

use SmartInformationSystems\TagsBundle\Entity\TagRepository;

class DefaultController extends Controller
{
    /**
     * Обработчик тегов.
     *
     * @var TagRepository
     */
    private $repository = NULL;

    /**
     * Поиск тегов по запросу.
     *
     * @return JsonResponse
     */
    public function searchAction()
    {
        $result = array();

        foreach ($this->getRepository()->search($this->getRequest()->get('q')) as $tag) {
            $result[] = $tag->getTitle();
        }

        return new JsonResponse($result);
    }

    /**
     * Возвращает обработчик тегов.
     *
     * @return TagRepository
     */
    private function getRepository()
    {
        if ($this->repository === NULL) {
            $this->repository = $this->getDoctrine()->getRepository('SmartInformationSystemsTagsBundle:Tag');
        }

        return $this->repository;
    }
}
