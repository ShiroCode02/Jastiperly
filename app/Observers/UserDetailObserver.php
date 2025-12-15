<?php

namespace App\Observers;

use App\Models\UserDetail;
use App\Models\UserDetailHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class UserDetailObserver
{
    /**
     * Handle the UserDetail "created" event.
     */
    public function created(UserDetail $userDetail): void
    {
        //
    }

    /**
     * Handle the UserDetail "updated" event.
     */
    public function updated(UserDetail $userDetail): void
    {
        $dirty = $userDetail->getDirty();        // field yang berubah
        $original = $userDetail->getOriginal(); // nilai lama

        foreach ($dirty as $field => $newValue) {
            $oldValue = $original[$field] ?? null;

            if (in_array($field, ['updated_at', 'created_at'])) {
                continue;
            }

            // Skip kalau nilai lama & baru sama (kadang terjadi karena casting)
            if ($oldValue === $newValue) continue;

            // Mapping nama field biar lebih manusiawi
            $fieldNames = [
                'name' => 'Username',
                'phone' => 'No. Handphone',
                'address' => 'Alamat',
                'date_birth' => 'Tanggal Lahir',
                'gender' => 'Jenis Kelamin',
                'bank_name' => 'Nama Bank',
                'bank_number' => 'No. Rekening',
                'id_card_image' => 'Foto KTP',
                'pasport_image' => 'Foto Paspor',
                'account_image' => 'Foto Buku Rekening',
            ];

            UserDetailHistory::create([
                'user_id'     => $userDetail->user_id,
                'changed_by'  => Auth::id(),
                'field'       => $fieldNames[$field] ?? ucwords(str_replace('_', ' ', $field)),
                'old_value'   => $this->formatValue($oldValue),
                'new_value'   => $this->formatValue($newValue),
                'ip_address'  => Request::ip(),
                'user_agent'  => Request::header('User-Agent'),
            ]);
        }
    }

    private function formatValue($value)
    {
        if (is_null($value)) return '-';
        if ($value === '') return '(kosong)';
        if (filter_var($value, FILTER_VALIDATE_URL) || str_contains($value, 'storage/')) {
            return 'File diupload/ulang';
        }
        return (string) $value;
    }

    /**
     * Handle the UserDetail "deleted" event.
     */
    public function deleted(UserDetail $userDetail): void
    {
        //
    }

    /**
     * Handle the UserDetail "restored" event.
     */
    public function restored(UserDetail $userDetail): void
    {
        //
    }

    /**
     * Handle the UserDetail "force deleted" event.
     */
    public function forceDeleted(UserDetail $userDetail): void
    {
        //
    }
}
