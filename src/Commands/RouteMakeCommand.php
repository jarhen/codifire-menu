<?php

namespace Jarhen\Modules\Commands;

use Jarhen\Modules\Support\Config\GenerateConfigReader;
use Jarhen\Modules\Support\Stub;
use Jarhen\Modules\Traits\ModuleCommandTrait;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class RouteMakeCommand extends GeneratorCommand
{
    use ModuleCommandTrait;

    protected $argumentName = 'routes';

    /**
     * The command name.
     *
     * @var string
     */
    protected $name = 'module:route';

    /**
     * The command description.
     *
     * @var string
     */
    protected $description = 'Create a new route service provider for the specified module.';

    /**
     * The command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['module', InputArgument::OPTIONAL, 'The name of module will be used.'],
			['routes', InputArgument::OPTIONAL, 'The name of module will be used.'],
        ];
    }

    /**
     * Get template contents.
     *
     * @return string
     */
    protected function getTemplateContents()
    {
        $module = $this->laravel['modules']->findOrFail($this->getModuleName());

        return (new Stub('/routes.stub', [
            'CLASS'             => $this->getFileName(),
			'LOWER_NAME'        => $module->getLowerName(),
			'STUDLY_NAME'       => $module->getStudlyName(),
            'MODULE_NAMESPACE'	=> 'Modules',
			'ID'				=> strtolower($this->option('setsingular'))."_id",
			'CONTROLLERNAME'	=>  ucfirst($this->option('setsingular'))."Controller",
            'MODULE'          	=> $this->getModuleName(),
        ]))->render();
    }

    /**
     * @return string
     */
    private function getFileName()
    {
        return 'routes';
    }
	
    /**
     * Get the destination file path.
     *
     * @return string
     */
    protected function getDestinationFilePath()
    {
        $path = $this->laravel['modules']->getModulePath($this->getModuleName());

        $generatorPath = GenerateConfigReader::read('routes');

        return $path . $generatorPath->getPath() . '/Routes/' . $this->getFileName() . '.php';
    }

    /**
     * @return mixed
     */
	 protected function getOptions()
    {
        return [
			['setsingular', null, InputOption::VALUE_OPTIONAL, ' set singular name.', null],
			
        ];
    }
}
