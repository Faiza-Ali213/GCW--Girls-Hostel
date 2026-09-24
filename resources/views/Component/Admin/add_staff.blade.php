@extends('Layout.admin')

@section('content')
<div class="staff-container">

    <!-- Page Header -->
    <div class="page-header-section mb-4">
        <a href="{{ route('staff_records') }}" class="btn btn-light mb-3">
            <i class="bi bi-arrow-left"></i> Back to Staff Records
        </a>
        <h2><i class="bi bi-person-plus me-2" style="color: #4F46E5;"></i>Add New Staff</h2>
        <p class="text-muted">Fill in the details below to add a new staff member.</p>
    </div>

    <!-- Form Card -->
    <div class="form-card">
        <form action="{{ route('staff.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-3">

                <!-- Name -->
                <div class="col-md-6">
                    <label class="form-label">Full Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" 
                           class="form-control @error('name') is-invalid @enderror" 
                           value="{{ old('name') }}" 
                           placeholder="Enter full name" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Role -->
                <div class="col-md-6">
                    <label class="form-label">Role <span class="text-danger">*</span></label>
                    <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                        <option value="">Select Role</option>
                        <option value="Warden" {{ old('role') == 'Warden' ? 'selected' : '' }}>Warden</option>
                        <option value="Cook" {{ old('role') == 'Cook' ? 'selected' : '' }}>Cook</option>
                        <option value="Security Guard" {{ old('role') == 'Security Guard' ? 'selected' : '' }}>Security Guard</option>
                        <option value="Cleaner" {{ old('role') == 'Cleaner' ? 'selected' : '' }}>Cleaner</option>
                        <option value="Peon" {{ old('role') == 'Peon' ? 'selected' : '' }}>Peon</option>
                        <option value="Other" {{ old('role') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Phone -->
                <div class="col-md-6">
                    <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                    <input type="text" name="phone" 
                           class="form-control @error('phone') is-invalid @enderror" 
                           value="{{ old('phone') }}" 
                           placeholder="e.g., 0300-1234567" required>
                    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- ✅ CNIC (NEW) -->
                <div class="col-md-6">
                    <label class="form-label">CNIC</label>
                    <input type="text" name="cnic" 
                           class="form-control @error('cnic') is-invalid @enderror" 
                           value="{{ old('cnic') }}" 
                           placeholder="e.g., 35202-1234567-1"
                           maxlength="15">
                    @error('cnic') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Duty / Shift -->
                <div class="col-md-6">
                    <label class="form-label">Duty / Shift <span class="text-danger">*</span></label>
                    <select name="duty_shift" class="form-select @error('duty_shift') is-invalid @enderror" required>
                        <option value="">Select Shift</option>
                        <option value="Morning" {{ old('duty_shift') == 'Morning' ? 'selected' : '' }}>Morning (6AM - 2PM)</option>
                        <option value="Evening" {{ old('duty_shift') == 'Evening' ? 'selected' : '' }}>Evening (2PM - 10PM)</option>
                        <option value="Night" {{ old('duty_shift') == 'Night' ? 'selected' : '' }}>Night (10PM - 6AM)</option>
                        <option value="Full Day" {{ old('duty_shift') == 'Full Day' ? 'selected' : '' }}>Full Day</option>
                    </select>
                    @error('duty_shift') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Email -->
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           value="{{ old('email') }}" 
                           placeholder="staff@example.com">
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Address -->
                <div class="col-md-6">
                    <label class="form-label">Address</label>
                    <input type="text" name="address" 
                           class="form-control @error('address') is-invalid @enderror" 
                           value="{{ old('address') }}" 
                           placeholder="Enter address">
                    @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Joining Date -->
                <div class="col-md-6">
                    <label class="form-label">Joining Date</label>
                    <input type="date" name="joining_date" 
                           class="form-control @error('joining_date') is-invalid @enderror" 
                           value="{{ old('joining_date') }}">
                    @error('joining_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Salary -->
                <div class="col-md-6">
                    <label class="form-label">Salary</label>
                    <input type="number" name="salary" 
                           class="form-control @error('salary') is-invalid @enderror" 
                           value="{{ old('salary') }}" 
                           placeholder="e.g., 25000">
                    @error('salary') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Status -->
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror">
                        <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Remarks -->
                <div class="col-12">
                    <label class="form-label">Remarks</label>
                    <textarea name="remarks" rows="3" 
                              class="form-control @error('remarks') is-invalid @enderror" 
                              placeholder="Any additional notes...">{{ old('remarks') }}</textarea>
                    @error('remarks') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Profile Picture -->
                <div class="col-md-6">
                    <label class="form-label">Profile Picture</label>
                    <input type="file" name="profile_picture" 
                           class="form-control @error('profile_picture') is-invalid @enderror" 
                           accept="image/*">
                    @error('profile_picture') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Submit Buttons -->
                <div class="col-12 mt-4 d-flex justify-content-end gap-2">
                    <a href="{{ route('staff_records') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Save Staff
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>

<style>
    .staff-container { padding: 20px 0; }
    .page-header-section h2 {
        font-weight: 700;
        color: #0b1a33;
        font-size: 1.8rem;
    }
    .form-card {
        background: white;
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.05);
    }
    .form-label {
        font-weight: 600;
        color: #334155;
        margin-bottom: 6px;
    }
    .form-control, .form-select {
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        padding: 10px 14px;
        font-size: 0.95rem;
    }
    .form-control:focus, .form-select:focus {
        border-color: #4F46E5;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.08);
    }
    .btn-primary {
        background: linear-gradient(135deg, #4F46E5 0%, #4338CA 100%);
        border: none;
        padding: 10px 25px;
        border-radius: 10px;
        font-weight: 600;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(79, 70, 229, 0.3);
    }
    .btn-secondary {
        background: #f1f5f9;
        border: none;
        color: #64748b;
        padding: 10px 25px;
        border-radius: 10px;
        font-weight: 600;
    }
</style>
@endsection