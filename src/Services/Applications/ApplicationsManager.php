<?php
namespace Rocketeer\Satellite\Services\Applications;

use DateTime;
use Illuminate\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Rocketeer\Satellite\Services\Pathfinder;
use SplFileInfo;
use Symfony\Component\Finder\Finder;

class ApplicationsManager
{
	/**
	 * @type Pathfinder
	 */
	protected $pathfinder;

	/**
	 * @type Filesystem
	 */
	protected $files;

	/**
	 * @param Pathfinder $pathfinder
	 * @param Filesystem $files
	 */
	public function __construct(Pathfinder $pathfinder, Filesystem $files)
	{
		$this->pathfinder = $pathfinder;
		$this->files      = $files;
	}

	/**
	 * List available applications
	 *
	 * @return Application[]
	 */
	public function getApplications()
	{
		$folder = $this->pathfinder->getApplicationsFolder();
		$apps   = $this->files->directories($folder);
		$apps   = array_map('basename', $apps);

		foreach ($apps as $key => $app) {
			// Skip apps that aren't yet setup
			if (!file_exists($folder.DS.$app.DS.'releases')) {
				continue;
			}

			$apps[$key] = $this->getApplication($app);
		}

		return $apps;
	}

	//////////////////////////////////////////////////////////////////////
	///////////////////////////// APPLICATION ////////////////////////////
	//////////////////////////////////////////////////////////////////////

	/**
	 * Get an application
	 *
	 * @param string $app
	 *
	 * @return Application
	 */
	public function getApplication($app)
	{
		$app = new Application(array(
			'name' => $app,
			'path' => $this->pathfinder->getApplicationFolder($app),
		));

		// Set paths
		$app->paths = array(
			'current'  => $app->path.DS.'current',
			'releases' => $app->path.DS.'releases',
			'shared'   => $app->path.DS.'shared',
		);

		// Set extra informations
		$app->releases      = $this->getReleases($app);
		$app->current       = $this->getCurrentRelease($app);
		$app->configuration = $this->getApplicationConfiguration($app);

		return $app;
	}

	/**
	 * Get the application's releases
	 *
	 * @param Application $app
	 *
	 * @return Collection
	 */
	public function getReleases(Application $app)
	{
		$releases = $this->files->directories($app->paths['releases']);
		foreach ($releases as $key => $release) {
			$releases[$key] = new SplFileInfo($release);
		}

		return new Collection($releases);
	}

	/**
	 * Get the current release of an application
	 *
	 * @param Application $app
	 *
	 * @return DateTime
	 */
	public function getCurrentRelease(Application $app)
	{
		/** @type SplFileInfo $current */
		$current = $app->releases->last();
		if (!is_object($current)) {
			return;
		}

		return DateTime::createFromFormat('YmdHis', $current->getBasename());
	}

	/**
	 * Get the configuration of an application
	 *
	 * @param Application $app
	 *
	 * @return array
	 * @throws FileNotFoundException
	 */
	public function getApplicationConfiguration(Application $app)
	{
		$folder = $app->paths['current'].DS.'.rocketeer';
		if (!file_exists($folder)) {
			return [];
		}

		/** @type SplFileInfo[] $files */
		$files         = (new Finder())->files()->in($folder);
		$configuration = [];
		foreach ($files as $file) {
			if ($file->getExtension() !== 'php' || $file->getBasename() == 'tasks.php') {
				continue;
			}

			// Get configuration
			$key      = $file->getBasename('.php');
			$contents = include $file->getPathname();

			$configuration[$key] = $contents;
		}

		return $configuration;
	}
}
