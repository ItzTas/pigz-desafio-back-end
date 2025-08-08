<?php

namespace App\Controller;

use App\DTO\CreateTaskDTO;
use App\Repository\ListItemsRepository;
use App\Repository\ListsRepository;
use App\Service\ValidatorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class TasksController extends AbstractController
{
    private ListsRepository $listsRepository;
    private ListItemsRepository $listItemsRepository;

    public function __construct(ListsRepository $listsRepository, ListItemsRepository $listItemsRepository)
    {
        $this->listsRepository = $listsRepository;
        $this->listItemsRepository = $listItemsRepository;
    }

    #[Route('/api/list/{listID<\d+>}/task', name: 'create_task', methods: ['POST'])]
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

        return $this->json($task);
    }
}
