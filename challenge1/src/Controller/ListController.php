<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class ListController extends AbstractController
{
    #[Route('/lists/{id}', name: 'get_list', methods: ['GET'])]
    public function getList(): JsonResponse
    {
        return $this->json([]);
    }
    #[Route('/lists', name: 'crete_list', methods: ['POST'])]
    public function createList(): JsonResponse
    {
        return $this->json([]);
    }
}
