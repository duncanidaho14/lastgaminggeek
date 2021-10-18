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

        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2MzQ1NDk0NDQsImV4cCI6MTYzNDU1MzA0NCwicm9sZXMiOlsiUk9MRV9BRE1JTiIsIlJPTEVfVVNFUiJdLCJ1c2VybmFtZSI6ImVsaGFkaWJlZGRhcmVtQGdtYWlsLmNvbSJ9.vAXuuVtKpTDeMzj8nFKPoXs7YnccNQC_v1aOl2BPFgShbRtePcMCV-UQHh2wcSNpQjthh-pb54Ul3g99M-9V7ohAdaPlM5bFGvLLvXkUo90fubIdIZMSgEs3srwPvcTh1ZR6_SQN6q8j5FaV3AXeM7p26l7ChkqkP2u_8qgV4KjmmcNkIv6xrV66OLVs1WiLRF6FORQlu52LyhI5OPaZROarDxBIWl9Tm0WK2zWZsuUViqH2loqKjE2vFV09dORZ7TrZINp43f1YSw1AYCixjtAXKsKgYhDmwCTVfxXwpSuRuPfuwsQGqdbFUPX-5kJo_gyp56jjUsXQ-vb5Tht2fw';

        return $this->json([
            'user' => $user->getUserIdentifier(),
            'username' => "elhadibeddarem@gmail.com",
            "password" => "password",
            'token' => $token
        ]);
        // return new JsonResponse();
    }
}
