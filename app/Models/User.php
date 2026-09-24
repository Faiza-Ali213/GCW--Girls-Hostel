<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_photo',
        'phone',
        'role',
        'status',
        'last_login',
        'address',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'last_login'        => 'datetime',
        ];
    }

    // ============================================
    // ROLE CONSTANTS
    // ============================================

    const ROLE_ADMIN = 'admin';
    const ROLE_CLERK = 'clerk';
    const ROLE_USER  = 'user';      // ✅ NEW: Normal / Student user

    // ============================================
    // STATUS CONSTANTS
    // ============================================

    const STATUS_ACTIVE   = 'active';
    const STATUS_INACTIVE = 'inactive';

    // ============================================
    // ROLE HELPERS
    // ============================================

    /**
     * Get all available roles.
     */
    public static function getRoles(): array
    {
        return [
            self::ROLE_ADMIN => 'Administrator',
            self::ROLE_CLERK => 'Clerk',
            self::ROLE_USER  => 'User',      // ✅ NEW
        ];
    }

    /**
     * Get all available statuses.
     */
    public static function getStatuses(): array
    {
        return [
            self::STATUS_ACTIVE   => 'Active',
            self::STATUS_INACTIVE => 'Inactive',
        ];
    }

    /**
     * Check if user is admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * Check if user is clerk.
     */
    public function isClerk(): bool
    {
        return $this->role === self::ROLE_CLERK;
    }

    /**
     * Check if user is normal user (student).
     */
    public function isUser(): bool
    {
        return $this->role === self::ROLE_USER;
    }

    /**
     * Check if user is active.
     */
    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    /**
     * Check if user is inactive.
     */
    public function isInactive(): bool
    {
        return $this->status === self::STATUS_INACTIVE;
    }

    /**
     * Get role badge color for UI.
     */
    public function getRoleBadgeColor(): string
    {
        return match($this->role) {
            self::ROLE_ADMIN => 'danger',
            self::ROLE_CLERK => 'warning',
            self::ROLE_USER  => 'secondary',   // ✅ NEW
            default          => 'secondary',
        };
    }

    /**
     * Get status badge color for UI.
     */
    public function getStatusBadgeColor(): string
    {
        return $this->status === self::STATUS_ACTIVE ? 'success' : 'secondary';
    }

    /**
     * Get formatted role name.
     */
    public function getRoleName(): string
    {
        return self::getRoles()[$this->role] ?? ucfirst($this->role);
    }

    /**
     * Get formatted status name.
     */
    public function getStatusName(): string
    {
        return self::getStatuses()[$this->status] ?? ucfirst($this->status);
    }

    // ============================================
    // AVATAR HELPERS
    // ============================================

    public function getAvatarUrl(): string
    {
        if ($this->profile_photo) {
            return asset('storage/' . $this->profile_photo);
        }

        $name       = urlencode($this->name);
        $background = $this->getAvatarBackground();

        return "https://ui-avatars.com/api/?name={$name}&background={$background}&color=fff&size=64";
    }

    private function getAvatarBackground(): string
    {
        return match($this->role) {
            self::ROLE_ADMIN => '6C63FF',
            self::ROLE_CLERK => 'FF6B6B',
            self::ROLE_USER  => '6C757D',   // ✅ NEW: Gray for student
            default          => '6C757D',
        };
    }

    public function getProfilePhotoUrl(): string
    {
        if ($this->profile_photo && file_exists(storage_path('app/public/' . $this->profile_photo))) {
            return asset('storage/' . $this->profile_photo);
        }

        return $this->getAvatarUrl();
    }

    // ============================================
    // SCOPES
    // ============================================

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', self::STATUS_INACTIVE);
    }

    public function scopeAdmins($query)
    {
        return $query->where('role', self::ROLE_ADMIN);
    }

    public function scopeClerks($query)
    {
        return $query->where('role', self::ROLE_CLERK);
    }

    public function scopeUsers($query)
    {
        return $query->where('role', self::ROLE_USER);   // ✅ NEW
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'LIKE', "%{$search}%")
              ->orWhere('email', 'LIKE', "%{$search}%")
              ->orWhere('phone', 'LIKE', "%{$search}%");
        });
    }

    // ============================================
    // LOGIN / SESSION HELPERS
    // ============================================

    public function updateLastLogin(): void
    {
        $this->update(['last_login' => now()]);
    }

    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    public function hasAnyRole(array $roles): bool
    {
        return in_array($this->role, $roles);
    }

    public function getFullNameWithRole(): string
    {
        return $this->name . ' (' . $this->getRoleName() . ')';
    }

    public function getFormattedPhone(): ?string
    {
        if (!$this->phone) {
            return null;
        }

        $phone = preg_replace('/[^0-9]/', '', $this->phone);

        if (strlen($phone) === 10) {
            return '(' . substr($phone, 0, 3) . ') ' . substr($phone, 3, 3) . '-' . substr($phone, 6, 4);
        }

        return $this->phone;
    }

    public function isOnline(): bool
    {
        if (!$this->last_login) {
            return false;
        }

        return $this->last_login->diffInMinutes(now()) < 5;
    }

    public function getLastLoginHumanReadable(): string
    {
        if (!$this->last_login) {
            return 'Never';
        }

        return $this->last_login->diffForHumans();
    }

    public function getFormattedLastLogin(): string
    {
        if (!$this->last_login) {
            return 'Never';
        }

        return $this->last_login->format('Y-m-d H:i A');
    }

    public function canBeDeleted(): bool
    {
        // Prevent deleting admin users
        if ($this->isAdmin()) {
            return false;
        }

        // Prevent deleting yourself
        if (auth()->id() === $this->id) {
            return false;
        }

        return true;
    }

    // ============================================
    // STATISTICS
    // ============================================

    public static function getStatistics(): array
    {
        return [
            'total'    => self::count(),
            'active'   => self::active()->count(),
            'inactive' => self::inactive()->count(),
            'admins'   => self::admins()->count(),
            'clerks'   => self::clerks()->count(),
            'users'    => self::users()->count(),      // ✅ NEW
        ];
    }

    // ============================================
    // BOOT
    // ============================================

    protected static function boot()
    {
        parent::boot();

        // Set default values when creating a new user
        static::creating(function ($user) {
            if (empty($user->status)) {
                $user->status = self::STATUS_ACTIVE;
            }

            // ✅ Default role is 'user' for new signups
            if (empty($user->role)) {
                $user->role = self::ROLE_USER;
            }
        });
    }
}