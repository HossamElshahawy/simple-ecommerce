<?php
declare(strict_types = 1);

namespace Dash;
use Dash\Extras\Dashboard\Dashboard;
use Dash\Extras\Inputs\InputOptions\relationTypes;
use Dash\Extras\Resources\MainResource;

class Resource {
	use Dashboard, MainResource, relationTypes, Modules;
	protected static $model_data;
	public function __construct() {
		// Use nwiDart Modules Localization && Modules Pathes from Modules Folder
		$this->initModule();
	}

	/**
	 * this is a getter property can assign the model object with values
	 * to using in resource with contractable class in Field
	 * \Dash\Extras\Inputs\InputOptions\ContractableAndRules::class
	 * \Dash\Extras\Inputs\Field
	 * @return void
	 */
	public function __get($property) {
		
		if (request()->ajax()) {
			$object        = str_replace('._.', '\\', get_class($this)::$model);
			$record_id     = request('record_id');
			$attribute     = request('attribute');
			$relation_type = request('relation_type');
			if (class_exists($object) && !empty($attribute)) {

				$modelData = '\\'.app($object)::where('id', $record_id)->with($attribute)->pluck($property);
				
				if (is_string($modelData)) {
					$prepare_dataunslashes = str_replace('"]', "", str_replace('\\["', "", $modelData));
					static::$model_data = $prepare_dataunslashes;
					return $this->$property = $prepare_dataunslashes;
				} else {
					static::$model_data = $modelData;
					return $this->$property = $modelData->$property;
				}

			} else if (is_numeric(request()->segment(4)) || is_numeric(request()->segment(5))) {
				// prepare id from segment if ajax request
				$id = is_numeric(request()->segment(4))?request()->segment(4):request()->segment(5);
			}

		} else if (is_numeric(request()->segment(4)) || is_numeric(request()->segment(5))) {
			// prepare id from segment if not ajax request
			$id = is_numeric(request()->segment(4))?request()->segment(4):request()->segment(5);
		}

        $propertys = '';
		if (!empty($id)) {
			$ModelData = app(static ::$model)::find($id);
			if (!empty($ModelData)) {
				static::$model_data = $ModelData;
                foreach ($ModelData->toArray() as $key => $val) {
                    $propertys .= ','.$property;
                    if ($property == $key) {

						return $this->{$key} = $val;
					}
				}
			}
		}
	}


	
	public function __call($method_name, $args) {
		if(method_exists(static::$model_data,$method_name)){
			return static::$model_data->$method_name($args);
		}
    }
    
	public static function __callStatic($method_name, $args) {
        if(method_exists(static::$model_data,$method_name)){
			return static::$model_data->$method_name($args);
		}
	 }




}
