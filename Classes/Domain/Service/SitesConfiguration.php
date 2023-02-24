<?php

namespace Networkteam\Neos\Next\Domain\Service;

use Neos\Flow\Annotations as Flow;
use Neos\Utility\Arrays;
use Networkteam\Neos\Next\Domain\Dto\SiteConfiguration;
use Networkteam\Neos\Next\Exception;

class SitesConfiguration
{

    /**
     * @Flow\InjectConfiguration(path="sites")
     * @var array
     */
    protected $sitesConfiguration;

    public function getSiteConfiguration(string $siteNodeName): SiteConfiguration
    {
        if (!isset($this->sitesConfiguration['_default'])) {
            throw new Exception('No site configuration found for "_default"', 1668698157);
        }

        $siteConfiguration = Arrays::arrayMergeRecursiveOverrule($this->sitesConfiguration['_default'], $this->sitesConfiguration[$siteNodeName] ?? []);

        if (empty($siteConfiguration['nextBaseUrl'])) {
            throw new Exception(sprintf('No "nextBaseUrl" configured for site "%s" or "_default"', $siteNodeName), 1668698158);
        }

        $nextBaseUrl = $siteConfiguration['nextBaseUrl'];

        if (empty($siteConfiguration['revalidate']['uri'])) {
            throw new Exception(sprintf('No "revalidate.uri" configured for site "%s" or "_default"', $siteNodeName), 1668698159);
        }

        $revalidateUri = $siteConfiguration['revalidate']['uri'];
        // If we have a full revalidate URL configured, we use that one.
        if (str_starts_with($revalidateUri, 'http')) {
            $revalidateUrl = $revalidateUri;
        } else {
            $revalidateUrl = rtrim($nextBaseUrl, '/') . $revalidateUri;
        }

        if (empty($siteConfiguration['revalidate']['token'])) {
            throw new Exception(sprintf('No "revalidate.token" configured for site "%s" or "_default"', $siteNodeName), 1668698160);
        }

        $revalidateToken = $siteConfiguration['revalidate']['token'];

        $extraRevalidateSites = $siteConfiguration['extraRevalidateSites'] ?? [];

        return new SiteConfiguration($nextBaseUrl, $revalidateUrl, $revalidateToken, $extraRevalidateSites);
    }
}
