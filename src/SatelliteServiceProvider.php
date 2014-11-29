<?php
namespace Rocketeer\Satellite;

use Illuminate\Support\ServiceProvider;
use Rocketeer\RocketeerServiceProvider;
use Symfony\Component\Yaml\Yaml;

class SatelliteServiceProvider extends ServiceProvider
{
	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		// Load Rocketeer
		$provider = new RocketeerServiceProvider($this->app);
		$provider->register();
		$provider->boot();

		// Load Satellite
		$this->registerServices();
		$this->loadConfiguration();

		// Bind container unto itself
		$this->app->instance('Illuminate\Container\Container', $this->app);
	}

	/**
	 * Register Satellite's services
	 */
	protected function registerServices()
	{
		$this->app->singleton('satellite.paths', 'Rocketeer\Satellite\Services\Pathfinder');
	}

	/**
	 * Load the on-server configuration
	 */
	protected function loadConfiguration()
	{
		$configuration = $this->app['satellite.paths']->getConfigurationFile();
		if (!file_exists($configuration)) {
			return;
		}

		$configuration = Yaml::parse($configuration);
		$this->app['config']->set('satellite', $configuration);
	}
}
