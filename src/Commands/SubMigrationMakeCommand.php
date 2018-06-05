<?php

namespace Jarhen\Modules\Commands;

use Illuminate\Support\Str;
use Jarhen\Modules\Support\Config\GenerateConfigReader;
use Jarhen\Modules\Support\Migrations\NameParser;
use Jarhen\Modules\Support\Migrations\SchemaParser;
use Jarhen\Modules\Support\Stub;
use Jarhen\Modules\Traits\ModuleCommandTrait;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class SubMigrationMakeCommand extends GeneratorCommand
{
    use ModuleCommandTrait;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'module:make-submigration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new migration for the specified module.';

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The migration name will be created.'],
			['column', InputArgument::REQUIRED, 'The migration name will be created.'],
            ['module', InputArgument::OPTIONAL, 'The name of module will be created.'],
			
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['fields', null, InputOption::VALUE_OPTIONAL, 'The specified fields table.', null],
			['submodule', null, InputOption::VALUE_OPTIONAL, 'The specified fields table.', null],
            ['plain', null, InputOption::VALUE_NONE, 'Create plain migration.'],
        ];
    }

    /**
     * Get schema parser.
     *
     * @return SchemaParser
     */
    public function getSchemaParser()
    {
        return new SchemaParser($this->option('fields'));
    }

    /**
     * @throws \InvalidArgumentException
     *
     * @return mixed
     */
    protected function getTemplateContents()
    {
        $parser = new NameParser($this->argument('name'));
		// dd($this->option('fields'));
         
        if ($parser->isCreate()) {
            return Stub::create('/migration/subcreate.stub', [
				'table_uc' => ucfirst(str_singular($this->option('submodule'))),
				'table_ucp' => ucfirst($this->option('submodule')),
                'class' => $this->getClass(),
                'table' => strtolower($parser->getTableName()),
				'table_lc' =>strtolower($this->option('submodule')),
				'submodule' => strtolower($this->option('submodule')),
				'tablesingular' =>  str_singular($parser->getTableName()),
                'fields' => $this->getSchemaParser()->render(),
				'parent_module'	=> strtolower($this->getModuleName()),
            ]);
         
        } elseif ($parser->isAdd()) {
            return Stub::create('/migration/add.stub', [
				'table_uc' => ucfirst(str_singular($this->option('submodule'))),
				'table_ucp' => ucfirst($this->option('submodule')),
                'class' => $this->getClass(),
                'table' => strtolower($parser->getTableName()),
				'table_lc' =>strtolower($this->option('submodule')),
				'submodule' => strtolower($this->option('submodule')),
				'tablesingular' =>  str_singular($parser->getTableName()),
                'fields' => $this->getSchemaParser()->render(),
				'parent_module'	=> strtolower($this->getModuleName()),
            ]);
        } elseif ($parser->isDelete()) {
            return Stub::create('/migration/delete.stub', [
                'class' => $this->getClass(),
                'table' => $parser->getTableName(),
				'tablesingular' =>  str_singular($parser->getTableName()),
                'fields_down' => $this->getSchemaParser()->up(),
                'fields_up' => $this->getSchemaParser()->down(),
            ]);
        } elseif ($parser->isDrop()) {
            return Stub::create('/migration/drop.stub', [
                'class' => $this->getClass(),
                'table' => $parser->getTableName(),
				'tablesingular' =>  str_singular($parser->getTableName()),
                'fields' => $this->getSchemaParser()->render(),
            ]);
        }
 return Stub::create('/migration/subcreate.stub', [
				'table_uc' => ucfirst(str_singular($this->option('submodule'))),
				'table_ucp' => ucfirst($this->option('submodule')),
                'class' => $this->getClass(),
                'table' => strtolower($parser->getTableName()),
				'table_lc' =>strtolower($this->option('submodule')),
				'submodule' => strtolower($this->option('submodule')),
				'tablesingular' =>  str_singular($parser->getTableName()),
                'fields' => $this->getSchemaParser()->render(),
				'parent_module'	=> strtolower($this->getModuleName()),
            ]);
    }

    /**
     * @return mixed
     */


    protected function getDestinationFilePath()
    {
        $path = $this->laravel['modules']->getModulePath($this->getModuleName());

        $generatorPath = GenerateConfigReader::read('migration');

        return $path . $generatorPath->getPath() . '/' . $this->getFileName() . '.php';
    }

    /**
     * @return string
     */
    private function getFileName()
    {
        return date('Y_m_d_His_') . $this->getSchemaName();
    }

    /**
     * @return array|string
     */
    private function getSchemaName()
    {
        return $this->argument('name');
    }

    /**
     * @return string
     */
    private function getClassName()
    {
        return Str::studly($this->argument('name'));
    }

    public function getClass()
    {
        return $this->getClassName();
    }

    /**
     * Run the command.
     */
    public function handle()
    {
        parent::handle();

        if (app()->environment() === 'testing') {
            return;
        }
        // $this->call('optimize');
    }
}