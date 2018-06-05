<?php

namespace Jarhen\Modules\Commands;

use Jarhen\Modules\Support\Config\GenerateConfigReader;
use Jarhen\Modules\Support\Stub;
use Jarhen\Modules\Traits\ModuleCommandTrait;
use Symfony\Component\Console\Input\InputArgument;

class EventMakeCommand extends GeneratorCommand
{
    use ModuleCommandTrait;

    protected $argumentName = 'name';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'module:make-event';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new event class for the specified module';

    public function getTemplateContents()
    {
        $module = $this->laravel['modules']->findOrFail($this->getModuleName());

        return (new Stub('/event.stub', [
            'NAMESPACE' => $this->getClassNamespace($module),
            'CLASS' => $this->getClass(),
        ]))->render();
    }

    public function getDestinationFilePath()
    {
        $path       = $this->laravel['modules']->getModulePath($this->getModuleName());

        $eventPath = GenerateConfigReader::read('event');

        return $path . $eventPath->getPath() . '/' . $this->getFileName() . '.php';
    }

    /**
     * @return string
     */
    protected function getFileName()
    {
        return studly_case($this->argument('name'));
    }

    public function getDefaultNamespace() : string
    {
        return $this->laravel['modules']->config('paths.generator.event.path', 'Events');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the event.'],
            ['module', InputArgument::OPTIONAL, 'The name of module will be used.'],
        ];
    }
}