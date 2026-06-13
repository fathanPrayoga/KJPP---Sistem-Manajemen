<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-6 py-3 bg-white border border-gray-200 rounded-xl font-bold text-sm text-gray-700 tracking-wide shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[#82C17D] focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
