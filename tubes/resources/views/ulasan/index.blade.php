<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ulasan Pelanggan - Zona Elo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('ulasan.css') }}">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/">
            <i class="fas fa-campground me-2"></i>ZONA ELO
        </a>
    </div>
</nav>

<div class="container mt-5 mb-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold display-5 mb-3" style="color: #2c3e50;">Ulasan Pelanggan Zona Elo</h1>
        <p class="lead text-muted">Bagikan pengalaman Anda dan bantu pelanggan lainnya</p>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- CREATE: Form Tambah Ulasan -->
    <div class="card mb-5 p-4 shadow">
        <h4 class="mb-4"><i class="fas fa-edit me-2"></i>Beri Ulasan Anda</h4>
        
        <form action="{{ route('ulasan.store') }}" method="POST" id="ulasanForm">
            @csrf
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Nama Lengkap *</label>
                    <input type="text" class="form-control" name="nama" required 
                           value="{{ old('nama') }}" placeholder="Masukkan nama Anda">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Email</label>
                    <input type="email" class="form-control" name="email" 
                           value="{{ old('email') }}" placeholder="email@contoh.com (opsional)">
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Rating *</label>
                <div class="rating-stars" id="ratingStars">
                    @for($i = 1; $i <= 5; $i++)
                        <span onclick="setRating({{ $i }})" 
                              class="star-selector" 
                              data-value="{{ $i }}"
                              style="color: #ccc; cursor: pointer;">★</span>
                    @endfor
                </div>
                <input type="hidden" name="rating" id="ratingInput" value="{{ old('rating', 0) }}" required>
                <small class="text-muted">Klik bintang untuk memilih rating (1 = buruk, 5 = sangat baik)</small>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Ulasan Anda *</label>
                <textarea class="form-control" name="komentar" rows="4" 
                          placeholder="Ceritakan pengalaman Anda di Zona Elo..." 
                          maxlength="500" required>{{ old('komentar') }}</textarea>
                <div class="form-text">Maksimal 500 karakter</div>
            </div>
            
            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-paper-plane me-2"></i>Kirim Ulasan
                </button>
            </div>
        </form>
    </div>

    <!-- READ: Daftar Ulasan -->
    <h3 class="mb-4"><i class="fas fa-comments me-2"></i>Ulasan Pelanggan 
        <span class="badge bg-primary">{{ $ulasans->count() }}</span>
    </h3>
    
    @if($ulasans->count() > 0)
        @foreach($ulasans as $ulasan)
        <div class="card mb-4 p-4 shadow review-card">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="d-flex align-items-center">
                    <div class="reviewer-avatar">
                        {{ strtoupper(substr($ulasan->nama, 0, 1)) }}
                    </div>
                    <div>
                        <h5 class="mb-1">{{ $ulasan->nama }}</h5>
                        @if($ulasan->email)
                            <small class="text-muted">{{ $ulasan->email }}</small>
                        @endif
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div>
                    <!-- Edit Button -->
                    <button class="btn btn-warning btn-sm btn-action" data-bs-toggle="modal" 
                            data-bs-target="#editModal{{ $ulasan->id_ulasan }}">
                        <i class="fas fa-edit"></i>
                    </button>
                    
                    <!-- Delete Button -->
                    <form action="{{ route('ulasan.destroy', $ulasan->id_ulasan) }}" 
                          method="POST" style="display:inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm btn-action" 
                                onclick="return confirm('Hapus ulasan?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Rating -->
            <div class="my-2">
                @for($i = 1; $i <= 5; $i++)
                    <span style="color: {{ $i <= $ulasan->rating ? '#ffc700' : '#ccc' }}">★</span>
                @endfor
                <small class="text-muted">({{ $ulasan->rating }} bintang)</small>
            </div>
            
            <!-- Komentar -->
            <p>{{ $ulasan->komentar }}</p>
            
            <!-- Tanggal -->
            <small class="text-muted">
                <i class="far fa-clock me-1"></i>
                {{ $ulasan->created_at->format('d M Y, H:i') }}
                @if($ulasan->updated_at != $ulasan->created_at)
                    <span class="ms-2"><i class="fas fa-edit me-1"></i>Diedit: {{ $ulasan->updated_at->format('d M Y, H:i') }}</span>
                @endif
            </small>
        </div>

        <!-- UPDATE: Modal Edit -->
        <div class="modal fade" id="editModal{{ $ulasan->id_ulasan }}" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Ulasan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('ulasan.update', $ulasan->id_ulasan) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Lengkap *</label>
                                    <input type="text" class="form-control" name="nama" 
                                           value="{{ $ulasan->nama }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" 
                                           value="{{ $ulasan->email }}">
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Rating *</label>
                                <div class="rating-stars" id="editRating{{ $ulasan->id_ulasan }}">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span onclick="setEditRating({{ $i }}, {{ $ulasan->id_ulasan }})" 
                                              class="star-selector-edit" 
                                              data-value="{{ $i }}"
                                              data-modal="{{ $ulasan->id_ulasan }}"
                                              style="color: {{ $i <= $ulasan->rating ? '#ffc700' : '#ccc' }}; 
                                                     cursor: pointer;">★</span>
                                    @endfor
                                </div>
                                <input type="hidden" name="rating" id="editRatingInput{{ $ulasan->id_ulasan }}" 
                                       value="{{ $ulasan->rating }}" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Ulasan *</label>
                                <textarea class="form-control" name="komentar" rows="4" required>{{ $ulasan->komentar }}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
        
        <!-- INFO JUMLAH (tanpa pagination) -->
        <div class="text-center mt-4 text-muted">
            <small>Menampilkan {{ $ulasans->count() }} ulasan</small>
        </div>
        
    @else
        <!-- Empty State -->
        <div class="text-center py-5 empty-state">
            <i class="far fa-comment-dots"></i>
            <h4 class="mt-3 mb-3">Belum ada ulasan</h4>
            <p class="text-muted">Jadilah yang pertama berbagi pengalaman!</p>
        </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Rating for CREATE form
    function setRating(value) {
        document.getElementById('ratingInput').value = value;
        
        // Update star colors
        document.querySelectorAll('#ratingStars .star-selector').forEach((star, index) => {
            star.style.color = index < value ? '#ffc700' : '#ccc';
        });
    }
    
    // Rating for EDIT modal
    function setEditRating(value, modalId) {
        document.getElementById('editRatingInput' + modalId).value = value;
        
        // Update star colors in specific modal
        document.querySelectorAll('#editRating' + modalId + ' .star-selector-edit').forEach((star, index) => {
            star.style.color = index < value ? '#ffc700' : '#ccc';
        });
    }
    
    // Initialize ratings from old input (if validation failed)
    document.addEventListener('DOMContentLoaded', function() {
        const oldRating = document.getElementById('ratingInput').value;
        if (oldRating > 0) {
            setRating(oldRating);
        }
        
        // Auto-hide alerts after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                if (alert.classList.contains('alert-dismissible')) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }
            });
        }, 5000);
        
        // Character counter for textarea
        const textarea = document.querySelector('textarea[name="komentar"]');
        if (textarea) {
            const charCount = document.createElement('div');
            charCount.className = 'form-text text-end';
            charCount.innerHTML = `<span id="charCount">${textarea.value.length}</span>/500 karakter`;
            textarea.parentNode.appendChild(charCount);
            
            textarea.addEventListener('input', function() {
                document.getElementById('charCount').textContent = this.value.length;
            });
        }
    });
</script>
</body>
</html>