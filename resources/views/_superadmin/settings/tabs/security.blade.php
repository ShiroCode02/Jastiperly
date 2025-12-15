<form action="{{ url()->current() }}?tab=keamanan" method="POST" class="space-y-6">
    @csrf

    <div class="space-y-5">

        <div class="grid grid-cols-2 items-center gap-8">
            <label class="w-56 text-xl font-semibold text-[#000957]">
                {{ __('messages.current_password') }}
            </label>
            <input type="password" name="current_password"
                   class="border rounded px-3 py-2" />
        </div>

        <div class="grid grid-cols-2 items-center gap-8">
            <label class="w-56 text-xl font-semibold text-[#000957]">
                {{ __('messages.new_password') }}
            </label>
            <input type="password" name="new_password"
                   class="border rounded px-3 py-2" />
        </div>

        <div class="grid grid-cols-2 items-center gap-8">
            <label class="w-56 text-xl font-semibold text-[#000957]">
                {{ __('messages.confirm_new_password') }}
            </label>
            <input type="password" name="new_password_confirmation"
                   class="border rounded px-3 py-2" />
        </div>

    </div>

    <div class="pt-2 pb-8">
        <button type="submit" class="bg-[#FFEB00] hover:bg-[#FF5E1F] text-black font-bold px-16 py-1 rounded shadow">
            {{ __('messages.actions.save') }}
        </button>
    </div>
</form>
