<?php
namespace Rocketeer\Satellite\Abstracts;

use Illuminate\Console\Command;
use Rocketeer\Satellite\Services\Applications\ApplicationsManager;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\StreamOutput;

class AbstractRocketeerCallerCommand extends Command
{
    /**
     * @type ApplicationsManager
     */
    protected $apps;

    /**
     * @param ApplicationsManager $apps
     */
    public function __construct(ApplicationsManager $apps)
    {
        parent::__construct();

        $this->apps = $apps;
    }

    /**
     * Call a Rocketeer command
     *
     * @param string $command
     */
    public function callRocketeerCommand($command)
    {
        // Get application
        $app = $this->apps->getApplication($this->argument('app'));

        // Swap out Rocketeer's configuration
        foreach ($app->configuration as $key => $value) {
            $this->laravel['config']->set('rocketeer::'.$key, $value);
        }

        // Set local mode
        $this->laravel['path.base'] = $app->paths['current'];
        $this->laravel['rocketeer.rocketeer']->setLocal(true);

        // Create stream output
        $this->output = $this->getStreamOutput($app);

        // Call the deploy command
        $rocketeer = $this->laravel['rocketeer.console'];
        $rocketeer->call($command, [], $this->output);
    }

    /**
     * @return array
     */
    protected function getArguments()
    {
        return array(
            ['app', InputArgument::REQUIRED, 'The application to deploy'],
        );
    }

    //////////////////////////////////////////////////////////////////////
    ////////////////////////////// HELPERS ///////////////////////////////
    //////////////////////////////////////////////////////////////////////

    /**
     * Get the stream output for the current command
     *
     * @param \Rocketeer\Satellite\Services\Applications\Application $app
     *
     * @return StreamOutput
     */
    protected function getStreamOutput($app)
    {
        // Get the logs folder
        $folder = $this->laravel['satellite.paths']->getLogsFolder($app->name);
        if (!is_dir($folder)) {
            $this->laravel['files']->makeDirectory($folder, 0755, true);
        }

        // Compute file path
        $file = $folder.DS.strftime('%Y-%m-%d').'.txt';

        return new StreamOutput(fopen($file, 'a', false));
    }
}
