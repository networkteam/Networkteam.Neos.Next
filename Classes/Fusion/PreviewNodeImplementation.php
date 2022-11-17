<?php

namespace Networkteam\Neos\Next\Fusion;

use GuzzleHttp\Client;
use Neos\Flow\Annotations as Flow;
use Neos\ContentRepository\Domain\Model\NodeInterface;
use Neos\Fusion\FusionObjects\AbstractFusionObject;

class PreviewNodeImplementation extends AbstractFusionObject
{
    /**
     * @var string
     * @Flow\InjectConfiguration(path="nextBaseUri")
     */
    protected $nextBaseUri;

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
        $client = new Client([
            'base_uri' => $this->nextBaseUri,
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
