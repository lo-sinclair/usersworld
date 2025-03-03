<?php

namespace App\Controller\Api;

use App\Dto\UserDto;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class UserController extends AbstractController {

	#[Route('/api/user', name: 'api_user_index', methods: ['GET'])]
	public function index(UserRepository $userRepository): Response
	{
		$users = $userRepository->findAll();

		return $this->json($users , context: [
			//AbstractNormalizer::GROUPS => ['view_list']
		]);
	}

	#[Route('/api/user/add', name: 'api_user_add', methods: ['POST'], format: 'json')]
	public function add(#[MapRequestPayload] UserDto $userDto, EntityManagerInterface $em, UserPasswordHasherInterface $userPasswordHasher): Response {
		$user = new User();
		$user->setEmail($userDto->getEmail())
		     ->setPassword($userPasswordHasher->hashPassword($user, $userDto->getPassword()))
		     ->setIsVerified($userDto->getIsVerified());

		//$user = User::createFromDto( $userDto );

		$em->persist( $user );
		$em->flush();

		return $this->json( $user );
	}

	#[Route('/api/user/{user}', name: 'api_user_dlete', methods: ['DELETE'], format: 'json')]
	public function delete(User $user, EntityManagerInterface $em): Response {
		$em->remove($user);
		$em->flush();

		return $this->json([]);
	}
}