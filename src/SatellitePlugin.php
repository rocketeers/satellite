<?php
namespace Rocketeer\Satellite;

use Rocketeer\Abstracts\AbstractPlugin;
use Rocketeer\Console\Console;
use Rocketeer\Satellite\Console\Commands\TailCommand;

class SatellitePlugin extends AbstractPlugin
{
    /**
     * Register additional commands
     *
     * @param Console $console
     */
    public function onConsole(Console $console)
    {
        $console->add(new TailCommand());
    }
}
