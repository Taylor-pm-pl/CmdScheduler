<?php

declare(strict_types=1);

namespace taylordevs\CmdScheduler;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;
use Symfony\Component\Filesystem\Path;
use taylordevs\CmdScheduler\job\Job;
use taylordevs\CmdScheduler\job\JobTask;

class Loader extends PluginBase {

    use SingletonTrait;

    /**
     * @throws \Exception
     */
    protected function onEnable(): void
    {
        self::setInstance($this);
        require_once $this->getFile() . "vendor/autoload.php";
        $this->saveDefaultConfig();
        $timezone = $this->getConfig()->get("timezone", '');
        if ($timezone !== '') {
            date_default_timezone_set($timezone);
        }
        @mkdir($this->getDataFolder() . "scripts");
        $this->saveResource("scripts/test.php");
        $this->initAllJobs();
    }

    public function getScriptPath(string $scriptName): string
    {
        return Path::join($this->getDataFolder(), "scripts", $scriptName);
    }

    private function initAllJobs(): void
    {
        $jobs = $this->getConfig()->get("Scheduler", []);
        foreach ($jobs as $job) {
           try {
               $job = new Job($job);
               $this->getScheduler()->scheduleRepeatingTask(new JobTask($job), 20);
           } catch (\Exception $e) {
               $this->getLogger()->error($e->getMessage());
           }
        }
    }
}