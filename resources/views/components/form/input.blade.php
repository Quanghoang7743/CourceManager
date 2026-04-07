@props(['name', 'label', 'type' => 'text', 'value' => '', 'required' => false])

<div class="field">
    <label for="{{ $name }}">{{ $label }}</label>
    <input
        type="{{ $type }}"
        id="{{ $name }}"
        name="{{ $name }}"
        value="{{ old($name, $value) }}"
        @if($required) required @endif
        {{ $attributes }}
    >
    @error($name)
        <p class="error-text">{{ $message }}</p>
    @enderror
</div>
