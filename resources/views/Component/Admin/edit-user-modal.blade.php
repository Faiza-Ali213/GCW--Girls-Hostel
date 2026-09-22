@extends('Layout.admin')

@section('page_title', 'Edit User')
@section('page_subtitle', 'Update user information and permissions')

@section('content')
<style>
/* ============================================
   PROFESSIONAL EDIT USER PAGE
   ============================================ */

/* Page Container */
.edit-user-page {
    max-width: 900px;
    margin: 0 auto;
    padding: 10px 0;
}

/* Back Button */
.back-button-wrapper {
    margin-bottom: 24px;
}

.back-button {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 10px 20px;
    color: #64748B;
    font-weight: 500;
    font-size: 14px;
    text-decoration: none;
    border-radius: 10px;
    transition: all 0.3s ease;
    background: #F8FAFC;
    border: 1px solid #E2E8F0;
}

.back-button:hover {
    background: #F1F5F9;
    border-color: #CBD5E1;
    color: #1E293B;
    text-decoration: none;
}

.back-button i {
    font-size: 18px;
}

/* Main Card */
.form-card {
    background: #FFFFFF;
    border-radius: 20px;
    border: 1px solid #E2E8F0;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
}

/* Card Header */
.form-card-header {
    padding: 24px 32px;
    border-bottom: 1px solid #F1F5F9;
    background: #FAFBFC;
    display: flex;
    align-items: center;
    gap: 16px;
}

.header-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: #FEF3C7;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #D97706;
    font-size: 20px;
    flex-shrink: 0;
}

.header-title {
    font-size: 18px;
    font-weight: 700;
    color: #0F172A;
    margin: 0;
}

.header-subtitle {
    font-size: 14px;
    color: #94A3B8;
    margin: 0;
}

/* Form Body */
.form-card-body {
    padding: 32px;
}

/* Form Sections */
.form-section {
    margin-bottom: 32px;
}

.form-section:last-child {
    margin-bottom: 0;
}

.section-label {
    font-size: 13px;
    font-weight: 600;
    color: #64748B;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.section-label::after {
    content: '';
    flex: 1;
    height: 1px;
    background: #E2E8F0;
}

/* Form Groups */
.form-group {
    margin-bottom: 0;
}

.form-control {
    border: 1.5px solid #E2E8F0;
    border-radius: 10px;
    padding: 10px 16px;
    font-size: 14px;
    color: #0F172A;
    transition: all 0.3s ease;
    height: 46px;
}

.form-control:focus {
    border-color: #4F46E5;
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.08);
}

.form-control.is-invalid {
    border-color: #EF4444;
}

.form-control.is-invalid:focus {
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.08);
}

.form-control.is-valid {
    border-color: #10B981;
}

.form-label {
    font-weight: 600;
    font-size: 14px;
    color: #334155;
    margin-bottom: 6px;
}

.form-label i {
    color: #94A3B8;
    margin-right: 6px;
}

.text-danger {
    color: #EF4444;
}

/* Floating Labels */
.floating-group {
    position: relative;
}

.floating-group .form-control {
    height: 56px;
    padding: 20px 16px 6px;
}

.floating-group .form-label {
    position: absolute;
    top: 50%;
    left: 16px;
    transform: translateY(-50%);
    font-weight: 400;
    color: #94A3B8;
    margin: 0;
    transition: all 0.2s ease;
    pointer-events: none;
    font-size: 14px;
}

.floating-group .form-control:focus + .form-label,
.floating-group .form-control:not(:placeholder-shown) + .form-label {
    top: 8px;
    transform: translateY(0);
    font-size: 11px;
    font-weight: 500;
    color: #4F46E5;
}

/* Password Strength */
.password-strength {
    margin-top: 8px;
}

.strength-bar {
    height: 3px;
    background: #E2E8F0;
    border-radius: 4px;
    overflow: hidden;
}

.strength-progress {
    height: 100%;
    width: 0;
    border-radius: 4px;
    transition: all 0.3s ease;
}

