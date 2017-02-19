<?php
namespace SmartInformationSystems\TagsBundle\Controller;

use SmartInformationSystems\TagsBundle\Entity\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class TagsController extends Controller
{
    /**
     * Поиск тегов по запросу
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function searchAction(Request $request)
    {
        $result = [];
        foreach ($this->getDoctrine()->getRepository(Tag::class)->search($request->get('q')) as $tag) {
            $result[] = $tag->getTitle();
        }
        return new JsonResponse($result);
    }
}
