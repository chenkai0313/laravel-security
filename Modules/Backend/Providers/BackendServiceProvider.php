<?php

namespace Modules\Backend\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\Backend\Services\AdminService;
use Modules\Backend\Services\ClientInfoService;
use Modules\Backend\Services\RbacService;
use Modules\Backend\Services\AdminLogService;
use Modules\Backend\Services\NoticeService;
use Modules\Backend\Services\InmailService;
use Modules\Backend\Services\ReportService;
use Modules\Backend\Services\WorkScheduleService;
use Modules\Backend\Services\UnfinishedService;
use Modules\Backend\Services\AdminRecordService;
use Modules\Backend\Services\ReportSystemService;
use Modules\Backend\Services\ReportGradeService;

class BackendServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->addFacade();
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
    }

    /**
     * 门面注册
     */
    public function addFacade()
    {
        $loader = AliasLoader::getInstance();
        $loader->alias('AdminService', \Modules\Backend\Facades\AdminFacade::class);
        $loader->alias('RbacService', \Modules\Backend\Facades\RbacFacade::class);
        $loader->alias('AdminLogService', \Modules\Backend\Facades\AdminLogFacade::class);
        $loader->alias('NoticeService', \Modules\Backend\Facades\NoticeFacade::class);
        $loader->alias('InmailService', \Modules\Backend\Facades\InmailFacade::class);
        $loader->alias('WorkScheduleService', \Modules\Backend\Facades\WorkScheduleFacade::class);
        $loader->alias('ClientInfoService', \Modules\Backend\Facades\ClientInfoFacade::class);
        $loader->alias('ReportService', \Modules\Backend\Facades\ReportFacade::class);
        $loader->alias('UnfinishedService', \Modules\Backend\Facades\UnfinishedFacade::class);
        $loader->alias('AdminRecordService', \Modules\Backend\Facades\AdminRecordFacade::class);
        $loader->alias('ReportSystemService', \Modules\Backend\Facades\ReportSystemFacade::class);
        $loader->alias('ReportGradeService', \Modules\Backend\Facades\ReportGradeFacade::class);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('AdminService', function () {
            return new AdminService();
        });
        $this->app->singleton('RbacService', function () {
            return new RbacService();
        });
        $this->app->singleton('AdminLogService', function () {
            return new AdminLogService();
        });
        $this->app->singleton('NoticeService', function () {
            return new NoticeService();
        });
        $this->app->singleton('InmailService', function () {
            return new InmailService();
        });
        $this->app->singleton('WorkScheduleService', function () {
            return new WorkScheduleService();
        });
        $this->app->singleton('ClientInfoService', function () {
            return new ClientInfoService();
        });
        $this->app->singleton('ReportService', function () {
            return new ReportService();
        });
        $this->app->singleton('UnfinishedService', function () {
            return new UnfinishedService();
        });
        $this->app->singleton('AdminRecordService', function () {
            return new AdminRecordService();
        });
        $this->app->singleton('ReportSystemService', function () {
            return new ReportSystemService();
        });
        $this->app->singleton('ReportGradeService', function () {
            return new ReportGradeService();
        });


    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__ . '/../Config/config.php' => config_path('backend.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__ . '/../Config/config.php', 'backend'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/backend');

        $sourcePath = __DIR__ . '/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ]);

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/backend';
        }, \Config::get('view.paths')), [$sourcePath]), 'backend');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/backend');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'backend');
        } else {
            $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'backend');
        }
    }

    /**
     * Register an additional directory of factories.
     * @source https://github.com/sebastiaanluca/laravel-resource-flow/blob/develop/src/Modules/ModuleServiceProvider.php#L66
     */
    public function registerFactories()
    {
        if (!app()->environment('production')) {
            app(Factory::class)->load(__DIR__ . '/Database/factories');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
