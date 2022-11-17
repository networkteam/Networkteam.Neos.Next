<?php

namespace Networkteam\Neos\Next\ContentRepository;

use Networkteam\Neos\Next\Exception;

class NodesHelper
{

    public static function getSiteNodeNameFromContextPath(string $contextPath): string
    {
        if (!str_starts_with($contextPath, '/sites/')) {
            throw new Exception(sprintf("Unexpected context path %s, could not get site node name", $contextPath), 1668697631);
        }
        $contextPath = substr($contextPath, strlen('/sites/'));
        return substr($contextPath, 0, strpos($contextPath, '/'));
    }
}
