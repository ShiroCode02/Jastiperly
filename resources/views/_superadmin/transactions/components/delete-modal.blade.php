<!-- Modal Hapus -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-40 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-md shadow-xl">
        <h3 class="text-lg font-semibold mb-4 text-red-600">Hapus Transaksi?</h3>
        <p class="text-gray-600 mb-6">Data akan dihapus permanen dan tidak dapat dikembalikan.</p>
        <div class="flex justify-end gap-3">
            <button type="button" onclick="closeDeleteModal()" class="px-5 py-2 text-gray-600 hover:text-gray-800 font-medium">Batal</button>
            <form id="deleteForm" method="POST" class="inline">
                @csrf @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-md font-medium shadow transition">
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function confirmDelete(id) {
        document.getElementById('deleteForm').action = `/superadmin/transactions/${id}`;
        document.getElementById('deleteModal').classList.remove('hidden');
    }
    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
    document.getElementById('main-content').classList.remove('initial-hidden');
    document.getElementById('navbar-header').classList.remove('initial-hidden');
</script>