<?php
namespace Rocketeer\Satellite\Console\Commands;

use Illuminate\Console\Command;
use Rocketeer\Satellite\Abstracts\AbstractRocketeerCallerCommand;
use Rocketeer\Satellite\Services\Applications\ApplicationsManager;
use Symfony\Component\Console\Input\InputArgument;

class Deploy extends AbstractRocketeerCallerCommand
{
	/**
	 * @type string
	 */
	protected $name = 'deploy';

	/**
	 * @type string
	 */
	protected $description = 'Create a new release of an application';

	/**
	 * Fire the command
	 */
	public function fire()
	{
		return $this->callRocketeerCommand('deploy');
	}
}
