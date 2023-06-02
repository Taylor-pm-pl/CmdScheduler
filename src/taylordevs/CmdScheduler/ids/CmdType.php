<?php

declare(strict_types=1);

namespace taylordevs\CmdScheduler\ids;

enum CmdType
{
    const CONSOLE = 0;
    const SHELL = 1;
    const SCRIPT = 2;
}