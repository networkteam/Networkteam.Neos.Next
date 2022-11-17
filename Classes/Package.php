<?php

namespace Networkteam\Neos\Next;

use Neos\ContentRepository\Domain\Model\Workspace;
use Neos\Flow\Core\Bootstrap;
use Neos\Flow\Package\Package as BasePackage;
use Neos\Neos\Service\PublishingService;
use Networkteam\Neos\Next\Domain\Service\RevalidateNotifier;

class Package extends BasePackage
{
    public function boot(Bootstrap $bootstrap)
    {
        $dispatcher = $bootstrap->getSignalSlotDispatcher();

        // TODO Revalidate all if site was changed
        // $dispatcher->connect(Site::class, 'siteChanged', $flushConfigurationCache);

        // TODO Revalidate documents where asset was used
        // $dispatcher->connect(AssetService::class, 'assetUpdated', ContentCacheFlusher::class, 'registerAssetChange', false);

        $dispatcher->connect(PublishingService::class, 'nodePublished', RevalidateNotifier::class, 'nodeWasPublished', false);
        $dispatcher->connect(Workspace::class, 'beforeNodePublishing', RevalidateNotifier::class, 'nodeWillBePublished', false);

        // TODO Do we need to inform about discarded nodes?
        // $dispatcher->connect(PublishingService::class, 'nodeDiscarded', RevalidateNotifier::class, 'registerNodeChange', false);

        // TODO Revalidate on site prune?
        // $dispatcher->connect(SiteService::class, 'sitePruned', ContentCache::class, 'flush');

        // TODO Revalidate on site import?
        // $dispatcher->connect(SiteImportService::class, 'siteImported', ContentCache::class, 'flush');
    }
}
