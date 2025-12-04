<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center w-[300px] h-[50px] justify-center bg-[#FF5E1F] border border-transparent rounded-md font-semibold text-sm text-white hover:text-black uppercase tracking-widest hover:bg-[#FFEB00] focus:bg-[#FFEB00] focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
