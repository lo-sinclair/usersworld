<?php

namespace App\Controller\Api;

use App\Dto\UserDto;
use App\Entity\User;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Service\Attribute\Required;

#[IsGranted('ROLE_ADMIN')]
class UserController extends AbstractController {

	#[Required]
	public UserService $userService;

	#[Required]
	public EntityManagerInterface $em;

	#[Route('/api/user', name: 'api_user_index', methods: ['GET'])]
	public function index(): Response
	{
		$users = $this->userService->getAll();

		return $this->json($users , context: [
			//AbstractNormalizer::GROUPS => ['view_list']
		]);
	}

	#[Route('/api/user/{id}', name: 'api_user_edit', methods: ['PUT'], format: 'json')]
	public function update(int $id, #[MapRequestPayload] UserDto $userDto): Response {
		$user = $this->em->getRepository(User::class)->find($id);

		if (!$user) {
			return $this->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
		}

		$updatedUser = $this->userService->updateUser($user, $userDto);
		return $this->json($updatedUser);
	}

	#[Route('/api/user/{user}', name: 'api_user_delete', methods: ['DELETE'], format: 'json')]
	public function delete(User $user, EntityManagerInterface $em): Response {

		$this->userService->deleteUser($user);
		return new Response(null, Response::HTTP_NO_CONTENT);
	}
}