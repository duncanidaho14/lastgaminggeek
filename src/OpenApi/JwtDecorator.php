<?php

namespace App\OpenApi;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\OpenApi\OpenApi;
use ApiPlatform\Core\OpenApi\Factory\OpenApiFactoryInterface;

class JwtDecorator implements OpenApiFactoryInterface
{
    private OpenApiFactoryInterface $decorated;
    //private string $appVersion;

    public function __construct(OpenApiFactoryInterface $decorated)
    {
        $this->decorated = $decorated;
        //$this->appVersion = $appVersion;
    }

    public function __invoke(array $context = []): OpenApi
    {
        $openApi = $this->decorated->__invoke($context);

        return $openApi;
    }
}
