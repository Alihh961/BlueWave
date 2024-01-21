<?php

namespace App\Twig\Runtime;

use Twig\Extension\RuntimeExtensionInterface;

class ZeroTrimmersRuntime implements RuntimeExtensionInterface
{
    public function __construct()
    {
        // Inject dependencies if needed
    }

    public function trimZeros($value)
    {
        return rtrim(rtrim($value, '0'), '.');
    }
}
