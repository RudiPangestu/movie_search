@extends('layoutes.main')

@push('styles')
<style>
    /* Advanced Color Palette */
    table th {
        background-color: #0265c9;
        color: #212529;
    }
    table td img {
        max-height: 60px;
        border-radius: 5px;
    }

    /* Enhanced Global Styles */

</style>
@endpush

@section('content')
<!-- Particle Background Container -->
<div id="particle-container"></div>

<div class="container-fluid px-4">
    <div class="row g-4">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="card card-advanced border-0 shadow-lg mb-4">
                <div class="card-header bg-gradient-primary text-black py-3">
                    <h5 class="mb-0 d-flex align-items-center">
                        <i class="fas fa-compass me-3 animate__animated animate__pulse"></i>Navigation
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <a href="{{ route('landing') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="fas fa-home me-3"></i>Landing Page
                            <span class="badge bg-primary text-white ms-auto">Welcome</span>
                        </a>
                        <a href="{{ route('index.index') }}" class="list-group-item list-group-item-action active d-flex align-items-center">
                            <i class="fas fa-tachometer-alt me-3"></i>Dashboard
                            <span class="badge bg-warning text-dark ms-auto">Home</span>
                        </a>
                        <a href="{{ route('search') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="fas fa-search me-3"></i>Search
                            <span class="badge bg-success text-black ms-auto">New</span>
                        </a>
                        <a href="{{ route('profile.show') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="fas fa-user me-3"></i>Profile
                            <span class="badge bg-info text-black ms-auto">{{ Auth::user()->name ?? 'User' }}</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Stats Card -->
            <div class="card card-advanced border-0 shadow-lg">
                <div class="card-header bg-gradient-primary text-black py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-pie me-2"></i>Quick Stats
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <!-- Quick Stats Card -->
                        <div class="col-6">
                            <div class="bg-light p-3 rounded text-center shadow-sm">
                                <h6 class="text-muted mb-2">
                                    <i class="fas fa-box-open text-warning me-2"></i>Total Products
                                </h6>
                                <h4 class="text-warning counter">{{ $totalProducts = Auth::user()->produks->count(); }}</h4>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-light p-3 rounded text-center shadow-sm">
                                <h6 class="text-muted mb-2">
                                    <i class="fas fa-tags text-danger me-2"></i>Total Categories
                                </h6>
                                <h4 class="text-danger counter">{{ $totalCategories = Auth::user()->produks->pluck('jenis')->unique()->count(); }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            <div class="card card-advanced border-0 shadow-lg">
                <div class="card-header bg-gradient-primary text-black d-flex justify-content-between align-items-center py-3">
                    <h4 class="mb-0">
                        <i class="fas fa-layer-group me-2"></i>Product Management
                    </h4>
                    <a href="{{ route('index.create') }}" class="btn btn-advanced btn-sm">
                        <i class="fas fa-plus me-2"></i>Add New Product
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatablesSimple" class="table table-striped table-bordered table-hover table-sm align-middle text-center">
                            <thead class="table-success">
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Release Year</th>
                                    <th>Actors</th>
                                    <th>Image</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($produk as $k)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $k->nama }}</td>
                                        <td>{{ $k->jenis }}</td>
                                        <td>{{ $k->release_year }}</td>
                                        <td>{{ $k->actors }}</td>
                                        <td>
                                            <img src="{{ filter_var($k->foto, FILTER_VALIDATE_URL) ? $k->foto : asset('image/' . $k->foto) }}" 
                                                 class="img-fluid rounded shadow-sm" style="width: 60px; height: auto;">
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('index.edit', $k->id) }}" class="btn btn-sm btn-outline-success">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $k->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Delete Confirmation Modal -->
                                    <div class="modal fade" id="deleteModal{{ $k->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $k->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $k->id }}">Delete Confirmation</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p class="text-center">Are you sure you want to delete <strong>{{ $k->nama }}</strong>?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <form action="{{ route('index.destroy', $k->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>


@push('scripts')
<!-- Particle.js Library -->
<script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/countup.js/2.0.8/countUp.min.js"></script>
<script>
    @push('scripts')
        <script>
            $(document).ready(function () {
                $('#datatablesSimple').DataTable({
                    responsive: true,
                    paging: true,
                    ordering: true,
                    info: true,
                    autoWidth: false,
                });
            });
        </script>
    @endpush
    // Particle Configuration
    particlesJS('particle-container'), {
        particles: {
            number: { value: 80, density: { enable: true, value_area: 800 } },
            color: { value: '#FFD700' },
            shape: { 
                type: 'circle',
                stroke: { width: 0, color: '#000000' },
                polygon: { nb_sides: 5 }
            },
            opacity: { 
                value: 0.5, 
                random: false, 
                anim: { 
                    enable: false, 
                    speed: 1, 
                    opacity_min: 0.1, 
                    sync: false 
                }
            },
            size: {
                value: 3,
                random: true,
                anim: { 
                    enable: false, 
                    speed: 40, 
                    size_min: 0.1, 
                    sync: false 
                }
            },
            line_linked: {
                enable: true,
                distance: 150,
                color: '#FFD700',
                opacity: 0.4,
                width: 1
            },
            move: {
                enable: true,
                speed: 2,
                direction: 'none',
                random: false,
                straight: false,
                out_mode:
            }
        }}    
@endpush        