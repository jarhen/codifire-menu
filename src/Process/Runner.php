<?php

namespace Jarhen\Modules\Process;

use Jarhen\Modules\Contracts\RunableInterface;
use Jarhen\Modules\Repository;

class Runner implements RunableInterface
{
    /**
     * The module instance.
     *
     * @var \Jarhen\Modules\Repository
     */
    protected $module;

    /**
     * The constructor.
     *
     * @param \Jarhen\Modules\Repository $module
     */
    public function __construct(Repository $module)
    {
        $this->module = $module;
    }

    /**
     * Run the given command.
     *
     * @param string $command
     */
    public function run($command)
    {
        passthru($command);
    }
}
