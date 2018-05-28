<?php
namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider {
    
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {



        View::composer('admin.class.create_edit', 'App\Http\ViewComposers\SquadComposer');

    }
    
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
        
        //
    }
    
}
