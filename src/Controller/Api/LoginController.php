<?php

namespace App\Controller\Api;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class LoginController extends AbstractController
{
	#[Route('/api/login', name: 'api_login')]
	public function index(#[CurrentUser] ?User $user): Response
	{
		if (null === $user) {
			return $this->json([
			'message' => 'missing credentials',
			], Response::HTTP_UNAUTHORIZED);
       }

		return $this->json([
			'message' => 'Welcome to your new controller!',
			'path' => 'src/Controller/Api/LoginController.php',
		]);
	}
}