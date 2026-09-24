@extends('Layout.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Staff Member</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('staff.update', $staff->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Name *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $staff->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Role *</label>
                            <select class="form-control @error('role') is-invalid @enderror" 
                                    id="role" name="role" required>
                                <option value="">Select Role</option>
                                <option value="Warden" {{ old('role', $staff->role) == 'Warden' ? 'selected' : '' }}>Warden</option>
                                <option value="Kitchen Staff" {{ old('role', $staff->role) == 'Kitchen Staff' ? 'selected' : '' }}>Kitchen Staff</option>
                                <option value="Cleaner" {{ old('role', $staff->role) == 'Cleaner' ? 'selected' : '' }}>Cleaner</option>
                                <option value="Security Guard" {{ old('role', $staff->role) == 'Security Guard' ? 'selected' : '' }}>Security Guard</option>
                                <option value="Maintenance" {{ old('role', $staff->role) == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                                <option value="Administrator" {{ old('role', $staff->role) == 'Administrator' ? 'selected' : '' }}>Administrator</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Phone Number *</label>
                            <input type="text" class="form-control @error('phone_number') is-invalid @enderror" 
                                   id="phone_number" name="phone_number" value="{{ old('phone_number', $staff->phone_number) }}" required>
                            @error('phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- ✅ CNIC FIELD (NEW) --}}
                        <div class="mb-3">
                            <label for="cnic" class="form-label">CNIC</label>
                            <input type="text" class="form-control @error('cnic') is-invalid @enderror" 
                                   id="cnic" name="cnic" value="{{ old('cnic', $staff->cnic) }}" 
                                   placeholder="e.g., 35202-1234567-1"
                                   maxlength="15">
                            @error('cnic')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="duty_shift" class="form-label">Duty / Shift *</label>
                            <select class="form-control @error('duty_shift') is-invalid @enderror" 
                                    id="duty_shift" name="duty_shift" required>
                                <option value="">Select Shift</option>
                                <option value="Morning (8 AM - 4 PM)" {{ old('duty_shift', $staff->duty_shift) == 'Morning (8 AM - 4 PM)' ? 'selected' : '' }}>Morning (8 AM - 4 PM)</option>
                                <option value="Evening (4 PM - 12 AM)" {{ old('duty_shift', $staff->duty_shift) == 'Evening (4 PM - 12 AM)' ? 'selected' : '' }}>Evening (4 PM - 12 AM)</option>
                                <option value="Night (12 AM - 8 AM)" {{ old('duty_shift', $staff->duty_shift) == 'Night (12 AM - 8 AM)' ? 'selected' : '' }}>Night (12 AM - 8 AM)</option>
                                <option value="Full Day" {{ old('duty_shift', $staff->duty_shift) == 'Full Day' ? 'selected' : '' }}>Full Day</option>
                            </select>
                            @error('duty_shift')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email', $staff->email) }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                      id="address" name="address" rows="2">{{ old('address', $staff->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="joining_date" class="form-label">Joining Date</label>
                            <input type="date" class="form-control @error('joining_date') is-invalid @enderror" 
                                   id="joining_date" name="joining_date" value="{{ old('joining_date', $staff->joining_date?->format('Y-m-d')) }}">
                            @error('joining_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="salary" class="form-label">Salary</label>
                            <input type="number" step="0.01" class="form-control @error('salary') is-invalid @enderror" 
                                   id="salary" name="salary" value="{{ old('salary', $staff->salary) }}">
                            @error('salary')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control @error('status') is-invalid @enderror" 
                                    id="status" name="status">
                                <option value="active" {{ old('status', $staff->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $staff->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('staff.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Staff</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection