<?php

declare(strict_types=1);

namespace taylordevs\CmdScheduler\job;
use Cron\CronExpression;
use pocketmine\console\ConsoleCommandSender;
use pocketmine\Server;
use taylordevs\CmdScheduler\ids\CmdType;
use taylordevs\CmdScheduler\Loader;

class Job
{
    /** @var CronExpression $cron */
    private CronExpression $cron;
    /** @var int $type */
    private int $type = 0;
    /** @var string $nextTime */
    private string $nextTime = "";
    /** @var string $command */
    private string $command = "";

    /**
     * @throws \Exception
     */
    public function __construct(array $options)
    {
        $this->cron = new CronExpression($options["time"]);
        $this->type = $options["type"];
        $this->setNextTime();
        $this->command = $options["command"];
    }

    private function getCurrenTime(): string
    {
        return date("Y-m-d H:i:s");
    }

    private function getNextTime(): string
    {
        return $this->nextTime;
    }

    /**
     * @throws \Exception
     */
    public function setNextTime(): void
    {
        try {
            $this->nextTime = $this->cron->getNextRunDate()->format("Y-m-d H:i:s");
        } catch (\Exception) {
            throw new \Exception("Invalid cron expression");
        }
    }

    public function isValidate(): bool
    {
        return $this->cron->isDue() && $this->getCurrenTime() == $this->getNextTime();
    }

    private function getCommand(): string
    {
        return $this->command;
    }

    public function executeCommand(): void
    {
        $command = $this->getCommand();
        if ($this->type === CmdType::CONSOLE) {
            Server::getInstance()->getCommandMap()->dispatch(new ConsoleCommandSender(
                Server::getInstance(),
                Server::getInstance()->getLanguage()
            ), $command);
        }
        if ($this->type === CmdType::SHELL) {
            shell_exec($command);
        }
        if ($this->type === CmdType::SCRIPT) {
            $realPath = Loader::getInstance()->getScriptPath($command);
            $path = tempnam(sys_get_temp_dir(), "pmscript") . ".0";
            if(!@copy($realPath, $path)){
                Server::getInstance()->getLogger()->error("Failed to copy script $realPath to $path");
            }
            try{
                ob_start();
                include $path;
                $output = ob_get_clean();
                if($output !== false && trim($output) !== ""){
                    echo "--- Script output ---\n"
                    . $output
                    . "\n--- End of script output ---\n";
                } else{
                    echo "Script $realPath executed successfully\n";
                }
            }catch(\Throwable $e){
                ob_end_flush();
                Server::getInstance()->getLogger()->logException($e);
                return;
            }finally{
                @unlink($path);
            }
        }
    }
}