<?php
namespace Rocketeer\Satellite\Console\Commands;

use Illuminate\Console\Command;
use Rocketeer\Satellite\Services\Applications\ApplicationsManager;
use Symfony\Component\Console\Input\InputArgument;

class Deploy extends Command
{
	/**
	 * @type string
	 */
	protected $name = 'deploy';

	/**
	 * @type string
	 */
	protected $description = 'Create a new release of an application';

	/**
	 * @type
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
	 * Fire the command
	 */
	public function fire()
	{
		// Get application
		$app = $this->apps->getApplication($this->argument('app'));

		// Swap out Rocketeer's configuration
		foreach ($app->configuration as $key => $value) {
			$this->laravel['config']->set('rocketeer::'.$key, $value);
		}

		$this->laravel['rocketeer.rocketeer']->setLocal(true);

		// Call the deploy command
		$rocketeer = $this->laravel['rocketeer.console'];
		$rocketeer->call('deploy', [], $this->output);
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
