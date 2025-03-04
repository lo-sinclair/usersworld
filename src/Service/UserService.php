<?php

namespace App\Service;

use App\Dto\UserDto;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Contracts\Service\Attribute\Required;

#[Aut]
class UserService {
	#[Required]
	public EntityManagerInterface $em;

	#[Required]
	public UserPasswordHasherInterface $passwordHasher;

	#[Required]
	public UserRepository $userRepository;

	public function getAll(): ?array {
		return $this->userRepository->findAll();
	}

	public function createUser(UserDto $userDto): User {
		$user = new User();
		$user->setEmail($userDto->getEmail())
		     ->setPassword($this->passwordHasher->hashPassword($user, $userDto->getPlainPassword()))
		     ->setIsVerified($userDto->getIsVerified());
		if($userDto->getRoles()) {
			$user->setRoles($userDto->getRoles());
		}
		else {
			$user->setRoles(["ROLE_USER"]);
		}
		$this->em->persist($user);
		$this->em->flush();

		return $user;
	}

	public function updateUser(User $user, UserDto $userDto): User {
		if ($userDto->getEmail()) {
			$user->setEmail($userDto->getEmail());
		}

		if ($userDto->getPlainPassword()) {
			$user->setPassword($this->passwordHasher->hashPassword($user, $userDto->getPlainPassword()));
		}

		if (!is_null($userDto->getIsVerified())) {
			$user->setIsVerified($userDto->getIsVerified());
		}

		if($userDto->getRoles()) {
			$user->setRoles($userDto->getRoles());
		}

		if ($userDto->getRemoveRoles()) {
			foreach ($userDto->getRemoveRoles() as $role) {
				$user->removeRole($role);
			}
		}

		$this->em->flush();

		return $user;
	}

	public function deleteUser(User $user): void {
		$this->em->remove($user);
		$this->em->flush();
	}

}