<?php

namespace App\Controller;

use App\DTO\CreateListDTO;
use App\Repository\ListsRepository;
use App\Service\ValidatorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class ListsController extends AbstractController
{
    private ListsRepository $listsRepository;
    private ValidatorService $validator;

    public function __construct(ListsRepository $listsRepository, ValidatorService $validator)
    {
        $this->listsRepository = $listsRepository;
        $this->validator = $validator;
    }

    #[Route('/lists/{id}', name: 'get_list', methods: ['GET'])]
    public function getList(int $id): JsonResponse
    {
        $list = $this->listsRepository->getListByID($id);
        return $this->json($list);
    }

    #[Route('/lists', name: 'crete_list', methods: ['POST'])]
    public function createList(Request $req, SerializerInterface $serializer): JsonResponse
    {
        /** @var CreateListDTO $data */
        $data = $serializer->deserialize($req->getContent(), CreateListDTO::class, 'json');

        $errors = $this->validator->validate($data);

        if (!empty($errors)) {
            return $this->json(['errors' => $errors], 422);
        }

        $list = $this->listsRepository->createList($data);

        return $this->json($list);
    }
}