.strength-text {
    font-size: 11px;
    color: #94A3B8;
    margin-top: 4px;
    display: block;
}

.strength-text strong {
    font-weight: 600;
}

/* Role & Status Selectors */
.option-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 10px;
}

.option-grid-2 {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 10px;
}

.option-item {
    position: relative;
}

.option-radio {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}

.option-label {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 14px 12px;
    border: 1.5px solid #E2E8F0;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
    background: #FFFFFF;
    text-align: center;
    min-height: 72px;
}

.option-label:hover {
    border-color: #94A3B8;
    background: #F8FAFC;
}

.option-radio:checked + .option-label {
    border-color: #4F46E5;
    background: #EEF2FF;
}

.option-label i {
    font-size: 18px;
    color: #64748B;
    margin-bottom: 4px;
}

.option-radio:checked + .option-label i {
    color: #4F46E5;
}

.option-name {
    font-size: 13px;
    font-weight: 600;
    color: #0F172A;
}

.option-desc {
    font-size: 10px;
    color: #94A3B8;
}

/* Status Option */
.status-label {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    border: 1.5px solid #E2E8F0;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
    background: #FFFFFF;
}

.status-label:hover {
    border-color: #94A3B8;
    background: #F8FAFC;
}

.status-radio:checked + .status-label {
    border-color: #4F46E5;
    background: #EEF2FF;
}

.status-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    flex-shrink: 0;
}

.status-dot.active {
    background: #10B981;
}

.status-dot.inactive {
    background: #EF4444;
}

.status-text {
    flex: 1;
}

.status-name {
    font-weight: 600;
    font-size: 14px;
    color: #0F172A;
}

.status-desc {
    font-size: 12px;
    color: #94A3B8;
}

/* Form Footer */
.form-card-footer {
    padding: 20px 32px 32px;
    border-top: 1px solid #F1F5F9;
    display: flex;
    justify-content: flex-end;
    gap: 12px;
}

.btn {
    padding: 10px 28px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.3s ease;
}

.btn-secondary {
    background: #F1F5F9;
    border: 1px solid #E2E8F0;
    color: #64748B;
}

.btn-secondary:hover {
    background: #E2E8F0;
    color: #0F172A;
}

.btn-primary {
    background: #4F46E5;
    border: none;
    color: #FFFFFF;
}

.btn-primary:hover {
    background: #4338CA;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
    color: #FFFFFF;
}

.btn-primary i {
    margin-right: 8px;
}

.btn-warning {
    background: #F59E0B;
    border: none;
    color: #FFFFFF;
}

.btn-warning:hover {
    background: #D97706;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
    color: #FFFFFF;
}

/* Validation Feedback */
.invalid-feedback {
    font-size: 12px;
    color: #EF4444;
    margin-top: 4px;
}

/* Responsive */
@media (max-width: 768px) {
    .form-card-header {
        padding: 20px;
        flex-direction: column;
        text-align: center;
    }
    
    .form-card-body {
        padding: 20px;
    }
    
    .form-card-footer {
        padding: 16px 20px 20px;
        flex-direction: column;
    }
    
    .form-card-footer .btn {
        width: 100%;
        justify-content: center;
    }
    
    .option-grid {
        grid-template-columns: 1fr;
    }
    
    .option-grid-2 {
        grid-template-columns: 1fr;
    }
    
    .header-title {
        font-size: 16px;
    }
}

@media (max-width: 576px) {
    .edit-user-page {
        padding: 0;
    }
    
    .back-button-wrapper {
        margin-bottom: 16px;
    }
    
    .back-button {
        padding: 8px 16px;
        font-size: 13px;
    }
    
    .form-card-body {
        padding: 16px;
    }
    
    .form-section {
        margin-bottom: 24px;
    }
}
</style>

