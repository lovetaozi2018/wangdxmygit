<div class="form-group" @if(isset($divId)) id="{{ $divId }}" @endif>
    {!! Form::label($id, $label, [
        'class' => 'col-sm-3 control-label',
    ]) !!}
    <div class="col-sm-6">
        {!! Form::select($id, $items, null, [
            'class' => 'form-control',
            'style' => 'width: 100%;'
        ]) !!}
    </div>
</div>