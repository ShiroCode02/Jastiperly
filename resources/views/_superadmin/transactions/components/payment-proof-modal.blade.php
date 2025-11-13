{{-- 
    Component: Modal Bukti Pembayaran (SuperAdmin)
    Path: resources/views/_superadmin/transactions/components/payment-proof-modal.blade.php
    Usage: @include('_superadmin.transactions.components.payment-proof-modal')
    Trigger: onclick="showProofModal('{{ asset('storage/' . $transaction->payment_proof) }}')"
--}}

@props(['proof' => null])

@if($proof)
    <!-- MODAL BUKTI PEMBAYARAN (CUSTOM) -->
    <div id="proofModal" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-hidden flex flex-col animate-in fade-in zoom-in duration-200">
            <!-- HEADER -->
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-bold text-center text-gray-800">Bukti Pembayaran</h3>
            </div>

            <!-- GAMBAR -->
            <div class="flex-1 p-6 flex items-center justify-center bg-gray-50">
                <img id="proofImage" src="" alt="Bukti Pembayaran" 
                     class="max-w-full max-h-full object-contain rounded-lg shadow-md">
            </div>

            <!-- FOOTER -->
            <div class="px-6 py-3 border-t border-gray-200 text-center">
                <a id="proofDownload" href="" download 
                   class="text-sm text-blue-600 hover:text-blue-800 underline flex items-center justify-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
                    </svg>
                    Unduh Gambar
                </a>
            </div>
        </div>
    </div>

    <!-- SCRIPT TETAP SAMA (100%) -->
    <script>
        function showProofModal(imagePath) {
            const modal = document.getElementById('proofModal');
            const img = document.getElementById('proofImage');
            const download = document.getElementById('proofDownload');

            img.src = imagePath;
            download.href = imagePath;
            modal.classList.remove('hidden');
        }

        function closeProofModal() {
            document.getElementById('proofModal').classList.add('hidden');
        }

        // Tutup saat klik di luar card
        document.getElementById('proofModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeProofModal();
            }
        });

        // Tutup dengan ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeProofModal();
            }
        });
    </script>
@endif