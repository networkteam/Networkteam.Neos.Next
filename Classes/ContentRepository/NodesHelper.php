<?php

namespace Networkteam\Neos\Next\ContentRepository;

use Networkteam\Neos\Next\Exception;

class NodesHelper
{

    public static function getSiteNodeNameFromContextPath(string $contextPath): string
    {
        if (preg_match('#^/sites/([^/@]*)#', $contextPath, $matches)) {
            return $matches[1];
        }
        throw new Exception(sprintf("Unexpected context path %s, could not get site node name", $contextPath), 1668697631);
    }
}
