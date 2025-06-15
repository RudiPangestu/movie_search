@extends('layoutes.main')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-header d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-2 text-gray-800">
                        <i class="fas fa-edit text-primary me-2"></i>Edit Product Details
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-light p-2 rounded">
                            <li class="breadcrumb-item"><a href="{{ route('index.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Product</li>
                        </ol>
                    </nav>
                </div>
                <div class="actions">
                    <a href="{{ route('index.index') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-list me-2"></i>Product List
                    </a>
                    <a href="{{ route('index.create') }}" class="btn btn-outline-primary">
                        <i class="fas fa-plus me-2"></i>Add New Product
                    </a>
                </div>
            </div>

            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient-primary text-white py-3">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-edit me-2"></i>Product Information
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('index.update', $id->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nama" class="form-label fw-bold">Product Name</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                            <input type="text" 
                                                   class="form-control @error('nama') is-invalid @enderror" 
                                                   id="nama" 
                                                   name="nama" 
                                                   value="{{ old('nama', $id->nama) }}"
                                                   placeholder="Enter product name">
                                            @error('nama')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="jenis" class="form-label fw-bold">Product Type</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-box"></i></span>
                                            <input type="text" 
                                                   class="form-control @error('jenis') is-invalid @enderror" 
                                                   id="jenis" 
                                                   name="jenis" 
                                                   value="{{ old('jenis', $id->jenis) }}"
                                                   placeholder="Enter product type">
                                            @error('jenis')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="release_year" class="form-label fw-bold">Released Year</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                            <input type="number" 
                                                   class="form-control @error('release_year') is-invalid @enderror" 
                                                   id="release_year" 
                                                   name="release_year" 
                                                   value="{{ old('release_year', $id->release_year) }}"
                                                   placeholder="Enter release year">
                                            @error('release_year')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="actors" class="form-label fw-bold">Actor/Main Performer</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <input type="text" 
                                                   class="form-control @error('actors') is-invalid @enderror" 
                                                   id="actors" 
                                                   name="actors" 
                                                   value="{{ old('actors', $id->actors) }}"
                                                   placeholder="Enter actor name">
                                            @error('actors')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label fw-bold">Description</label>
                                    <textarea 
                                        class="form-control @error('deskripsi') is-invalid @enderror" 
                                        id="deskripsi" 
                                        name="deskripsi" 
                                        rows="5"
                                        placeholder="Enter product description">{{ old('deskripsi', $id->deskripsi) }}</textarea>
                                    @error('deskripsi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-header bg-light">
                                        <h6 class="m-0 text-center">Product Image</h6>
                                    </div>
                                    <div class="card-body text-center">
                                        <div class="mb-3">
                                            <input type="file" 
                                                   class="form-control d-none @error('foto') is-invalid @enderror" 
                                                   id="foto" 
                                                   name="foto"
                                                   accept="image/*"
                                                   onchange="previewImage(this)">
                                            @error('foto')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            
                                            <label for="foto" class="btn btn-outline-primary mb-3">
                                                <i class="fas fa-upload me-2"></i>Change Image
                                            </label>

                                            <div class="image-preview">
                                                @if(isset($id->foto) && !empty($id->foto))
                                                    <img src="{{ filter_var($id->foto, FILTER_VALIDATE_URL) ? $id->foto : asset('image/' . $id->foto) }}" 
                                                         alt="Product Image" 
                                                         id="imagePreview"
                                                         class="img-fluid rounded shadow-sm">
                                                @else
                                                    <img src="{{ url('image/nophoto.jpg') }}" 
                                                         alt="No Image" 
                                                         id="imagePreview"
                                                         class="img-fluid rounded shadow-sm">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="{{ route('index.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                            <div>
                                <button type="reset" class="btn btn-outline-warning me-2">
                                    <i class="fas fa-undo me-2"></i>Reset
                                </button>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save me-2"></i>Update Product
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
        const file = input.files[0];
        const reader = new FileReader();

        reader.onloadend = function () {
            preview.src = reader.result;
        }

        if (file) {
            reader.readAsDataURL(file);
        }
    }
</script>
@endpush
@endsection