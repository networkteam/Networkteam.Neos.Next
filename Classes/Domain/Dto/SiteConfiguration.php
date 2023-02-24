<?php
namespace Networkteam\Neos\Next\Domain\Dto;

class SiteConfiguration
{
    public function __construct(
        public readonly string $nextBaseUrl,
        public readonly string $revalidateUrl,
        public readonly string $revalidateToken,
        public readonly array $extraRevalidateSites
    )
    {
    }
}
