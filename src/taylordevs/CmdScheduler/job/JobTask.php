<?php

declare(strict_types=1);

namespace taylordevs\CmdScheduler\job;

use pocketmine\scheduler\Task;

class JobTask extends Task
{

    public function __construct(
        private Job $job
    ){}

    public function onRun(): void
    {
        if ($this->job->isValidate()) {
            $this->job->executeCommand();
            $this->job->setNextTime();
        }
    }
}