<?php
namespace Rocketeer\Satellite\Console\Commands;

use Illuminate\Console\Command;
use Rocketeer\Abstracts\AbstractCommand;
use Symfony\Component\Console\Input\InputArgument;

class TailCommand extends AbstractCommand
{
    /**
     * @type string
     */
    protected $name = 'satellite:tail';

    /**
     * @type string
     */
    protected $description = 'Tail a deployment running on a server';

    /**
     * Fire the command
     */
    public function fire()
    {
        $this->laravel->instance('rocketeer.command', $this);

        // Set connection if needed
        if ($connection = $this->argument('connection')) {
            $this->laravel['rocketeer.connections']->setConnection($connection);
        }

        // Get filename
        $app  = $this->laravel['rocketeer.rocketeer']->getApplicationName();
        $file = sprintf('~/.satellite/logs/%s/%s.txt', $app, strftime('%Y-%m-%d'));

        $this->laravel['rocketeer.bash']->tail($file);
    }

    /**
     * @return array
     */
    protected function getArguments()
    {
        return array(
            ['connection', InputArgument::OPTIONAL, 'The connection to tail'],
        );
    }
}
