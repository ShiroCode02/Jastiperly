<!-- Modal Hapus -->
<div id="deleteUserModal" class="fixed inset-0 bg-black bg-opacity-40 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-xl p-8 w-full max-w-md shadow-xl text-center">
        <h3 class="text-lg mb-4 text-black">
            {{ __('messages.confirmations.delete_user') }}
        </h3>
        <div class="flex justify-center mb-6">
            <div class="w-20 h-20 rounded-full border-4 border-rose-500 flex items-center justify-center">
                <span class="text-rose-500 text-5xl font-bold">?</span>
            </div>
        </div>
        <div class="flex justify-center gap-4">
            <button type="button"
                    onclick="closeDeleteUserModal()"
                    class="px-8 py-1.5 rounded-2xl border border-gray-300 text-black hover:bg-gray-100 transition">
                {{ __('messages.actions.cancel') }}
            </button>
            <!-- Form tetap seperti versi lama -->
            <form id="deleteUserForm" method="POST" class="inline">
                @csrf @method('DELETE')
                <button type="submit" onclick="deleteUser()"
                        class="px-8 py-1.5 rounded-2xl bg-red-500 text-black hover:bg-red-600 transition">
                    {{ __('messages.actions.delete') }}
                </button>
            </form>
        </div>
    </div>
</div>
<!-- Modal Sukses -->
<div id="successUserModal" class="fixed inset-0 bg-black bg-opacity-40 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-xl p-8 w-full max-w-md shadow-xl text-center">
        <h3 class="text-lg mb-4 text-black">
            {{ __('messages.success.user_deleted') }}
        </h3>
        <div class="flex justify-center mb-6">
            <div class="w-20 h-20 rounded-full border-4 border-sky-500 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 text-sky-500" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M5 13l4 4L19 7" />
                </svg>
            </div>
        </div>
        <button onclick="closeSuccessUserModal()"
                class="px-8 py-1.5 rounded-2xl border border-gray-300 text-black hover:bg-gray-100 transition">
            {{ __('messages.actions.closed') }}
        </button>
    </div>
</div>
<script>
    // Set action & buka modal (tetap seperti sekarang)
    function confirmDeleteUser(id) {
        document.getElementById('deleteUserForm').action = `/superadmin/users/${id}`;
        document.getElementById('deleteUserModal').classList.remove('hidden');
    }
    function closeDeleteUserModal() {
        document.getElementById('deleteUserModal').classList.add('hidden');
    }
    function closeSuccessUserModal() {
        // tutup modal sukses lalu reload agar tabel sinkron
        document.getElementById('successUserModal').classList.add('hidden');
        location.reload();
    }
    // --- Minimal change: intercept submit form dan gunakan fetch ---
    (function () {
        const form = document.getElementById('deleteUserForm');
        if (!form) return; // defensif — jika form tidak ada, jangan crash
        form.addEventListener('submit', function (e) {
            e.preventDefault(); // cegah submit normal (navigasi)
            const submitBtn = form.querySelector('button[type="submit"]');
            if (!form.action) {
                alert('Action form belum di-set. Buka modal dulu sebelum klik Hapus.');
                return;
            }
            // disable tombol agar tidak double-click
            if (submitBtn) {
                submitBtn.setAttribute('disabled', 'disabled');
                submitBtn.classList.add('opacity-60', 'cursor-not-allowed');
            }
            // kirim FormData (termasuk _token dan _method) — Laravel akan menerima sebagai DELETE
            fetch(form.action, {
                method: 'POST', // pakai POST karena kita mengirim _method=DELETE di FormData
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                    // jangan set Content-Type; biarkan browser set boundary untuk FormData
                },
                body: new FormData(form)
            })
            .then(async res => {
                if (res.ok) {
                    // Sukses: tutup konfirmasi & buka modal sukses
                    closeDeleteUserModal();
                    document.getElementById('successUserModal').classList.remove('hidden');
                } else {
                    // coba baca pesan error jika ada
                    let msg = 'Gagal menghapus pengguna.';
                    try {
                        const json = await res.json();
                        if (json && json.message) msg = json.message;
                    } catch (_) {}
                    alert(msg);
                }
            })
            .catch(err => {
                console.error('delete error:', err);
                alert('Terjadi kesalahan saat menghapus pengguna.');
            })
            .finally(() => {
                if (submitBtn) {
                    submitBtn.removeAttribute('disabled');
                    submitBtn.classList.remove('opacity-60', 'cursor-not-allowed');
                }
            });
        });
    })();
    // jaga agar UI utama tidak tersembunyi (tetap seperti semula)
    try {
        document.getElementById('main-content').classList.remove('initial-hidden');
        document.getElementById('navbar-header').classList.remove('initial-hidden');
    } catch (e) { /* ignore jika element tidak ada */ }
</script>