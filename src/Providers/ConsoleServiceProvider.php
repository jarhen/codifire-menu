<?php

namespace Jarhen\Modules\Providers;

use Illuminate\Support\ServiceProvider;
use Jarhen\Modules\Commands\CommandMakeCommand;
use Jarhen\Modules\Commands\ControllerMakeCommand;
use Jarhen\Modules\Commands\DisableCommand;
use Jarhen\Modules\Commands\DumpCommand;
use Jarhen\Modules\Commands\EnableCommand;
use Jarhen\Modules\Commands\EventMakeCommand;
use Jarhen\Modules\Commands\FactoryMakeCommand;
use Jarhen\Modules\Commands\InstallCommand;
use Jarhen\Modules\Commands\JobMakeCommand;
use Jarhen\Modules\Commands\ListCommand;
use Jarhen\Modules\Commands\ListenerMakeCommand;
use Jarhen\Modules\Commands\MailMakeCommand;
use Jarhen\Modules\Commands\MiddlewareMakeCommand;
use Jarhen\Modules\Commands\MigrateCommand;
use Jarhen\Modules\Commands\MigrateRefreshCommand;
use Jarhen\Modules\Commands\MigrateResetCommand;
use Jarhen\Modules\Commands\MigrateRollbackCommand;
use Jarhen\Modules\Commands\MigrateStatusCommand;
use Jarhen\Modules\Commands\MigrationMakeCommand;
use Jarhen\Modules\Commands\ModelMakeCommand;
use Jarhen\Modules\Commands\ModuleMakeCommand;
use Jarhen\Modules\Commands\NotificationMakeCommand;
use Jarhen\Modules\Commands\PolicyMakeCommand;
use Jarhen\Modules\Commands\ProviderMakeCommand;
use Jarhen\Modules\Commands\PublishCommand;
use Jarhen\Modules\Commands\PublishConfigurationCommand;
use Jarhen\Modules\Commands\PublishMigrationCommand;
use Jarhen\Modules\Commands\PublishTranslationCommand;
use Jarhen\Modules\Commands\RequestMakeCommand;
use Jarhen\Modules\Commands\ResourceMakeCommand;
use Jarhen\Modules\Commands\RouteProviderMakeCommand;
use Jarhen\Modules\Commands\RuleMakeCommand;
use Jarhen\Modules\Commands\SeedCommand;
use Jarhen\Modules\Commands\SeedMakeCommand;
use Jarhen\Modules\Commands\SetupCommand;
use Jarhen\Modules\Commands\TestMakeCommand;
use Jarhen\Modules\Commands\UnUseCommand;
use Jarhen\Modules\Commands\UpdateCommand;
use Jarhen\Modules\Commands\UseCommand;

class ConsoleServiceProvider extends ServiceProvider
{
    protected $defer = false;

    /**
     * The available commands
     *
     * @var array
     */
    protected $commands = [
        CommandMakeCommand::class,
        ControllerMakeCommand::class,
        DisableCommand::class,
        DumpCommand::class,
        EnableCommand::class,
        EventMakeCommand::class,
        JobMakeCommand::class,
        ListenerMakeCommand::class,
        MailMakeCommand::class,
        MiddlewareMakeCommand::class,
        NotificationMakeCommand::class,
        ProviderMakeCommand::class,
        RouteProviderMakeCommand::class,
        InstallCommand::class,
        ListCommand::class,
        ModuleMakeCommand::class,
        FactoryMakeCommand::class,
        PolicyMakeCommand::class,
        RequestMakeCommand::class,
        RuleMakeCommand::class,
        MigrateCommand::class,
        MigrateRefreshCommand::class,
        MigrateResetCommand::class,
        MigrateRollbackCommand::class,
        MigrateStatusCommand::class,
        MigrationMakeCommand::class,
        ModelMakeCommand::class,
        PublishCommand::class,
        PublishConfigurationCommand::class,
        PublishMigrationCommand::class,
        PublishTranslationCommand::class,
        SeedCommand::class,
        SeedMakeCommand::class,
        SetupCommand::class,
        UnUseCommand::class,
        UpdateCommand::class,
        UseCommand::class,
        ResourceMakeCommand::class,
        TestMakeCommand::class,
    ];

    /**
     * Register the commands.
     */
    public function register()
    {
        $this->commands($this->commands);
    }

    /**
     * @return array
     */
    public function provides()
    {
        $provides = $this->commands;

        return $provides;
    }
}
