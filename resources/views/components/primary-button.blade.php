<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-6 py-3 bg-[#82C17D] border border-transparent rounded-xl font-bold text-sm text-white tracking-wide hover:bg-[#6fa86a] focus:bg-[#6fa86a] active:bg-[#5f985a] focus:outline-none focus:ring-2 focus:ring-[#82C17D] focus:ring-offset-2 transition ease-in-out duration-150 shadow-md']) }}>
    {{ $slot }}
</button>
