@props(['name', 'label', 'value' => '', 'required' => false])

<div class="field">
    <label for="{{ $name }}">{{ $label }}</label>
    <textarea
        id="{{ $name }}"
        name="{{ $name }}"
        rows="5"
        @if($required) required @endif
        {{ $attributes }}
    >{{ old($name, $value) }}</textarea>
    @error($name)
        <p class="error-text">{{ $message }}</p>
    @enderror
</div>
