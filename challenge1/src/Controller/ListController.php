<?php

namespace App\Controller;

use App\DTO\ListData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class ListController extends AbstractController
{
    #[Route('/lists/{id}', name: 'get_list', methods: ['GET'])]
    public function getList(): JsonResponse
    {
        return $this->json([]);
    }
    #[Route('/lists', name: 'crete_list', methods: ['POST'])]
    public function createList(Request $req, SerializerInterface $serializer): JsonResponse
    {
        $data = $serializer->deserialize($req->getContent(), ListData::class, 'json');
        return $this->json($data);
    }
}
