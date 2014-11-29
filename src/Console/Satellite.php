<?php
namespace Rocketeer\Satellite\Console;

use Illuminate\Console\Application;

class Satellite extends Application
{
	/**
	 * Setup the application
	 */
	public function __construct()
	{
		parent::__construct('Satellite', '0.1.0');
	}
}
