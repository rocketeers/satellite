<?php
namespace Rocketeer\Satellite\Console;

use Illuminate\Console\Application;
use Illuminate\Container\Container;
use Rocketeer\RocketeerServiceProvider;
use Symfony\Component\Yaml\Yaml;

class Satellite extends Application
{
	/**
	 * Setup the application
	 */
	public function __construct()
	{
		parent::__construct('Satellite', '0.1.0');

		// Setup application's dependencies
		$app      = new Container();
		$provider = new RocketeerServiceProvider($app);
		$provider->register();
		$provider->boot();

		// Register services
		$app->singleton('satellite.paths', 'Rocketeer\Satellite\Services\Pathfinder');

		// Load configuration
		$configuration = $app['satellite.paths']->getConfigurationFile();
		$configuration = Yaml::parse($configuration);
		$app['config']->set('satellite', $configuration);

		$app->instance('Illuminate\Container\Container', $app);

		$this->laravel = $app;
	}
}
