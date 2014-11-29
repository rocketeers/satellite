<?php
namespace Rocketeer\Satellite\Console\Compilation;

use Rocketeer\Console\Compilation\Compiler;

class SatelliteCompiler
{
	/**
	 * @type Compiler
	 */
	protected $compiler;

	/**
	 * Build a new Satellite PHAR compiler
	 */
	public function __construct()
	{
		$this->compiler = new Compiler(__DIR__.'/../../../bin', 'satellite', array(
			'd11wtq',
			'herrera-io',
			'phine',
		));
	}

	/**
	 * Delegate calls to the Compiler
	 *
	 * @param string $name
	 * @param array  $arguments
	 *
	 * @return mixed
	 */
	public function __call($name, $arguments)
	{
		return call_user_func_array([$this->compiler, $name], $arguments);
	}
}
