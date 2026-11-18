@props(['name', 'label', 'type' => 'text'])

<div>
    <label for="{{ $name }}" class="block text-sm font-semibold">{{ $label }}</label>
    <input
        id="{{ $name }}"
        name="{{ $name }}"
        type="{{ $type }}"
        @unless ($type === 'password') value="{{ old($name) }}" @endunless
        @error($name) aria-invalid="true" aria-describedby="{{ $name }}-error" @enderror
        {{ $attributes->class([
            'mt-1.5 block w-full rounded-md border bg-white px-3.5 py-2.5 text-base outline-none transition-colors focus:ring-3',
            'border-line focus:border-cuff focus:ring-cuff/15' => ! $errors->has($name),
            'border-status-hipertensi-2 focus:ring-status-hipertensi-2/15' => $errors->has($name),
        ]) }}
    >
    @error($name)
        <p id="{{ $name }}-error" class="mt-1.5 text-sm text-status-hipertensi-2">{{ $message }}</p>
    @enderror
</div>
