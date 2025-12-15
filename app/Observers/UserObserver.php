<?php

namespace App\Observers;

use App\Models\User;
use App\Models\UserDetailHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        //
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        $dirty = $user->getDirty();
        $original = $user->getOriginal();

        foreach ($dirty as $field => $newValue) {
            $oldValue = $original[$field] ?? null;

            // Abaikan field yang gak penting
            if (in_array($field, ['updated_at', 'created_at', 'password', 'remember_token'])) {
                continue;
            }

            if ($oldValue === $newValue) continue;

            // Mapping nama field biar manusiawi
            $fieldNames = [
                'name' => 'Nama Lengkap',
                'email' => 'Email',
                'role' => 'Status Akun',
                'account_status' => 'Status Aktivitas',
                'profile_image' => 'Foto Profil',
            ];

            $displayNames = [
                'role' => [
                    'traveler' => 'Traveler',
                    'customer' => 'Penitip',
                    'admin' => 'Admin',
                    'finance' => 'Finance',
                    'superadmin' => 'Superadmin',
                ],
                'account_status' => [
                    'active' => 'Aktif',
                    'inactive' => 'Nonaktif',
                ],
            ];

            $oldDisplay = $displayNames[$field][$oldValue] ?? $oldValue;
            $newDisplay = $displayNames[$field][$newValue] ?? $newValue;

            // Khusus foto profil
            if ($field === 'profile_image') {
                $oldDisplay = $oldValue ? 'Foto lama' : '(kosong)';
                $newDisplay = $newValue ? 'Foto baru' : '(dihapus)';
            }

            UserDetailHistory::create([
                'user_id' => $user->id,
                'changed_by' => Auth::id(),
                'field' => $fieldNames[$field] ?? ucwords(str_replace('_', ' ', $field)),
                'old_value' => $this->formatValue($oldDisplay),
                'new_value' => $this->formatValue($newDisplay),
                'ip_address' => Request::ip(),
                'user_agent' => Request::header('User-Agent'),
            ]);
        }
    }

    private function formatValue($value)
    {
        if (is_null($value)) return '-';
        if ($value === '') return '(kosong)';
        return (string) $value;
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
