<?php
namespace Rocketeer\Satellite\Services\Applications;

use DateTime;
use Illuminate\Filesystem\Filesystem;
use Rocketeer\Satellite\Services\Pathfinder;

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

		foreach ($apps as $key => $app) {
			$apps[$key] = new Application(array(
				'name'    => basename($app),
				'path'    => $app,
				'current' => $this->getCurrentRelease($app),
			));
		}

		return $apps;
	}

	/**
	 * Get the current release of an application
	 *
	 * @param string $app
	 *
	 * @return DateTime
	 */
	protected function getCurrentRelease($app)
	{
		$releases = $this->files->directories($app.DS.'releases');
		$current  = end($releases);
		$current  = basename($current);

		return DateTime::createFromFormat('YmdHis', $current);
	}
}
