

<div class="col-md-12 border-bottom mb-2 pb-2">
    <div class="row align-items-center">
        <div class="col-md-2">
            {{--  && !empty($unsetFields)  --}}
            @if (isset($pagesRules['create']) && $pagesRules['create'])
                {{--  <a href="{{ url(app('dash')['DASHBOARD_PATH'].'/resource/'.$resourceName.'/new?relationField['.$unsetFields['attribute'].']='.$loadByResourceRelation['record_id']) }}" class="btn btn-dark"><i class="fa fa-plus"></i> {{ __('dash::dash.create') }}</a>  --}}

                {{--  {{ dd($resource,$resourceName) }}  --}}

                @include('dash::resource.inlineButton.inline_create', [
                    'field' => [
                        'resource' => $resource['resourceNameFull'],
                        'attribute' => $resource['resourceName'],
                        //'attribute'=>$resource['resourceName'],
                        'name' => $resource['navigation']['customName'],
                    ],
                    'relationField' =>
                        'relationField[' .
                            $loadByResourceRelation['use_method'] .
                            ']=' .
                            $loadByResourceRelation['record_id'] ??
                        '',
                    'placeholder' => $resource['resourceName'],
                    'labelInline' => '<i class="fa fa-plus"></i> ' . __('dash::dash.create'),
                ])
            @endif
        </div>
        <div class="col-md-8">
        @if ($multiSelectRecord && method_exists($resource['model'], 'trashed'))
            <div class="col-3">
                <label class="custom-switch" for="withTrashed{{ $resourceName }}">
                    <input  type="checkbox" name="withTrashed" value="yes"
                    id="withTrashed{{ $resourceName }}" class="custom-switch-input">
                    <span class="custom-switch-indicator"></span>
                    <span class="custom-switch-description">{{ __('dash::dash.withTrashed') }}</span>
                </label>
            </div>
        @endif


            {{--  @include('dash::resource.actions.index_actions')  --}}
        </div>

    </div>
</div>




<table
    class="table d-table table-bordered table-striped table-hover align-items-center mb-0 datatable_resource{{ $resourceName }}"
    id="datatable_resource{{ $resourceName }}" style="width:100%;" data-turbolinks="false">
    <thead>
        <tr>
            @if ($multiSelectRecord)
                <th class="col-1 center">
                    <input class="form-check-input selectAll{{ $resourceName }}" type="checkbox"
                        id="selectAll{{ $resourceName }}">

                </th>
            @endif
            @foreach ($fields as $key => $value)
                @if ($value['show_rules']['showInIndex'])
                    <th class=" font-weight-bolder ">
                        {{ $value['name'] }}
                    </th>

                    {{--  Custom View Columns with belongsTo hasOne hasOnethroug etc.. Start  --}}
                    @if (isset($value['viewColumns']))
                        @php
                            if (is_array($value['viewColumns'][0])) {
                                $viewColumns = $value['viewColumns'][0];
                            } elseif (is_string($value['viewColumns'][0])) {
                                $viewColumns = $value['viewColumns'];
                            }
                        @endphp
                        @foreach ($viewColumns as $k => $v)
                            <th class=" font-weight-bolder">
                                {!! str_replace('_', ' ', $v) !!}
                            </th>
                        @endforeach
                    @endif
                    {{--  Custom View Columns with belongsTo hasOne hasOnethroug etc.. End  --}}
                @endif
            @endforeach
            <th>@lang('dash::dash.action')</th>
        </tr>
    </thead>
</table>
@include('dash::resource.relation_datatable.sub_datatable')


{{--
    ['field'=>[
    'resource'=>$resource['resourceNameFull'],
    'attribute'=>$resourceName,
    'name'=>$resource['navigation']['customName'],
    ],
'relationField'=>'relationField['.$unsetFields['attribute'].']='.$loadByResourceRelation['record_id']??'',
'placeholder'=>$resourceName,
'labelInline'=>'<i class="fa fa-plus"></i> '.__('dash::dash.create'),
]
  --}}
