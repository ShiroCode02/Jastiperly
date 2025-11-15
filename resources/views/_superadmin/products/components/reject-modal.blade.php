<div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-md shadow-xl">
        <h3 class="text-lg font-semibold mb-4 text-red-600">Tolak Produk</h3>
        <form method="POST" id="rejectForm">
            @csrf
            <input type="hidden" name="product_id" id="rejectProductId">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Alasan Penolakan <span class="text-red-500">(wajib)</span>
                    </label>
                    <textarea name="reason" rows="5" required
                              class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm resize-none focus:ring-2 focus:ring-red-400"
                              placeholder="Jelaskan alasan penolakan secara jelas..."></textarea>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeRejectModal()"
                            class="px-5 py-2 text-gray-600 hover:text-gray-800 font-medium">Batal</button>
                    <button type="submit"
                            class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-md font-medium shadow transition">
                        Kirim & Tolak
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function openRejectModal(id) {
        document.getElementById('rejectProductId').value = id;
        document.getElementById('rejectForm').action = `/superadmin/products/${id}/reject`;
        document.getElementById('rejectModal').classList.remove('hidden');
    }
    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
    }
</script>