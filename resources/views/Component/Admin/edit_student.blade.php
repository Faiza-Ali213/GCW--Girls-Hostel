@extends('Layout.admin')

@section('content')
<style>
    .page-header-section { margin-bottom: 25px; }
    .page-header-section h2 { font-weight: 700; color: #2c3e50; margin-bottom: 5px; }
    .page-header-section .text-muted { font-size: 0.95rem; }

    .form-card {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .form-section {
        margin-bottom: 30px;
        padding-bottom: 25px;
        border-bottom: 1px solid #e9ecef;
    }
    .form-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .section-title {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .section-title i { color: #667eea; }

    .custom-input {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 12px 15px;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }
    .custom-input:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
    }
    .custom-input.is-invalid { border-color: #dc3545; }
    .custom-input.is-valid { border-color: #10B981; background-color: #ECFDF5; }

    .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 8px;
        font-size: 0.9rem;
    }
    .text-danger { color: #dc3545; }
    .text-success { color: #10B981; }
    .text-warning { color: #F59E0B; }
    .text-muted { color: #6c757d; }

    .room-status {
        padding: 8px 12px;
        border-radius: 8px;
        margin-top: 5px;
        font-weight: 500;
        font-size: 0.9rem;
    }
    .room-status.available { background: #ECFDF5; color: #10B981; border: 1px solid #10B981; }
    .room-status.full { background: #FEF2F2; color: #EF4444; border: 1px solid #EF4444; }
    .room-status.not-found { background: #FFFBEB; color: #F59E0B; border: 1px solid #F59E0B; }
    .room-status.loading { background: #EFF6FF; color: #3B82F6; border: 1px solid #3B82F6; }
    .room-status.current { background: #EEF2FF; color: #4F46E5; border: 1px solid #4F46E5; }

    .cnic-status {
        font-size: 0.85rem;
        margin-top: 5px;
        display: block;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        padding-top: 20px;
        border-top: 2px solid #f1f3f5;
        margin-top: 10px;
        flex-wrap: wrap;
    }

    .btn {
        padding: 10px 30px;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: none;
    }

    .btn-save {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }
    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        color: white;
    }
    .btn-save:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none !important;
    }

    .btn-cancel {
        background: #f1f3f5;
        color: #6c757d;
    }
    .btn-cancel:hover {
        background: #e9ecef;
        color: #495057;
    }

    @media (max-width: 768px) {
        .form-card { padding: 20px 15px; }
        .form-actions { flex-direction: column; }
        .form-actions .btn { width: 100%; justify-content: center; }
    }
</style>

<div class="student-container">
    
    <div class="page-header-section">
        <h2>Edit Student</h2>
        <p class="text-muted">Update the details of the resident in GCW Hostel.</p>
    </div>

    <div class="form-card">
        <form id="editStudentForm" action="{{ route('student.update', $student->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-section">
                <h5 class="section-title">
                    <i class="bi bi-person-badge"></i> Personal Information
                </h5>
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label">Student Name <span class="text-danger">*</span></label>
                        <input type="text" name="student_name" class="form-control custom-input @error('student_name') is-invalid @enderror" 
                               placeholder="Enter full name" value="{{ old('student_name', $student->student_name) }}" required>
                        @error('student_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Father Name <span class="text-danger">*</span></label>
                        <input type="text" name="father_name" class="form-control custom-input @error('father_name') is-invalid @enderror" 
                               placeholder="Enter father's name" value="{{ old('father_name', $student->father_name) }}" required>
                        @error('father_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                        <input type="tel" name="phone_number" class="form-control custom-input @error('phone_number') is-invalid @enderror" 
                               id="phoneInput" placeholder="0300-1234567" value="{{ old('phone_number', $student->phone_number) }}" required>
                        @error('phone_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- ✅ CNIC FIELD - STRICT 13 DIGITS -->
                    <div class="col-md-6">
                        <label class="form-label">CNIC Number <span class="text-danger">*</span></label>
                        <input type="text" 
                               name="cnic_number" 
                               class="form-control custom-input @error('cnic_number') is-invalid @enderror" 
                               id="cnicInput" 
                               placeholder="34101-1234567-8" 
                               value="{{ old('cnic_number', $student->cnic_number) }}" 
                               maxlength="15"
                               pattern="[0-9]{5}-[0-9]{7}-[0-9]{1}"
                               title="CNIC 13 digits ka hona chahiye (e.g., 34101-1234567-8)"
                               required>
                        <small class="cnic-status text-muted" id="cnicStatus">
                            <i class="bi bi-info-circle"></i> Format: 34101-1234567-8 (13 digits)
                        </small>
                        @error('cnic_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control custom-input @error('email') is-invalid @enderror" 
                               placeholder="student@example.com" value="{{ old('email', $student->email) }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Admission Date <span class="text-danger">*</span></label>
                        <input type="date" name="admission_date" class="form-control custom-input @error('admission_date') is-invalid @enderror" 
                               value="{{ old('admission_date', $student->admission_date ? $student->admission_date->format('Y-m-d') : '') }}" required>
                        @error('admission_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Address <span class="text-danger">*</span></label>
                        <textarea name="address" class="form-control custom-input @error('address') is-invalid @enderror" 
                                  rows="3" placeholder="Enter complete address" required>{{ old('address', $student->address) }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h5 class="section-title">
                    <i class="bi bi-building"></i> Hostel Information
                </h5>
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label">Room Number</label>
                        <input type="text" name="room_number" 
                               class="form-control custom-input @error('room_number') is-invalid @enderror" 
                               id="room_number" 
                               placeholder="Enter room number (e.g., 101)" 
                               value="{{ old('room_number', $student->room_number) }}">
                        <div id="roomStatus" class="room-status current" style="display:{{ $student->room_number ? 'block' : 'none' }};">
                            <i class="bi bi-info-circle"></i> 
                            @if($student->room_number)
                                Current Room: {{ $student->room_number }} 
                                @if($student->room)
                                    ({{ $student->room->room_type }} - {{ $student->room->current_occupancy }}/{{ $student->room->capacity }} occupied)
                                @endif
                            @else
                                No room assigned
                            @endif
                        </div>
                        @error('room_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Hostel Status</label>
                        <select name="hostel_status" class="form-control custom-input @error('hostel_status') is-invalid @enderror">
                            <option value="active" {{ old('hostel_status', $student->hostel_status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('hostel_status', $student->hostel_status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="graduated" {{ old('hostel_status', $student->hostel_status) == 'graduated' ? 'selected' : '' }}>Graduated</option>
                            <option value="left" {{ old('hostel_status', $student->hostel_status) == 'left' ? 'selected' : '' }}>Left</option>
                        </select>
                        @error('hostel_status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h5 class="section-title">
                    <i class="bi bi-phone"></i> Contact & Emergency
                </h5>
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label">Guardian Contact</label>
                        <input type="text" name="guardian_contact" class="form-control custom-input @error('guardian_contact') is-invalid @enderror" 
                               placeholder="0300-1234567" value="{{ old('guardian_contact', $student->guardian_contact) }}">
                        @error('guardian_contact')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Emergency Contact</label>
                        <input type="text" name="emergency_contact" class="form-control custom-input @error('emergency_contact') is-invalid @enderror" 
                               placeholder="0300-7654321" value="{{ old('emergency_contact', $student->emergency_contact) }}">
                        @error('emergency_contact')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h5 class="section-title">
                    <i class="bi bi-clipboard"></i> Additional Information
                </h5>
                <div class="row g-4">
                    <div class="col-12">
                        <label class="form-label">Profile Picture</label>
                        @if($student->profile_picture)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $student->profile_picture) }}" 
                                     alt="{{ $student->student_name }}" 
                                     style="width: 80px; height: 80px; object-fit: cover; border-radius: 10px; border: 2px solid #e9ecef;">
                                <small class="text-muted d-block">Current profile picture</small>
                            </div>
                        @endif
                        <input type="file" name="profile_picture" class="form-control custom-input @error('profile_picture') is-invalid @enderror" 
                               accept="image/*">
                        <small class="text-muted">Maximum file size: 2MB. Supported formats: JPG, PNG, GIF</small>
                        @error('profile_picture')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Medical Conditions</label>
                        <textarea name="medical_conditions" class="form-control custom-input @error('medical_conditions') is-invalid @enderror" 
                                  rows="2" placeholder="Any medical conditions or allergies">{{ old('medical_conditions', $student->medical_conditions) }}</textarea>
                        @error('medical_conditions')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Remarks</label>
                        <textarea name="remarks" class="form-control custom-input @error('remarks') is-invalid @enderror" 
                                  rows="2" placeholder="Any additional remarks">{{ old('remarks', $student->remarks) }}</textarea>
                        @error('remarks')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('student-records') }}" class="btn btn-cancel">
                    <i class="bi bi-x-circle"></i> Cancel
                </a>
                <button type="submit" class="btn btn-save" id="submitBtn">
                    <i class="bi bi-check-circle"></i> Update Student
                </button>
            </div>

        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
// ✅ PURE JAVASCRIPT - No jQuery dependency
document.addEventListener('DOMContentLoaded', function() {
    console.log('✅ Edit Student page loaded');

    var cnicInput = document.getElementById('cnicInput');
    var cnicStatus = document.getElementById('cnicStatus');
    var phoneInput = document.getElementById('phoneInput');
    var roomInput = document.getElementById('room_number');
    var roomStatusDiv = document.getElementById('roomStatus');
    var submitBtn = document.getElementById('submitBtn');
    var form = document.getElementById('editStudentForm');
    var currentRoomNumber = '{{ $student->room_number }}';
    var roomValid = false;
    var roomData = null;
    var roomValidationTimer = null;

    // ============================================
    // ✅ CNIC - STRICT 13 DIGITS ONLY
    // ============================================
    if (cnicInput) {
        cnicInput.addEventListener('input', function(e) {
            var value = e.target.value.replace(/\D/g, ''); // Sirf digits
            
            // ✅ 13 digits se zyada na hone dein
            if (value.length > 13) {
                value = value.substring(0, 13);
            }
            
            // Auto-format with dashes
            var formatted = value;
            if (value.length > 5 && value.length <= 12) {
                formatted = value.slice(0, 5) + '-' + value.slice(5);
            } else if (value.length > 12) {
                formatted = value.slice(0, 5) + '-' + value.slice(5, 12) + '-' + value.slice(12, 13);
            }
            
            e.target.value = formatted;
            
            // Live status update
            if (cnicStatus) {
                if (value.length === 0) {
                    cnicStatus.innerHTML = '<i class="bi bi-info-circle"></i> Format: 34101-1234567-8 (13 digits)';
                    cnicStatus.className = 'cnic-status text-muted';
                    cnicInput.classList.remove('is-valid', 'is-invalid');
                } else if (value.length < 13) {
                    cnicStatus.innerHTML = '<i class="bi bi-exclamation-circle"></i> ' + value.length + '/13 digits entered';
                    cnicStatus.className = 'cnic-status text-danger';
                    cnicInput.classList.remove('is-valid');
                    cnicInput.classList.add('is-invalid');
                } else {
                    cnicStatus.innerHTML = '<i class="bi bi-check-circle"></i> Valid CNIC (13 digits)';
                    cnicStatus.className = 'cnic-status text-success';
                    cnicInput.classList.remove('is-invalid');
                    cnicInput.classList.add('is-valid');
                }
            }
        });
        
        // ✅ Paste event - enforce 13 digits
        cnicInput.addEventListener('paste', function(e) {
            e.preventDefault();
            var pastedText = (e.clipboardData || window.clipboardData).getData('text');
            var value = pastedText.replace(/\D/g, '');
            
            if (value.length > 13) {
                value = value.substring(0, 13);
            }
            
            var formatted = value;
            if (value.length > 5 && value.length <= 12) {
                formatted = value.slice(0, 5) + '-' + value.slice(5);
            } else if (value.length > 12) {
                formatted = value.slice(0, 5) + '-' + value.slice(5, 12) + '-' + value.slice(12, 13);
            }
            
            cnicInput.value = formatted;
            cnicInput.dispatchEvent(new Event('input'));
        });
    }

    // ============================================
    // PHONE FORMAT
    // ============================================
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            var value = e.target.value.replace(/\D/g, '');
            if (value.length > 0) {
                if (value.length <= 4) {
                    e.target.value = value;
                } else if (value.length <= 7) {
                    e.target.value = value.slice(0, 4) + '-' + value.slice(4);
                } else {
                    e.target.value = value.slice(0, 4) + '-' + value.slice(4, 7) + '-' + value.slice(7, 11);
                }
            }
        });
    }

    // ============================================
    // ROOM NUMBER VALIDATION
    // ============================================
    if (roomInput) {
        roomInput.addEventListener('input', function(e) {
            var roomNumber = e.target.value.trim();
            
            if (roomValidationTimer) {
                clearTimeout(roomValidationTimer);
            }
            
            if (!roomNumber) {
                if (roomStatusDiv) {
                    roomStatusDiv.style.display = 'block';
                    roomStatusDiv.className = 'room-status current';
                    roomStatusDiv.innerHTML = '<i class="bi bi-info-circle"></i> No room assigned';
                }
                roomValid = true;
                roomData = null;
                roomInput.classList.remove('is-valid', 'is-invalid');
                if (submitBtn) submitBtn.disabled = false;
                return;
            }
            
            if (roomNumber === currentRoomNumber) {
                if (roomStatusDiv) {
                    roomStatusDiv.style.display = 'block';
                    roomStatusDiv.className = 'room-status current';
                    roomStatusDiv.innerHTML = '<i class="bi bi-info-circle"></i> Current Room: ' + roomNumber;
                }
                roomValid = true;
                roomData = null;
                roomInput.classList.remove('is-valid', 'is-invalid');
                if (submitBtn) submitBtn.disabled = false;
                return;
            }
            
            if (roomStatusDiv) {
                roomStatusDiv.style.display = 'block';
                roomStatusDiv.className = 'room-status loading';
                roomStatusDiv.innerHTML = '<i class="bi bi-hourglass-split"></i> Checking room availability...';
            }
            roomInput.classList.remove('is-valid', 'is-invalid');
            if (submitBtn) submitBtn.disabled = true;
            
            // Debounce
            roomValidationTimer = setTimeout(function() {
                // Use fetch instead of jQuery AJAX
                fetch('{{ route("student.validateRoom") }}?room_number=' + encodeURIComponent(roomNumber), {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(function(response) { return response.json(); })
                .then(function(response) {
                    console.log('Room validation response:', response);
                    
                    if (response.success) {
                        var room = response.data;
                        
                        if (room.current_occupancy < room.capacity) {
                            if (roomStatusDiv) {
                                roomStatusDiv.className = 'room-status available';
                                roomStatusDiv.innerHTML = '<i class="bi bi-check-circle-fill"></i> Room ' + room.room_number + 
                                    ' is available! (' + room.current_occupancy + '/' + room.capacity + ' occupied)';
                            }
                            roomInput.classList.remove('is-invalid');
                            roomInput.classList.add('is-valid');
                            roomValid = true;
                            roomData = room;
                            if (submitBtn) submitBtn.disabled = false;
                        } else {
                            if (roomStatusDiv) {
                                roomStatusDiv.className = 'room-status full';
                                roomStatusDiv.innerHTML = '<i class="bi bi-x-circle-fill"></i> Room is FULL!';
                            }
                            roomInput.classList.remove('is-valid');
                            roomInput.classList.add('is-invalid');
                            roomValid = false;
                            roomData = null;
                            if (submitBtn) submitBtn.disabled = true;
                        }
                    } else {
                        if (roomStatusDiv) {
                            roomStatusDiv.className = 'room-status not-found';
                            roomStatusDiv.innerHTML = '<i class="bi bi-exclamation-triangle-fill"></i> ' + response.message;
                        }
                        roomInput.classList.remove('is-valid');
                        roomInput.classList.add('is-invalid');
                        roomValid = false;
                        roomData = null;
                        if (submitBtn) submitBtn.disabled = true;
                    }
                })
                .catch(function(error) {
                    console.error('Error:', error);
                    if (roomStatusDiv) {
                        roomStatusDiv.className = 'room-status not-found';
                        roomStatusDiv.innerHTML = '<i class="bi bi-exclamation-triangle-fill"></i> Error checking room.';
                    }
                    roomValid = false;
                    roomData = null;
                    if (submitBtn) submitBtn.disabled = true;
                });
            }, 500);
        });
    }

    // ============================================
    // FORM SUBMISSION - Validate CNIC (STRICT)
    // ============================================
    if (form) {
        form.addEventListener('submit', function(e) {
            var cnicValue = cnicInput ? cnicInput.value.replace(/\D/g, '') : '';
            
            // ✅ CNIC must be exactly 13 digits
            if (cnicValue.length !== 13) {
                e.preventDefault();
                alert('❌ CNIC 13 digits ka hona chahiye.\n\nAapne ' + cnicValue.length + ' digits enter ki hain.\n\nSahi format: 34101-1234567-8');
                if (cnicInput) cnicInput.focus();
                return false;
            }
            
            // Room validation
            var roomNumber = roomInput ? roomInput.value.trim() : '';
            if (roomNumber && roomNumber !== currentRoomNumber) {
                if (!roomValid || !roomData) {
                    e.preventDefault();
                    alert('Please enter a valid room number with available space.');
                    if (roomInput) roomInput.focus();
                    return false;
                }
                
                // Add room_id and room_type to form
                var roomIdInput = document.createElement('input');
                roomIdInput.type = 'hidden';
                roomIdInput.name = 'room_id';
                roomIdInput.value = roomData.id;
                form.appendChild(roomIdInput);
                
                var roomTypeInput = document.createElement('input');
                roomTypeInput.type = 'hidden';
                roomTypeInput.name = 'room_type';
                roomTypeInput.value = roomData.room_type;
                form.appendChild(roomTypeInput);
            }
            
            return true;
        });
    }

    console.log('✅ CNIC, Phone and Room validation active');
});
</script>
@endpush