<select 
    name="{{ $name }}{{ $multiple ? '[]' : '' }}" 
    id="{{ $id }}" 
    class="{{ $class }}" 
    style="{{ $style }}" 
    {{ $multiple ? 'multiple' : '' }}
     {!! $onchange ? "onchange=\"$onchange\"" : '' !!}
>
    @foreach($options as $value => $label)
        <option value="{{ $value }}" 
            {{ is_array($selected) ? (in_array($value, $selected) ? 'selected' : '') : ($value == $selected ? 'selected' : '') }}>
            {{ $label }}
        </option>
    @endforeach
</select>

