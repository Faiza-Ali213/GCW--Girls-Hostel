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
     *
     * @var array<int, string>
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
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login' => 'datetime',
        ];
    }

    /**
     * Role Constants
     */
    const ROLE_ADMIN = 'admin';
    const ROLE_CLERK = 'clerk';

    /**
     * Status Constants
     */
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    /**
     * Get all available roles
     */
    public static function getRoles(): array
    {
        return [
            self::ROLE_ADMIN => 'Administrator',
            self::ROLE_CLERK => 'Clerk',
        ];
    }

    /**
     * Get all available statuses
     */
    public static function getStatuses(): array
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_INACTIVE => 'Inactive',
        ];
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * Check if user is clerk
     */
    public function isClerk(): bool
    {
        return $this->role === self::ROLE_CLERK;
    }

    /**
     * Check if user is active
     */
    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    /**
     * Check if user is inactive
     */
    public function isInactive(): bool
    {
        return $this->status === self::STATUS_INACTIVE;
    }

    /**
     * Get role badge color for UI
     */
    public function getRoleBadgeColor(): string
    {
        return match($this->role) {
            self::ROLE_ADMIN => 'danger',
            self::ROLE_CLERK => 'warning',
            default => 'secondary',
        };
    }

    /**
     * Get status badge color for UI
     */
    public function getStatusBadgeColor(): string
    {
        return $this->status === self::STATUS_ACTIVE ? 'success' : 'secondary';
    }

    /**
     * Get formatted role name
     */
    public function getRoleName(): string
    {
        return self::getRoles()[$this->role] ?? ucfirst($this->role);
    }

    /**
     * Get formatted status name
     */
    public function getStatusName(): string
    {
        return self::getStatuses()[$this->status] ?? ucfirst($this->status);
    }

    /**
     * Get user avatar URL
     */
    public function getAvatarUrl(): string
    {
        if ($this->profile_photo) {
            return asset('storage/' . $this->profile_photo);
        }
        
        // Generate avatar from name using UI Avatars API
        $name = urlencode($this->name);
        $background = $this->getAvatarBackground();
        return "https://ui-avatars.com/api/?name={$name}&background={$background}&color=fff&size=64";
    }

    /**
     * Get avatar background color based on role
     */
    private function getAvatarBackground(): string
    {
        return match($this->role) {
            self::ROLE_ADMIN => '6C63FF',
            self::ROLE_CLERK => 'FF6B6B',
            default => '6C757D',
        };
    }

    /**
     * Scope for active users
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * Scope for inactive users
     */
    public function scopeInactive($query)
    {
        return $query->where('status', self::STATUS_INACTIVE);
    }

    /**
     * Scope for admin users
     */
    public function scopeAdmins($query)
    {
        return $query->where('role', self::ROLE_ADMIN);
    }

    /**
     * Scope for clerk users
     */
    public function scopeClerks($query)
    {
        return $query->where('role', self::ROLE_CLERK);
    }

    /**
     * Scope for search
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%");
    }

    /**
     * Update last login timestamp
     */
    public function updateLastLogin(): void
    {
        $this->update(['last_login' => now()]);
    }

    /**
     * Check if user has specific role
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    /**
     * Check if user has any of the given roles
     */
    public function hasAnyRole(array $roles): bool
    {
        return in_array($this->role, $roles);
    }

    /**
     * Get the user's full name with role
     */
    public function getFullNameWithRole(): string
    {
        return $this->name . ' (' . $this->getRoleName() . ')';
    }

    /**
     * Get formatted phone number
     */
    public function getFormattedPhone(): ?string
    {
        if (!$this->phone) {
            return null;
        }
        
        // Remove all non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $this->phone);
        
        // Format based on length
        if (strlen($phone) === 10) {
            return '(' . substr($phone, 0, 3) . ') ' . substr($phone, 3, 3) . '-' . substr($phone, 6, 4);
        }
        
        return $this->phone;
    }

    /**
     * Check if the user is online (last login within 5 minutes)
     */
    public function isOnline(): bool
    {
        if (!$this->last_login) {
            return false;
        }
        
        return $this->last_login->diffInMinutes(now()) < 5;
    }

    /**
     * Get human-readable last login
     */
    public function getLastLoginHumanReadable(): string
    {
        if (!$this->last_login) {
            return 'Never';
        }
        
        return $this->last_login->diffForHumans();
    }

    /**
     * Get formatted last login
     */
    public function getFormattedLastLogin(): string
    {
        if (!$this->last_login) {
            return 'Never';
        }
        
        return $this->last_login->format('Y-m-d H:i A');
    }

    /**
     * Check if user can be deleted
     */
    public function canBeDeleted(): bool
    {
        // Prevent deleting admin users or yourself
        if ($this->isAdmin()) {
            return false;
        }
        
        // Prevent deleting yourself
        if (auth()->id() === $this->id) {
            return false;
        }
        
        return true;
    }

    /**
     * Get profile photo URL
     */
    public function getProfilePhotoUrl(): string
    {
        if ($this->profile_photo && file_exists(storage_path('app/public/' . $this->profile_photo))) {
            return asset('storage/' . $this->profile_photo);
        }
        
        return $this->getAvatarUrl();
    }

    /**
     * Get user statistics
     */
    public static function getStatistics(): array
    {
        return [
            'total' => self::count(),
            'active' => self::active()->count(),
            'inactive' => self::inactive()->count(),
            'admins' => self::admins()->count(),
            'clerks' => self::clerks()->count(),
        ];
    }

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();
        
        // Set default values when creating
        static::creating(function ($user) {
            if (empty($user->status)) {
                $user->status = self::STATUS_ACTIVE;
            }
            if (empty($user->role)) {
                $user->role = self::ROLE_CLERK;
            }
        });
    }
}