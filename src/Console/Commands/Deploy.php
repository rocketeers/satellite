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
		$app = $this->apps->getApplication($this->argument('app'));
		!dd($app);
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
