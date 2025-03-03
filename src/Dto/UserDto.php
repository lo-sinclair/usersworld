<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\PasswordStrength;

class UserDto {

	#[Assert\Email()]
	private ?string $email = null;

	#[Assert\NotBlank]
	#[Assert\Length(
		min: 6,
		max: 4096,
	)]
	public ?string $plainPassword = null;

	private ?bool $isVerified = null;

	private ?array $roles = null;

	public ?array $removeRoles = null;


	public function getEmail(): ?string {
		return $this->email;
	}

	public function setEmail( ?string $email ): static {
		$this->email = $email;

		return $this;
	}

	public function getPlainPassword(): ?string {
		return $this->plainPassword;
	}

	public function setPlainPassword( ?string $plainPassword ): static {
		$this->plainPassword = $plainPassword;

		return $this;
	}

	public function getRoles(): ?array {
		return $this->roles;
	}

	public function setRoles( array $roles ): static {
		$this->roles = $roles;

		return $this;
	}

	public function getRemoveRoles(): ?array {
		return $this->removeRoles;
	}

	public function getIsVerified(): ?bool {
		return $this->isVerified;
	}

	public function setIsVerified( ?bool $isVerified ): static {
		$this->isVerified = $isVerified;

		return $this;
	}




}