<h1>CmdScheduler<img src="icon.png" height="64" width="64" align="left"></img></h1><br/>

[![Lint](https://poggit.pmmp.io/ci.shield/Taylor-pm-pl/CmdScheduler/CmdScheduler)](https://poggit.pmmp.io/ci/Taylor-pm-pl/CmdScheduler/CmdScheduler)
[![Discord](https://img.shields.io/discord/1100650029573738508.svg?label=&logo=discord&logoColor=ffffff&color=7389D8&labelColor=6A7EC2)](https://discord.gg/yAhsgskaGy)

**CmdScheduler** is a plugin for PocketMine-MP 5, It performs processing of CRON expressions when due will execute 1 scheduled instruction.


## Why CmdScheduler ?
- CmdScheduler helps create a specific schedule in an easy to understand way such as: every minute, hour, day, week, month, ... to execute the command.
- In addition, CmdScheduler can also execute 3 types of commands: ConsoleCommand, Shell and Script.

## Features
- [x] CRON expressions
- [x] Execute command: Console, Shell, Script

## CRON Expressions

A CRON expression is a string representing the schedule for a particular command to execute.  The parts of a CRON schedule are as follows:

    *    *    *    *    *
    -    -    -    -    -
    |    |    |    |    |
    |    |    |    |    |
    |    |    |    |    +----- day of week (0 - 7) (Sunday=0 or 7)
    |    |    |    +---------- month (1 - 12)
    |    |    +--------------- day of month (1 - 31)
    |    +-------------------- hour (0 - 23)
    +------------------------- min (0 - 59)

This library also supports a few macros:

* `@yearly`, `@annually` - Run once a year, midnight, Jan. 1 - `0 0 1 1 *`
* `@monthly` - Run once a month, midnight, first of month - `0 0 1 * *`
* `@weekly` - Run once a week, midnight on Sun - `0 0 * * 0`
* `@daily`, `@midnight` - Run once a day, midnight - `0 0 * * *`
* `@hourly` - Run once an hour, first minute - `0 * * * *`

## Contact

If you have any questions you can contact me on Discord (Taylor#1837) or on [my Discord server](https://discord.gg/yAhsgskaGy).