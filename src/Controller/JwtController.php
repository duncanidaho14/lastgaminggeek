<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class JwtController extends AbstractController
{
    
    public function index(?User $user): Response
    {
        if (null === $user) {
            return $this->json([
                'message' => 'missing credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2MzQ1NTI0OTgsImV4cCI6MTYzNDU1NjA5OCwicm9sZXMiOlsiUk9MRV9BRE1JTiIsIlJPTEVfVVNFUiJdLCJ1c2VybmFtZSI6ImVsaGFkaWJlZGRhcmVtQGdtYWlsLmNvbSJ9.XVYr0Q90oNnYxLlYrq9VEDOq591VtXmFwgYGnKPbwuFT8yYnkTLDlcBFgdhuy7xRfz1Wc-0uXG00BflmIAYL1D5Wa2Vz8aqR7U5n-iWwEvI7MQ7XoVAlFKuPfw7ARdlmiss_7U05z86UMSBeBP-mG_WPEB6SRFXie2NFXk1TqMiz6hCoJ-Necw4s4zyfE_qcjV11kgwtqCagJW4e5uNyz_lyGtgF3Fcm9rZb63y07HwYDzO8_NoUM9dGtqSz1f15vjR2JCQ9mlRPtZwHt-ZETVmaq0lEkIKWRjd2NQs5VtkEAeQ49Rl2Xhmfq-KHjCGI05xK4bupwbNZ3YbPfd6Y9w';

        return $this->json([
            'user' => $user->getUserIdentifier(),
            'username' => $user->getEmail(),
            "password" => $user->getPassword(),
            'token' => $token
        ]);
        // return new JsonResponse();
    }
}
