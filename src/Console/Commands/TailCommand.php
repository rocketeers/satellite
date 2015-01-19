<?php
namespace Rocketeer\Satellite\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class TailCommand extends Command
{
    /**
     * @type string
     */
    protected $name = 'tail';

    /**
     * @type string
     */
    protected $description = 'Tail a deployment running on a server';

    /**
     * Fire the command
     */
    public function fire()
    {
        // Set connection if needed
        if ($connection = $this->argument('connection')) {
            $this->laravel['rocketeer.connections']->setConnection($connection);
        }

        // Get filename
        $app  = $this->laravel['rocketeer.rocketeer']->getApplicationName();
        $file = sprintf('~/.satellite/logs/%s/%s.txt', $app, strftime('%Y-%m-%d'));
        if (!$this->laravel['rocketeer.bash']->fileExists($file)) {
            return $this->error('There is no deployment running for this application');
        }

        $this->laravel['rocketeer.bash']->tail('~/.satellite/config.yml');
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
