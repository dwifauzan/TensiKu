<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex w-full items-center justify-center rounded-md bg-cuff px-4 py-3 text-base font-semibold text-white transition-colors hover:bg-cuff-deep focus-visible:outline-3 focus-visible:outline-offset-2 focus-visible:outline-cuff']) }}>
    {{ $slot }}
</button>
