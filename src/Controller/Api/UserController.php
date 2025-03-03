<?php

namespace App\Controller\Api;

use App\Dto\UserDto;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Contracts\Service\Attribute\Required;

class UserController extends AbstractController {

	#[Required]
	public UserService $userService;

	#[Required]
	public EntityManagerInterface $em;

	#[Route('/api/user', name: 'api_user_index', methods: ['GET'])]
	public function index(UserRepository $userRepository): Response
	{
		$users = $userRepository->findAll();

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
		$em->remove($user);
		$em->flush();

		return $this->json([]);
	}
}