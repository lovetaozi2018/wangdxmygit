<?php $lblStyle = "margin: 0 5px; vertical-align: middle; font-weight: normal;"; ?>
<div class="form-group">
    <label for="{{ $id }}" class="col-sm-3 control-label">
        @if(isset($label)) {{ $label }} @else 状态 @endif
    </label>
    <div class="col-sm-6" style="padding-top: 5px;">
        <input id="{{ $id }}1" @if($value) checked @endif
        type="radio" name="{{ $id }}" class="minimal" value="1">
        <label for="{{ $id }}1" style="{!! $lblStyle !!}">
            @if(isset($options)) {{ $options[0] }} @else 启用 @endif
        </label>
        <input id="{{ $id }}2" @if(!$value) checked @endif
        type="radio" name="{{ $id }}" class="minimal" value="0">
        <label for="{{ $id }}2" style="{!! $lblStyle !!}">
            @if(isset($options)) {{ $options[1] }} @else 禁用 @endif
        </label>
    </div>
</div>