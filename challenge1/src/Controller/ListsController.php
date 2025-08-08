<?php

namespace App\Controller;

use App\DTO\CreateListDTO;
use App\Repository\ListsRepository;
use App\DTO\SerializableLists;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

final class ListsController extends AbstractController
{
    private ListsRepository $listsRepository;

    public function __construct(ListsRepository $listsRepository)
    {
        $this->listsRepository = $listsRepository;
    }

    #[Route('/api/lists/{id<\d+>}', name: 'get_list', methods: ['GET'])]
    public function getList(int $id): JsonResponse
    {
        $list = $this->listsRepository->getListByID($id);
        if ($list === null) {
            return $this->json("list with id: $id not found", 404);
        }
        return $this->json(new SerializableLists($list));
    }

    #[Route('/api/lists/{id<\d+>}', name: 'delete_list', methods: ['DELETE'])]
    public function deleteList(int $id): JsonResponse
    {
        $this->listsRepository->deleteListbyID($id);
        return $this->json([], 204);
    }

    #[Route('/api/lists', name: 'create_list', methods: ['POST'])]
    public function createList(
        #[MapRequestPayload] CreateListDTO $data,
    ): JsonResponse {
        $list = $this->listsRepository->createList($data->getName(), $data->getDescription());
        return $this->json(new SerializableLists($list));
    }
}
