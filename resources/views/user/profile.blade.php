<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Profile</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #ddff1d;
            --secondary-color: #0088ff;
        }

        body {
            background-color: #f4f6f9;
            font-family: 'Arial', sans-serif;
        }

        .profile-header {
            background: linear-gradient(135deg, var(--primary-color), #20c997);
            color: white;
            padding: 2rem 0;
            position: relative;
            overflow: hidden;
        }

        .profile-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.1);
            transform: skewY(-6deg);
            transform-origin: top left;
            z-index: 1;
        }

        .profile-avatar {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border: 4px solid white;
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
            transition: transform 0.3s ease;
        }

        .profile-avatar:hover {
            transform: scale(1.1) rotate(5deg);
        }

        .profile-stats {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            padding: 20px;
            margin-top: -50px;
            position: relative;
            z-index: 10;
        }

        .stat-item {
            text-align: center;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .stat-item:hover {
            background-color: rgba(40, 167, 69, 0.1);
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-up {
            animation: fadeInUp 0.6s ease both;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fas fa-film me-2 text-success"></i>Movie Wishlist
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('landing') }}">
                            <i class="fas fa-home me-2"></i>Landing Page
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('index.index') }}">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('search') }}">
                            <i class="fas fa-magnifying-glass me-2"></i>Search
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('profile.show') }}">
                            <i class="fas fa-user me-2"></i>Profile
                        </a>
                    </li>
                </ul>
                <div class="d-flex">
                    <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#logoutModal">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Profile Content -->
    <div class="container-fluid">
        <div class="profile-header text-center position-relative">
            <div class="container">
                <img src="{{ Auth::user()->profile_picture ? url('images/' . Auth::user()->profile_picture) : url('images/default-avatar.png') }}" 
                     class="profile-avatar rounded-circle mb-3" alt="Profile Picture">
                <h2 class="mb-2">{{ Auth::user()->name }}</h2>
                <p class="lead mb-0">{{ Auth::user()->email }}</p>
            </div>
        </div>

        <div class="container mt-5">
            <div class="row">
                <!-- Profile Stats -->
                <div class="col-md-4 animate-up">
                    <div class="profile-stats">
                        <div class="row">
                            <div class="card-body">
                                <div class="row g-3">
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
                </div>

                <!-- Profile Edit Form -->
                <div class="col-md-8 animate-up">
                    <div class="card card-hover shadow-sm mb-4">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">Edit Profile</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <input type="text" class="form-control" id="name" name="name" 
                                                   value="{{ Auth::user()->name }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            <input type="email" class="form-control" id="email" name="email" 
                                                   value="{{ Auth::user()->email }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="profile_picture" class="form-label">Profile Picture</label>
                                    <input type="file" class="form-control" id="profile_picture" name="profile_picture">
                                </div>
                                <div class="mb-3">
                                    <label for="bio" class="form-label">Bio</label>
                                    <textarea class="form-control" id="bio" name="bio" rows="3" 
                                              placeholder="Tell us about yourself">{{ Auth::user()->bio ?? '' }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save me-2"></i>Update Profile
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card card-hover animate-up">
                        <div class="card-header bg-success text-white">
                            {{-- <h5 class="mb-0">Recent Activity</h5> --}}
                        </div>
                        <div class="card-body">
                            {{-- <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-film me-2 text-success"></i>
                                        Added "Inception" to Wishlist
                                    </div>
                                    <span class="badge bg-success rounded-pill">2 hours ago</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-star me-2 text-success"></i>
                                        Reviewed "The Matrix"
                                    </div>
                                    <span class="badge bg-success rounded-pill">1 day ago</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-user me-2 text-primary"></i>
                                        Updated Profile Picture
                                    </div>
                                    <span class="badge bg-success rounded-pill">3 days ago</span>
                                </li>
                            </ul> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Logout Confirmation Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="logoutModalLabel">Logout Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p>Are you sure you want to logout?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>