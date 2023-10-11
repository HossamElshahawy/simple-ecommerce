<?php
namespace Dash\Controllers\Traits\ControllerMethods;

trait LoadSubResourceRelations {

	public function subResource() {
		$fields      = $this->fields();
		$unsetFields = [];

		// remove main resource from columns
		foreach ($fields as $k => $v) {

			if (in_array($v['type'], $this->relationTypes)) {
				if (isset($v['resource'])) {
					$shortName = resourceShortName($v['resource']);
					$currentShortName = resourceShortName($this->resource['resourceNameFull']);

					if ($shortName == request('main_resource')) {

						 unset($fields[$k]);
					}
				}
			}
		}

		$loadByResourceRelation = [
			'attribute' => request('attribute'),
			'use_method' => request('use_method'),
			'model'     => request('model'),
			'record_id' => request('record_id'),
			'main_resource' => request('main_resource'),
		];
		$admin = auth()->guard('dash')->user();
		$data  = view('dash::resource.relation_datatable.sub_resources', [
				'resource'      => $this->resource,
				'resourceName'  => $this->resource['resourceName'],
				'title'         => $this->title,
				'relationTypes' => $this->relationTypes,
                'filters'           => $this->prepare_filters(),
				'actions'           => $this->prepare_actions(),
				'fields'        => $fields,
				'unsetFields'   => $unsetFields,
				'pagesRules'    => $this->pagesRules($admin),
				'breadcrumb'    => $this->breadcrumb(),
				//datatable
				'multiSelectRecord'      => $this->resource['multiSelectRecord'],
				'lengthMenu'             => $this->resource['lengthMenu'],
				'lengthChange'           => $this->resource['lengthChange'],
				'paging'                 => $this->resource['paging'],
				'pagingType'             => $this->resource['pagingType'],
				'ordering'               => $this->resource['ordering'],
				'processing'             => $this->resource['processing'],
				'serverSide'             => $this->resource['serverSide'],
				'scrollY'                => $this->resource['scrollY'],
				'scrollX'                => $this->resource['scrollX'],
				'scrollCollapse'         => $this->resource['scrollCollapse'],
				'searching'              => $this->resource['searching'],
				'dtButtons'              => $this->resource['dtButtons'],
				'loadByResourceRelation' => $loadByResourceRelation,
			])->render();

		return $data;
	}
}
