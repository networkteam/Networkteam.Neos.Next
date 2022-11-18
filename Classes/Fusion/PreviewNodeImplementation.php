<?php

namespace Networkteam\Neos\Next\Fusion;

use Neos\Flow\Annotations as Flow;
use GuzzleHttp\Client;
use Neos\ContentRepository\Domain\Model\NodeInterface;
use Neos\Fusion\FusionObjects\AbstractFusionObject;
use Networkteam\Neos\Next\ContentRepository\NodesHelper;
use Networkteam\Neos\Next\Domain\Service\SitesConfiguration;

class PreviewNodeImplementation extends AbstractFusionObject
{

    /**
     * @Flow\Inject
     * @var SitesConfiguration
     */
    protected $sitesConfiguration;

    public function evaluate()
    {
        $node = $this->fusionValue('node');
        if (!$node instanceof NodeInterface) {
            throw new \InvalidArgumentException('node must be a NodeInterface', 1662393348);
        }

        $nodeContextPath = $node->getContextPath();

        return $this->fetchPreviewNodeFromNext($nodeContextPath);
    }

    private function fetchPreviewNodeFromNext(string $nodeContextPath)
    {
        $siteNodeName = NodesHelper::getSiteNodeNameFromContextPath($nodeContextPath);
        $siteConfiguration = $this->sitesConfiguration->getSiteConfiguration($siteNodeName);

        $client = new Client([
            'base_uri' => $siteConfiguration->nextBaseUrl,
        ]);

        $response = $client->get('/neos/previewNode?node[__contextNodePath]=' . urlencode($nodeContextPath), [
            // TODO Only forward Neos session cookie
            // Pass cookie header to forward authentication to backend restricted page
            'headers' => [
                'Cookie' => $this->getRuntime()->getControllerContext()->getRequest()->getHttpRequest()->getHeader('Cookie'),
            ],
        ]);

        // TODO Handle error responses correctly

        $content = (string)$response->getBody();

        // TODO Optimize to get only the content of <div id="__next">
        return $content;
    }
}
