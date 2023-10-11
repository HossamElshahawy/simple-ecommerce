<?php
namespace Dash;
use Illuminate\Filesystem\Filesystem;

trait Modules {

	// check if nwidart/laravel-modules installed
	public function initModule() {
		$resource = resourceShortName(get_class($this));
		$explode_class = explode('\\',get_class($this));

		if(!empty($explode_class[1])){
			$module   = '\Modules\\'.$explode_class[1].'\\Providers\\'.$explode_class[1].'ServiceProvider';
		}else{
		 	$module   = '\Modules\\'.$resource.'\\Providers\\'.$resource.'ServiceProvider';
		}

        if (class_exists($module)) {
            $providerResourceModule = new $module(app());
			if (method_exists($module, 'boot')) {
				$providerResourceModule->boot();
			} else {
				if (method_exists($module, 'registerTranslations')) {
					$providerResourceModule->registerTranslations();
				}
				if (method_exists($module, 'registerViews')) {
					$providerResourceModule->registerViews();
				}
			}
		}

        // $module_dirs = new Filesystem();
        // foreach($module_dirs->directories(base_path('Modules')) as $mpath){
        //     if(file_exists($mpath.'/module.json')){
        //         $pfile = file_get_contents($mpath.'/module.json');
        //         $modules = json_decode($pfile);
        //         $module = $modules->providers[0]??null;
        //         if (!empty($module) && class_exists($module)) {
        //             $providerResourceModule = new $module(app());
        //             if (method_exists($module, 'registerTranslations')) {
        //                 $providerResourceModule->registerTranslations();
        //             }
        //         }

        //          if (method_exists($module, 'registerViews')) {
        //              $providerResourceModule->registerViews();
        //          }
        //      }
        // }




}

}
