<div class="form-group">
    <label for="{{ $id }}" class="col-sm-3 control-label">
        {{ $label }}
    </label>
    <div class="col-sm-6">
        <div class="input-group">
            <div class="input-group-addon">
                <i class="@if(isset($icon)) {{ $icon }} @else fa fa-list-alt @endif"></i>
            </div>
            <select multiple="multiple" name="{{ $id }}[]" id="{{ $id }}" class='form-control select2' style="width: 100%;">
                @foreach ($items as $key => $value)
                    @if(isset($selectedItems))
                        <option value="{{ $key }}"
                                @if(array_key_exists($key, $selectedItems))
                                selected
                                @endif
                        >
                            {{ $value }}
                        </option>
                    @else
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
</div>