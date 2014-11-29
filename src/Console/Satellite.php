<?php
namespace Rocketeer\Satellite\Console;

use Illuminate\Console\Application;
use Illuminate\Container\Container;
use Rocketeer\Satellite\SatelliteServiceProvider;

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
		$provider = new SatelliteServiceProvider($app);
		$provider->register();

		// Register services
		$this->laravel = $app;

		// Add commands
		$this->resolveCommands(array(
			'Rocketeer\Satellite\Console\Commands\Setup',
			'Rocketeer\Satellite\Console\Commands\ListApplications',
			'Rocketeer\Satellite\Console\Commands\Deploy',
		));
	}
}
