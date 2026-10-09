<?php

namespace Modules\Kost\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Modules\Kost\Console\CekJatuhTempoSewa;
use Nwidart\Modules\Support\ModuleServiceProvider;

class KostServiceProvider extends ModuleServiceProvider
{
    /**
     * The name of the module.
     */
    protected string $name = 'Kost';

    /**
     * The lowercase version of the module name.
     */
    protected string $nameLower = 'kost';

    /**
     * Command classes to register.
     *
     * @var string[]
     */
    protected array $commands = [
        CekJatuhTempoSewa::class,
    ];

    /**
     * Provider classes to register.
     *
     * @var string[]
     */
    protected array $providers = [
        EventServiceProvider::class,
        RouteServiceProvider::class,
    ];

    /**
     * Define module schedules.
     *
     * @param  $schedule
     */
    protected function configureSchedules(Schedule $schedule): void
    {
        $schedule->command('kost:cek-jatuh-tempo')->dailyAt('07:00');
    }
}
