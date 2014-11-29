<?php
namespace Rocketeer\Satellite\Abstracts;

use Illuminate\Console\Command;
use Rocketeer\Satellite\Services\Applications\ApplicationsManager;
use Symfony\Component\Console\Input\InputArgument;

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
		$this->laravel['rocketeer.rocketeer']->setLocal(true);

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
}
