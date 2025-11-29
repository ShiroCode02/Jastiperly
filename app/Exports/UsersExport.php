<?php
namespace App\Exports;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromCollection, WithHeadings, WithMapping
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection(): Collection
    {
        $allowedRoles = ['traveler', 'customer', 'admin', 'finance'];
        $query = User::with('detail')
            ->whereIn('role', $allowedRoles)
            ->orderBy('id', 'desc');

        // Single user kalau ada user_id (dari detail)
        if ($this->request['user']) {
            $query->where('id', $this->request['user']);
        }

        // Filter pencarian
        if ($this->request['search']) {
            $search = $this->request['search'];
            $query->where(function($q) use ($search) {
                $q->whereHas('detail', fn($qq) => $qq->where('name', 'like', "%{$search}%"))
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter tab (Traveler, Penitip, Admin, Finance)
        if ($this->request['tab']) {
            $tab = $this->request['tab'];
            $roleMap = [
                'Traveler' => 'traveler',
                'Penitip' => 'customer',
                'Admin' => 'admin',
                'Finance' => 'finance',
            ];
            if (isset($roleMap[$tab])) {
                $query->where('role', $roleMap[$tab]);
            }
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'ID',
            'Nama',
            'Email',
            'Role',
            'Status Akun',
        ];
    }

    public function map($user): array
    {
        static $index = 0;
        $index++;

        return [
            $index,
            $user->id,
            $user->detail->name ?? '-',
            $user->email,
            ucfirst($user->role),
            $user->account_status,
        ];
    }
}