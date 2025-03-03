<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\PasswordStrength;

class UserDto {

	#[Assert\Email()]
	private ?string $email;


	private ?string $password;

	private ?bool $isVerified;

	public function getEmail(): ?string {
		return $this->email;
	}

	public function setEmail( ?string $email ): static {
		$this->email = $email;

		return $this;
	}

	public function getPassword(): ?string {
		return $this->password;
	}

	public function setPassword( ?string $password ): static {
		$this->password = $password;

		return $this;
	}

	public function getIsVerified(): ?bool {
		return $this->isVerified;
	}

	public function setIsVerified( ?bool $isVerified ): static {
		$this->isVerified = $isVerified;

		return $this;
	}




}