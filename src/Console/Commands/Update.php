<?php
namespace Rocketeer\Satellite\Console\Commands;

use Illuminate\Console\Command;
use Rocketeer\Satellite\Abstracts\AbstractRocketeerCallerCommand;
use Rocketeer\Satellite\Services\Applications\ApplicationsManager;
use Symfony\Component\Console\Input\InputArgument;

class Update extends AbstractRocketeerCallerCommand
{
	/**
	 * @type string
	 */
	protected $name = 'update';

	/**
	 * @type string
	 */
	protected $description = 'Update the current release of an application';

	/**
	 * Fire the command
	 */
	public function fire()
	{
		return $this->callRocketeerCommand('update');
	}
}
