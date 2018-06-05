<?php

namespace Jarhen\Modules\Commands;

use Jarhen\Modules\Support\Config\GenerateConfigReader;
use Jarhen\Modules\Support\Stub;
use Jarhen\Modules\Traits\ModuleCommandTrait;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class scriptMakeCommand extends GeneratorCommand
{
    use ModuleCommandTrait;

    /**
     * The name of argument being used.
     *
     * @var string
     */
    protected $argumentName = 'script';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'module:make-script';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate script for the specified module.';

    /**
     * Get view name.
     *
     * @return string
     */
    public function getDestinationFilePath()
    {
        $path = $this->laravel['modules']->getModulePath($this->getModuleName());
		$module = $this->laravel['modules']->findOrFail($this->getModuleName());
        $viewPath = GenerateConfigReader::read('assets');

        return $path . $viewPath->getPath() . '/js/'.strtolower($module->getStudlyName()).'_script.js';
    }

    /**
     * @return string
     */
    protected function getTemplateContents()
    {
        $module = $this->laravel['modules']->findOrFail($this->getModuleName());
        return (new Stub($this->getStubName(), [
            'MODULENAME'        => $module->getStudlyName(),
            'viewNAME'    => $this->getviewName(),
            'NAMESPACE'         => $module->getStudlyName(),
            'CLASS_NAMESPACE'   => $this->getClassNamespace($module),
            'CLASS'             => $this->getviewName(),
            'LOWER_NAME'        => $module->getLowerName(),
            'MODULE'            => $this->getModuleName(),
            'NAME'              => $this->getModuleName(),
            'STUDLY_NAME'       => $module->getStudlyName(),
            'MODULE_NAMESPACE'  => $this->laravel['modules']->config('namespace'),
			'SETDATATABLES'  	=> $this->setcolumns(),
			'SETCOUNT'			=> $this->setcount(),
			'ID'				=> strtolower($this->option('setsingular'))."_id",
        ]))->render();
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
	protected function setcolumns(){
	$module = $this->laravel['modules']->findOrFail($this->getModuleName());
	$options 	=  $this->option('setdatatables');
		$string ="";
		foreach ($options as $key) {
			$string .= "{ data: '".strtolower($key)."', name: '".strtolower($key)."' },\n\t\t\t";
		}
		return $string;

	}
	protected function setcount(){
	$options 	=  $this->option('setdatatables');
		$string = array();
		$count = 0;
		foreach ($options as $key) {
			$count++;
		}
	
		return $count + 2;

	}
	

    protected function getArguments()
    {
        return [
            ['script', InputArgument::REQUIRED, 'The name of the view class.'],
            ['module', InputArgument::OPTIONAL, 'The name of module will be used.'],
			
        ];
    }

    /**
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['plain', 'p', InputOption::VALUE_NONE, 'Generate a plain view', null],
			['setdatatables', null, InputOption::VALUE_OPTIONAL, ' Generate datatable script.', null],
			['setsingular', null, InputOption::VALUE_OPTIONAL, ' set singular name.', null],
        ];
    }

    /**
     * @return array|string
     */
    protected function getviewName()
    {
        $view = studly_case($this->argument('script'));
		
        if (str_contains(strtolower($view), 'script') === false) {
            $view .= 'script';
        }
	
        return $view;
    }

    public function getDefaultNamespace() : string
    {
        return $this->laravel['modules']->config('paths.generator.view.path', 'Http/views');
    }

    /**
     * Get the stub file name based on the plain option
     * @return string
     */
    private function getStubName()
    {
        if ($this->option('plain') === true) {
            return '/script-plain.stub';
        }

        return '/script.stub';
    }
}
