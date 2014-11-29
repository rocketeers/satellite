<?php
namespace Rocketeer\Satellite\Console\Commands;

use Illuminate\Console\Command;
use Rocketeer\Satellite\Services\Pathfinder;
use Symfony\Component\Yaml\Yaml;

/**
 * Setup Satellite
 *
 * @author Maxime Fabre <ehtnam6@gmail.com>
 */
class Setup extends Command
{
	/**
	 * @type string
	 */
	protected $name = 'setup';

	/**
	 * @type string
	 */
	protected $description = 'Setup Satellite on the server';

	/**
	 * @type Pathfinder
	 */
	protected $pathfinder;

	/**
	 * @param Pathfinder $pathfinder
	 */
	public function __construct(Pathfinder $pathfinder)
	{
		parent::__construct();

		$this->pathfinder = $pathfinder;
	}

	/**
	 * Execute the command
	 */
	public function fire()
	{
		if (is_dir($this->pathfinder->getSatelliteFolder())) {
			return $this->comment('Satellite is already setup');
		}

		$this->createSatelliteFolder();
		$this->createConfiguration();
	}

	/**
	 * Create the Satellite folder
	 */
	protected function createSatelliteFolder()
	{
		$home = $this->pathfinder->getSatelliteFolder();

		if (!file_exists($home)) {
			$this->laravel['files']->makeDirectory($home);
			$this->comment('Created folder '.$home);
		}
	}

	/**
	 * Create the configuration on the server
	 */
	protected function createConfiguration()
	{
		// Create configuration array
		$applications  = $this->ask('Where are your applications on the server? (absolute path)');
		$configuration = Yaml::dump(array(
			'apps_folder' => $applications,
		));

		// Save in folder
		$file = $this->pathfinder->getConfigurationFile();
		$this->laravel['files']->put($file, $configuration);
	}
}
