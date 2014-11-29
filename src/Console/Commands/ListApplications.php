<?php
namespace Rocketeer\Satellite\Console\Commands;

use Illuminate\Console\Command;
use Rocketeer\Satellite\Services\Applications\ApplicationsManager;
use Symfony\Component\Console\Helper\Table;

class ListApplications extends Command
{
	/**
	 * @type string
	 */
	protected $name = 'apps';

	/**
	 * @type string
	 */
	protected $description = 'List the applications on the server';

	/**
	 * @type ApplicationsManager
	 */
	protected $apps;

	/**
	 * @param ApplicationsManager $apps
	 */
	public function __construct(ApplicationsManager $apps)
	{
		parent::__construct();

		$this->apps = $apps;
	}

	/**
	 * Execute the command
	 */
	public function fire()
	{
		$apps = $this->apps->getApplications();

		// Render applications table
		$table = new Table($this->getOutput());
		$table->setHeaders(['Application', 'Number of releases', 'Latest release']);
		foreach ($apps as $app) {
			$table->addRow([$app->name, $app->releases->count(), $app->current->format('Y-m-d H:i:s')]);
		}

		$table->render();
	}
}
