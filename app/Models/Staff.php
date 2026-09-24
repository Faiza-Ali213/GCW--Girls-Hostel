<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $table = 'staff';

    protected $fillable = [
        'name',
        'role',
        'phone',
        'cnic',
        'duty_shift',
        'email',
        'address',
        'joining_date',
        'salary',
        'status',
        'remarks',
        'profile_picture',
    ];

    /**
     * The attributes that should be cast.
     * ✅ Ye add kiya — taake dates Carbon object banein
     */
    protected $casts = [
        'joining_date' => 'date',
        'salary'       => 'decimal:2',
    ];

    // ============================================
    // SCOPES
    // ============================================

    /**
     * Filter only active staff.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Filter only inactive staff.
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    /**
     * Search staff by name, role, phone, or CNIC.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'LIKE', "%{$search}%")
              ->orWhere('role', 'LIKE', "%{$search}%")
              ->orWhere('phone', 'LIKE', "%{$search}%")
              ->orWhere('cnic', 'LIKE', "%{$search}%");
        });
    }
}