<div class="edit-user-page">
    <!-- Back Button -->
    <div class="back-button-wrapper">
        <a href="{{ route('users.index') }}" class="back-button">
            <i class="bi bi-arrow-left"></i>
            Back to User Management
        </a>
    </div>

    <!-- Main Form Card -->
    <div class="form-card">
        <!-- Card Header -->
        <div class="form-card-header">
            <div class="header-icon">
                <i class="bi bi-pencil-square"></i>
            </div>
            <div>
                <h4 class="header-title">Edit User</h4>
                <p class="header-subtitle">Update user information and permissions</p>
            </div>
        </div>

        <!-- Form Body -->
        <div class="form-card-body">
            <form action="{{ route('users.update', $user->id) }}" method="POST" id="editUserForm">
                @csrf
                @method('PUT')

                <!-- Personal Information -->
                <div class="form-section">
                    <div class="section-label">
                        <i class="bi bi-person"></i> Personal Information
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="floating-group">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="editName" name="name" placeholder=" " value="{{ old('name', $user->name) }}" required>
                                    <label for="editName" class="form-label">Full Name <span class="text-danger">*</span></label>
                                </div>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="floating-group">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="editEmail" name="email" placeholder=" " value="{{ old('email', $user->email) }}" required>
                                    <label for="editEmail" class="form-label">Email Address <span class="text-danger">*</span></label>
                                </div>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Account Credentials -->
                <div class="form-section">
                    <div class="section-label">
                        <i class="bi bi-key"></i> Account Credentials
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="floating-group">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           id="editPassword" name="password" placeholder=" ">
                                    <label for="editPassword" class="form-label">New Password</label>
                                </div>
                                <div class="password-strength">
                                    <div class="strength-bar">
                                        <div class="strength-progress" id="passwordStrengthProgress"></div>
                                    </div>
                                    <span class="strength-text" id="passwordStrengthText">Leave blank to keep current password</span>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="floating-group">
                                    <input type="password" class="form-control" 
                                           id="editPasswordConfirmation" name="password_confirmation" placeholder=" ">
                                    <label for="editPasswordConfirmation" class="form-label">Confirm New Password</label>
                                </div>
                                <div id="editPasswordConfirmFeedback" class="invalid-feedback" style="display: none;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Role & Status -->
                <div class="form-section">
                    <div class="section-label">
                        <i class="bi bi-shield"></i> Role & Permissions
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">User Role <span class="text-danger">*</span></label>
                                <div class="option-grid">
                                    <div class="option-item">
                                        <input type="radio" name="role" value="admin" id="roleAdmin" class="option-radio" {{ old('role', $user->role) == 'admin' ? 'checked' : '' }} required>
                                        <label for="roleAdmin" class="option-label">
                                            <i class="bi bi-shield-lock"></i>
                                            <span class="option-name">Administrator</span>
                                            <span class="option-desc">Full access</span>
                                        </label>
                                    </div>
                                    <div class="option-item">
                                        <input type="radio" name="role" value="clerk" id="roleClerk" class="option-radio" {{ old('role', $user->role) == 'clerk' ? 'checked' : '' }}>
                                        <label for="roleClerk" class="option-label">
                                            <i class="bi bi-person-badge"></i>
                                            <span class="option-name">Clerk</span>
                                            <span class="option-desc">Manage operations</span>
                                        </label>
                                    </div>
                                </div>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Account Status <span class="text-danger">*</span></label>
                                <div class="option-grid-2">
                                    <div class="option-item">
                                        <input type="radio" name="status" value="active" id="statusActive" class="status-radio option-radio" {{ old('status', $user->status) == 'active' ? 'checked' : '' }}>
                                        <label for="statusActive" class="status-label">
                                            <span class="status-dot active"></span>
                                            <span class="status-text">
                                                <div class="status-name">Active</div>
                                                <div class="status-desc">User can access system</div>
                                            </span>
                                        </label>
                                    </div>
                                    <div class="option-item">
                                        <input type="radio" name="status" value="inactive" id="statusInactive" class="status-radio option-radio" {{ old('status', $user->status) == 'inactive' ? 'checked' : '' }}>
                                        <label for="statusInactive" class="status-label">
                                            <span class="status-dot inactive"></span>
                                            <span class="status-text">
                                                <div class="status-name">Inactive</div>
                                                <div class="status-desc">User access disabled</div>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="form-section">
                    <div class="section-label">
                        <i class="bi bi-telephone"></i> Contact Information
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="floating-group">
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                           id="editPhone" name="phone" placeholder=" " value="{{ old('phone', $user->phone) }}">
                                    <label for="editPhone" class="form-label">Phone Number</label>
                                </div>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="floating-group">
                                    <input type="text" class="form-control @error('address') is-invalid @enderror" 
                                           id="editAddress" name="address" placeholder=" " value="{{ old('address', $user->address) }}">
                                    <label for="editAddress" class="form-label">Address</label>
                                </div>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Footer -->
                <div class="form-card-footer">
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Update User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ============================================
    // PASSWORD STRENGTH CHECKER
    // ============================================
    const passwordInput = document.getElementById('editPassword');
    const confirmInput = document.getElementById('editPasswordConfirmation');
    const strengthBar = document.getElementById('passwordStrengthProgress');
    const strengthText = document.getElementById('passwordStrengthText');
    const confirmFeedback = document.getElementById('editPasswordConfirmFeedback');

    if (passwordInput) {
        passwordInput.addEventListener('keyup', function() {
            const password = this.value;
            let strength = 0;
            let color = '#EF4444';
            let label = 'Weak';
            
            if (password.length === 0) {
                strength = 0;
                color = '#E2E8F0';
                label = 'Leave blank to keep current password';
                if (strengthBar) {
                    strengthBar.style.width = '0%';
                    strengthBar.style.background = color;
                }
                if (strengthText) {
                    strengthText.innerHTML = label;
                    strengthText.style.color = '#94A3B8';
                }
                checkPasswordMatch();
                return;
            }
            
            if (password.length >= 8) {
                strength += 25;
                color = '#F59E0B';
                label = 'Fair';
            }
            if (password.match(/[a-z]/) && password.match(/[A-Z]/)) {
                strength += 25;
                color = '#10B981';
                label = 'Good';
            }
            if (password.match(/\d/)) {
                strength += 25;
                color = '#3B82F6';
                label = 'Strong';
            }
            if (password.match(/[^a-zA-Z\d]/)) {
                strength += 25;
                color = '#8B5CF6';
                label = 'Very Strong';
            }
            
            if (strengthBar) {
                strengthBar.style.width = strength + '%';
                strengthBar.style.background = color;
            }
            
            if (strengthText) {
                strengthText.innerHTML = 'Strength: <strong style="color:' + color + '">' + label + '</strong>';
            }

            checkPasswordMatch();
        });
    }

    if (confirmInput) {
        confirmInput.addEventListener('keyup', checkPasswordMatch);
    }

    function checkPasswordMatch() {
        const password = passwordInput ? passwordInput.value : '';
        const confirm = confirmInput ? confirmInput.value : '';
        
        if (confirmFeedback) {
            if (password.length > 0 && confirm.length > 0) {
                if (password === confirm) {
                    confirmFeedback.innerHTML = '<i class="bi bi-check-circle"></i> Passwords match';
                    confirmFeedback.style.color = '#10B981';
                    confirmFeedback.style.display = 'block';
                    confirmInput.classList.remove('is-invalid');
                    confirmInput.classList.add('is-valid');
                } else {
                    confirmFeedback.innerHTML = '<i class="bi bi-exclamation-circle"></i> Passwords do not match';
                    confirmFeedback.style.color = '#EF4444';
                    confirmFeedback.style.display = 'block';
                    confirmInput.classList.remove('is-valid');
                    confirmInput.classList.add('is-invalid');
                }
            } else if (password.length > 0 && confirm.length === 0) {
                confirmFeedback.innerHTML = '<i class="bi bi-info-circle"></i> Please confirm your password';
                confirmFeedback.style.color = '#F59E0B';
                confirmFeedback.style.display = 'block';
                confirmInput.classList.remove('is-valid', 'is-invalid');
            } else {
                confirmFeedback.style.display = 'none';
                confirmInput.classList.remove('is-valid', 'is-invalid');
            }
        }
    }
});
</script>
@endsection