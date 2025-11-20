<!-- Modal Hapus User -->
<div id="deleteUserModal" class="fixed inset-0 bg-black bg-opacity-40 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-md shadow-xl">
        <h3 class="text-lg font-semibold mb-4 text-red-600">Hapus Pengguna?</h3>
        <p class="text-gray-600 mb-6">Akun dan semua data terkait akan dihapus permanen dan tidak dapat dikembalikan.</p>
        <div class="flex justify-end gap-3">
            <button type="button" onclick="closeDeleteUserModal()" class="px-5 py-2 text-gray-600 hover:text-gray-800 font-medium">
                Batal
            </button>
            <form id="deleteUserForm" method="POST" class="inline">
                @csrf @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-md font-medium shadow transition">
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function confirmDeleteUser(id) {
        document.getElementById('deleteUserForm').action = `/superadmin/users/${id}`;
        document.getElementById('deleteUserModal').classList.remove('hidden');
    }

    function closeDeleteUserModal() {
        document.getElementById('deleteUserModal').classList.add('hidden');
    }
</script>