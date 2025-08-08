<?php

namespace App\Controller;

use App\DTO\CreateTaskDTO;
use App\DTO\MarkTaskDTO;
use App\Repository\ListItemRepository;
use App\Repository\ListEntityRepository;
use App\DTO\SerializableListItem;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

final class TasksController extends AbstractController
{
    private ListEntityRepository $listsRepository;
    private ListItemRepository $listItemsRepository;

    public function __construct(ListEntityRepository $listsRepository, ListItemRepository $listItemsRepository)
    {
        $this->listsRepository = $listsRepository;
        $this->listItemsRepository = $listItemsRepository;
    }

    #[Route('/api/lists/{listID<\d+>}/tasks', name: 'create_task', methods: ['POST'])]
    public function createTask(
        int $listID,
        #[MapRequestPayload] CreateTaskDTO $data,
    ): JsonResponse {
        $list = $this->listsRepository->getListByID($listID);
        if ($list === null) {
            return $this->json("list with id: $listID not found", 404);
        }

        $task = $this->listItemsRepository->createItem(
            $data->getName(),
            $data->getDescription(),
            $list,
        );

        return $this->json(new SerializableListItem($task));
    }

    #[Route('/api/tasks/{id<\d+>}/mark', name: 'mark_task', methods: ['PATCH'])]
    public function markTask(
        int $id,
        #[MapRequestPayload] ?MarkTaskDTO $data,
    ): JsonResponse {
        $item = $this->listItemsRepository->getItemByID($id);
        if ($item === null) {
            return $this->json("task with id: $id not found", 404);
        }
        $isDone = $data?->getIsDone() ?? true;
        $this->listItemsRepository->markItem($item, $isDone);
        return $this->json(new SerializableListItem($item));
    }

    #[Route('/api/tasks/{id<\d+>}', name: 'delete_task', methods: ['DELETE'])]
    public function deleteTask(
        int $id,
    ): JsonResponse {
        $item = $this->listItemsRepository->getItemByID($id);
        if ($item === null) {
            return $this->json("task with id: $id not found", 404);
        }

        $this->listItemsRepository->deleteItemByID($id);
        return $this->json([], 204);
    }
}
