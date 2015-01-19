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
     * Get the path to Satellite's configuration
     *
	 * @return string
	 */
	public function getConfigurationFile()
	{
		return $this->getSatelliteFolder().DS.'config.yml';
	}

    /**
     * Get the place where the logs of an application would be
     *
     * @param string|null $application
     *
     * @return string
     */
    public function getLogsFolder($application = null)
    {
        $folder = $this->getSatelliteFolder().DS.'logs';
        if ($application) {
            $folder .= DS.$application;
        }

        return $folder;
    }

	/**
     * Get the path were applications are on the server
     *
	 * @return string
	 */
	public function getApplicationsFolder()
	{
		return $this->config->get('satellite.apps_folder');
	}

	/**
	 * Get the path of an application
	 *
	 * @param string $app
	 *
	 * @return string
	 */
	public function getApplicationFolder($app)
	{
		return $this->getApplicationsFolder().DS.$app;
	}
}
