<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
        $basePath=base_path("Modules");
        if(file_exists($basePath))
        {
            $moduleFolders=scandir(base_path("Modules"));
            $modules=array_diff($moduleFolders,['.','..']);
            
            foreach($modules as $module)
            {
                $this->loadModulesViews($module);
                $this->loadModulesRoutes($module);
                $this->loadModulesMigrations($module);
            }
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    private function loadModulesViews($module)
    {
        $this->viewsPath=base_path('Modules/'.$module.'/'.'Views');
        
        if(file_exists($this->viewsPath))
        {
            $this->loadViewsFrom($this->viewsPath,$module);
        }
    }

    private function loadModulesRoutes($module)
    {
        $this->routesWebPath=base_path('Modules/'.$module.'/Routes/'.'web.php');

        
        $this->routesApiPath=base_path('Modules/'.$module.'/Routes/'.'api.php');
        
        if(file_exists($this->routesWebPath))
        {
            include $this->routesWebPath;
        }
        if(file_exists($this->routesApiPath))
        {
            include $this->routesApiPath;
        }
    }

    private function loadModulesMigrations($module)
    {
        $this->migrationsPath=base_path('Modules/'.$module.'/'.'Database/Migrations');
        if(file_exists($this->migrationsPath))
        {
            $this->loadMigrationsFrom($this->migrationsPath);
        }
    }
}
