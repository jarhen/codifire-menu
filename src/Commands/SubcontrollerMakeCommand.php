<?php

namespace Jarhen\Modules\Commands;

use Jarhen\Modules\Support\Config\GenerateConfigReader;
use Jarhen\Modules\Support\Stub;
use Jarhen\Modules\Traits\ModuleCommandTrait;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class SubcontrollerMakeCommand extends GeneratorCommand
{
    use ModuleCommandTrait;

    /**
     * The name of argument being used.
     *
     * @var string
     */ 
    protected $argumentName = 'controller';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'module:make-subcontroller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate new restful subcontroller for the specified module.';

    /**
     * Get controller name.
     *
     * @return string
     */
    public function getDestinationFilePath()
    {
        $path = $this->laravel['modules']->getModulePath($this->getModuleName());

        $controllerPath = GenerateConfigReader::read('controller');

        return $path . $controllerPath->getPath() . '/' . $this->getControllerName() . '.php';
    }

    /**
     * @return string
     */
    protected function getTemplateContents()
    {
        $module = $this->laravel['modules']->findOrFail($this->getModuleName());
			

        return (new Stub($this->getStubName(), [
            'MODULENAME'        => strtolower($module->getStudlyName()),
            'CONTROLLERNAME'    => $this->getControllerName(),
            'NAMESPACE'         => $module->getStudlyName(),
            'CLASS_NAMESPACE'   => $module->getStudlyName(),
            'CLASS'             => $this->getControllerName(),
            'LOWER_NAME'        => strtolower($this->getsubmoduleName()),
			'SINGULAR_NAME'     => ucfirst(str_singular($this->getsubmoduleName())),
			'LOWERCASE_NAME'     => str_singular($this->getsubmoduleName()),
            'MODULE'            => $this->getModuleName(),
            'NAME'              => $this->getModuleName(),
            'STUDLY_NAME'       => $module->getStudlyName(),
            'MODULE_NAMESPACE'  => $this->laravel['modules']->config('namespace'),
			'SETVALIDATIONS'  	=> $this->setvalidations(),
			'SETFIELDS'  		=> $this->setfields(),
			'SETFIELDUPDATE'  	=> $this->setupdates(),	
			'SETDATATABLES'  	=> $this->setcolumns(),
			'SETUC'  	=> ucfirst($this->getsubmoduleName()),
			'SETUCP'  	=> ucfirst(str_plural($this->getsubmoduleName())),
			'TABLENAME'  	=> strtolower(str_plural($this->getsubmoduleName())),
			'VIEWNAME'  	=> strtolower(str_plural($this->getsubmoduleName())),
			'MODELNAME'  	=> strtolower(str_plural($this->getsubmoduleName())),
			
			
        ]))->render();
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
	protected function setvalidations()
	{
	$validation =  $this->option('setvalidations');
		$options	= $this->option('setfields');
		$string ="";
		foreach ($options as $index => $key ) {
			$string .= "'".$key."' => '".$validation[$index]."',\n\t\t\t";
			
		}
		return $string;
		
	}
	protected function setcolumns(){
	$options 	=  $this->option('setvalidations');
		$string ="";
		foreach ($options as $key) {
			$string .= "{ data: '".$key."', name: '".$key."' },\n\t\t\t";
		}
	
		return $string;
		
	}
	protected function setupdates()
	{
		$module = $this->laravel['modules']->findOrFail($this->getModuleName());
		$options 	=  $this->option('setupdates');
		$string ="";
		foreach ($options as $key) {
			$string .=  "$".$this->getsubmoduleName()."->".$key.' = $request->'.$key .";\n\t\t";
		}

		return $string;

	}
	protected function setfields()
	{

		$module = $this->laravel['modules']->findOrFail($this->getModuleName());
		$options 	=  $this->option('setfields');
		$string ="";
		foreach ($options as $key) {
			$string .=  "'".$key."' => ".'$request->'.$key.",\n\t\t\t";
		}

		return $string;
		
	}

    protected function getArguments()
    {
        return [
			['controller', InputArgument::REQUIRED, 'The name of the controller class.'],
            ['module', InputArgument::OPTIONAL, 'The name of module will be used.'],
			
        ];
    }

    /**
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['plain', 'p', InputOption::VALUE_NONE, 'Generate a plain controller', null],
			['setvalidations', null, InputOption::VALUE_OPTIONAL, ' Validation rules for the fields.', null],
			['setupdates', null, InputOption::VALUE_OPTIONAL, ' set fields for Update.', null],	
			['setfields', null, InputOption::VALUE_OPTIONAL, ' set fields for input.', null],
			
        ];
    }

    /**
     * @return array|string
     */
    protected function getControllerName()
    {
        $controller = studly_case($this->argument('controller'));
        
        if (str_contains(strtolower($controller), 'controller') === false) {
            $controller .= 'Controller';
        }

        return $controller;
    }
	  protected function getsubmoduleName()
    {
        $name = strtolower(studly_case($this->argument('controller')));
        return $name;
    }

    // public function getDefaultNamespace() : string
    // {
    //     return $this->laravel['modules']->config('paths.generator.controller.path', 'Http/Controllers');
    // }

    /**
     * Get the stub file name based on the plain option
     * @return string
     */
    private function getStubName()
    {
        if ($this->option('plain') === true) {
            return '/controller-plain.stub';
        }

        return '/subcontroller.stub';
    }
}
