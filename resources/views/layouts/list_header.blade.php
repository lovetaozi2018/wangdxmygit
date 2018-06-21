<span id="breadcrumb" style="color: #999; font-size: 13px;">{!! $breadcrumb !!}</span>
<div class="box-tools pull-right">
    @if(!isset($addBtn))
        @can('act', $uris['create'])
            <button id="add-record" type="button" class="btn btn-box-tool">
                <i class="fa fa-plus text-blue"> 新增</i>
            </button>
        @endcan
    @endif
    @if(isset($buttons))
        @foreach($buttons as $button)
            @can('act', $uris[$button['id']])
                <button id="{{ $button['id'] }}" type="button" class="btn btn-box-tool">
                    <i class="{{ $button['icon'] }} text-blue"> {{ $button['label'] }}</i>
                </button>
            @endcan
        @endforeach
    @endif
</div>