<?php

namespace Jarhen\Modules\Commands;

use Illuminate\Console\Command;
use Jarhen\Modules\Generators\ModuleGenerator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ModuleMakeCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'module:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new module.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
		if(is_array($name)){
             $names = $name;
		}else{
			 $names = array($name);
		}
		

        foreach ($names as $name) { 
            with(new ModuleGenerator($name))
                ->setFilesystem($this->laravel['files'])
                ->setModule($this->laravel['modules'])
                ->setConfig($this->laravel['config'])
                ->setConsole($this)
			    // ->setvalidations($this->option('setvalidations'))
				// ->setfields($this->option('setfields'))
				// ->setfieldupdate(array($this->option('setfieldupdate')))
                ->setForce($this->option('force'))
                ->setPlain($this->option('plain'))
                ->generate();
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::IS_ARRAY, 'The names of modules will be created.'],
		
        ];
    }

    protected function getOptions()
    {
        return [
            ['plain', 'p', InputOption::VALUE_NONE, 'Generate a plain module (without some resources).'],
            ['force', null, InputOption::VALUE_NONE, 'Force the operation to run when module already exist.'],
			// ['setvalidations', null, InputOption::VALUE_OPTIONAL, ' Validation rules for the fields.', null],
			// ['setfields', null, InputOption::VALUE_OPTIONAL, ' Create Fields for input.', null],
			// ['setfieldupdate', null, InputOption::VALUE_OPTIONAL, ' Create Fields for update.', null],
 
        ];
    }
}
