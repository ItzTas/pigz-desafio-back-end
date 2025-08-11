<?php

namespace App\Controller\Lists;

use App\DTO\CreateListDTO;
use App\Repository\ListEntityRepository;
use App\DTO\SerializableListEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

final class ListsController extends AbstractController
{

    public function __construct(
        private ListEntityRepository $listsRepository
    ) {}

    #[Route('/lists/{id<\d+>}', name: 'get_list', methods: ['GET'])]
    public function getList(int $id): JsonResponse
    {
        $list = $this->listsRepository->findListByID($id);
        if ($list === null) {
            throw new NotFoundHttpException("list with id: $id not found");
        }
        return $this->json(new SerializableListEntity($list));
    }

    #[Route('/lists/{id<\d+>}', name: 'delete_list', methods: ['DELETE'])]
    public function deleteList(int $id): JsonResponse
    {
        $list = $this->listsRepository->findListByID($id);
        if ($list === null) {
            return $this->json("list with id: $id not found", 404);
        }

        $this->listsRepository->deleteListbyID($id);
        return $this->json([], 204);
    }

    #[Route('/lists', name: 'create_list', methods: ['POST'])]
    public function createList(
        #[MapRequestPayload] CreateListDTO $data,
    ): JsonResponse {
        $list = $this->listsRepository->createList($data->getName(), $data->getDescription());
        return $this->json(new SerializableListEntity($list));
    }
}
