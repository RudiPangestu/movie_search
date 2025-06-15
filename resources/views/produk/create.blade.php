@extends('layoutes.main')

@push('styles')
<style>
    :root {
        --success-color: #0088ff;
        --secondary-color: #20c997;
        --accent-color: #ddff1d;
    }

    .form-create-container {
        background: linear-gradient(135deg, rgba(0, 136, 255, 0.05), rgba(32, 201, 151, 0.05));
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }

    .preview-image {
        max-height: 250px;
        object-fit: cover;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .preview-image:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }

    .form-label {
        font-weight: 600;
        color: #495057;
    }

    .form-control:focus {
        border-color: var(--success-color);
        box-shadow: 0 0 0 0.2rem rgba(0, 136, 255, 0.25);
    }

    .ai-suggestion {
        background-color: rgba(32, 201, 151, 0.1);
        border-left: 4px solid var(--secondary-color);
        padding: 10px;
        margin-top: 10px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="form-create-container">
                <div class="text-center mb-4">
                    <h2 class="mb-3">
                        <i class="fas fa-film text-success me-2"></i>Create New Product
                    </h2>
                    <p class="text-muted">Fill in the details for your new product</p>
                </div>

                <form action="{{ route('index.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nama" class="form-label">Product Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-heading"></i></span>
                                        <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                                               id="nama" name="nama" 
                                               value="{{ old('nama') }}" 
                                               placeholder="Enter product name" 
                                               required>
                                        @error('nama')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="ai-suggestion" id="aiNameSuggestion" style="display:none;">
                                        <small>
                                            <i class="fas fa-magic text-success me-2"></i>
                                            AI Suggestion: <span id="aiNameText"></span>
                                        </small>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="jenis" class="form-label">Categories (comma-separated)</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-tags"></i></span>
                                        <input type="text" class="form-control @error('jenis') is-invalid @enderror" 
                                               id="jenis" name="jenis" 
                                               value="{{ old('jenis') }}" 
                                               placeholder="Enter categories (e.g. Action, Comedy)" 
                                               required>
                                        @error('jenis')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Separate multiple categories with commas
                                    </small>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="release_year" class="form-label">Release Year</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                        <input type="number" class="form-control @error('release_year') is-invalid @enderror" 
                                               id="release_year" name="release_year" 
                                               value="{{ old('release_year') }}" 
                                               min="1900" max="{{ date('Y') }}"
                                               placeholder="Enter release year" 
                                               required>
                                        @error('release_year')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="actors" class="form-label">Main Actors</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-users"></i></span>
                                        <input type="text" class="form-control @error('actors') is-invalid @enderror" 
                                               id="actors" name="actors" 
                                               value="{{ old('actors') }}" 
                                               placeholder="Enter main actors" 
                                               required>
                                        @error('actors')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Description</label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                          id="deskripsi" name="deskripsi" 
                                          rows="4" 
                                          placeholder="Enter product description"
                                          required>{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="ai-suggestion" id="aiDescriptionSuggestion" style="display:none;">
                                    <small>
                                        <i class="fas fa-magic text-success me-2"></i>
                                        AI Suggestion: <span id="aiDescriptionText"></span>
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-header bg-success text-white">
                                    <i class="fas fa-image me-2"></i>Product Image
                                </div>
                                <div class="card-body">
                                    <input type="file" 
                                           class="form-control @error('foto') is-invalid @enderror" 
                                           id="foto" name="foto" 
                                           accept="image/*"
                                           onchange="previewImage(event)">
                                    @error('foto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    
                                  
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('index.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back
                        </a>
                        <div>
                            <a href="{{ route('search') }}" class="btn btn-success me-2" id="aiSuggestBtn">
                                <i class="fas fa-search me-2"></i>Search Movie
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-2"></i>Submit
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Image Preview Function
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('imagePreview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    // AI Suggestion Simulation (Mock function - replace with actual AI API)
    document.getElementById('aiSuggestBtn').addEventListener('click', function() {
        const nameInput = document.getElementById('nama');
        const descriptionInput = document.getElementById('deskripsi');
        const nameSuggestion = document.getElementById('aiNameSuggestion');
        const descriptionSuggestion = document.getElementById('aiDescriptionSuggestion');
        
        // Mock AI suggestions (replace with real AI service)
        const mockNameSuggestions = [
            'Epic Adventure Blockbuster',
            'Sci-Fi Thriller Masterpiece',
            'Heartwarming Comedy Classic'
        ];

        const mockDescriptionSuggestions = [
            'A gripping narrative that explores the depths of human emotion and technological advancement.',
            'An extraordinary journey that challenges the boundaries of imagination and reality.',
            'A hilarious and touching story about friendship, love, and unexpected twists.'
        ];

        const randomNameSuggestion = mockNameSuggestions[Math.floor(Math.random() * mockNameSuggestions.length)];
        const randomDescriptionSuggestion = mockDescriptionSuggestions[Math.floor(Math.random() * mockDescriptionSuggestions.length)];

        // Display suggestions
        document.getElementById('aiNameText').textContent = randomNameSuggestion;
        document.getElementById('aiDescriptionText').textContent = randomDescriptionSuggestion;
        
        nameSuggestion.style.display = 'block';
        descriptionSuggestion.style.display = 'block';
    });

    // Form Validation
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>
@endpush