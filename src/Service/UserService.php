<?php

namespace App\Service;

use App\Dto\UserDto;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Contracts\Service\Attribute\Required;

#[Aut]
class UserService {
	#[Required]
	public EntityManagerInterface $em;

	#[Required]
	public UserPasswordHasherInterface $passwordHasher;


	public function createUser(UserDto $userDto): User {
		$user = new User();
		$user->setEmail($userDto->getEmail())
		     ->setPassword($this->passwordHasher->hashPassword($user, $userDto->getPassword()))
		     ->setIsVerified($userDto->getIsVerified());

		$this->em->persist($user);
		$this->em->flush();

		return $user;
	}

	public function updateUser(User $user, UserDto $userDto): User {
		if ($userDto->getEmail()) {
			$user->setEmail($userDto->getEmail());
		}

		if ($userDto->getPassword()) {
			$user->setPassword($this->passwordHasher->hashPassword($user, $userDto->getPassword()));
		}

		if (!is_null($userDto->getIsVerified())) {
			$user->setIsVerified($userDto->getIsVerified());
		}

		$this->em->flush();

		return $user;
	}

}