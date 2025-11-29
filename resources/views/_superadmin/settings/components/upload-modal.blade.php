<!-- Modal Upload Foto Profil -->
<div id="uploadProfileModal" class="fixed inset-0 bg-black bg-opacity-40 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-md shadow-xl">
        <h3 class="text-lg font-semibold mb-4 text-[#000957]">Ubah Foto Profil?</h3>
        <p class="text-gray-600 mb-6">Pilih gambar baru untuk foto profil Anda (jpg/png, max 10MB).</p>
        <form id="uploadProfileForm" method="POST" enctype="multipart/form-data" class="mb-4">
            @csrf
            <input type="file" name="profile_image" class="w-full border rounded px-3 py-2 mb-4" required accept="image/jpeg,image/png" />
            @error('profile_image')
                <div class="text-red-500 text-sm mb-4">{{ $message }}</div>
            @enderror
            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeUploadProfileModal()" class="px-6 py-1.5 rounded-md border border-gray-300 text-black hover:bg-gray-100 transition">
                    Batal
                </button>
                <button type="submit" class="bg-[#FFEB00] hover:bg-[#FF5E1F] text-black px-6 py-1.5 rounded-md font-medium shadow transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openUploadProfileModal() {
        document.getElementById('uploadProfileForm').action = "{{ route('superadmin.settings.update') }}?tab=profil";
        document.getElementById('uploadProfileModal').classList.remove('hidden');
    }
    function closeUploadProfileModal() {
        document.getElementById('uploadProfileModal').classList.add('hidden');
    }
</script>