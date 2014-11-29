<?php
namespace Rocketeer\Satellite\Services\Applications;

use Illuminate\Support\Collection;
use Illuminate\Support\Fluent;
use SplFileInfo;

/**
 * An application on the server
 *
 * @property string                   $name
 * @property string                   $path
 * @property array                    $configuration
 * @property Collection|SplFileInfo[] $releases
 * @property \DateTime                $current
 * @author Maxime Fabre <ehtnam6@gmail.com>
 */
class Application extends Fluent
{
	// ...
}
