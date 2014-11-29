<?php
namespace Rocketeer\Satellite\Services;

class Pathfinder extends \Rocketeer\Services\Pathfinder
{
	/**
	 * Get the satellite folder
	 *
	 * @return string
	 */
	public function getSatelliteFolder()
	{
		$folder = $this->getUserHomeFolder();
		$folder = $folder.DS.'.satellite';

		return $folder;
	}

	/**
	 * @return string
	 */
	public function getConfigurationFile()
	{
		return $this->getSatelliteFolder().DS.'config.yml';
	}

	/**
	 * @return string
	 */
	public function getApplicationsFolder()
	{
		return $this->config->get('satellite.apps_folder');
	}
}
