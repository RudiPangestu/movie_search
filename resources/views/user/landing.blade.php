<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Wishlist - Your Ultimate Movie Companion</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #ff6b6b;
            --secondary-color: #4ecdc4;
            --bg-dark: #121212;
            --bg-card: rgba(255,255,255,0.05);
        }

        * {
            box-sizing: border-box;
            transition: all 0.3s ease;
        }

        body {
            background-color: var(--bg-dark);
            color: #ffffff;
            font-family: 'Arial', sans-serif;
            overflow-x: hidden;
            margin: 0;
            padding: 0;
        }

        /* Particle Background */
        #particles-js {
            position: fixed;
            width: 100%;
            height: 100%;
            z-index: 1;
            top: 0;
            left: 0;
        }

        /* Navigation Enhancements */
        .navbar {
            backdrop-filter: blur(10px);
            background-color: rgba(18, 18, 18, 0.8) !important;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            font-weight: bold;
            letter-spacing: 1px;
            transform: scale(1);
            transition: transform 0.2s ease;
        }

        .navbar-brand:hover {
            transform: scale(1.05);
        }

 /* Ensure the 'tes' section is above the particles background */
        .tes {
            position: relative;
            z-index: 3; /* Increase z-index to ensure it's above particles */
        }

        /* Improve card hover effects */
        .tes .feature-card {
            cursor: pointer; /* Add cursor indication */
            transition: all 0.5s ease;
        }

        .tes .feature-card:hover {
            transform: perspective(1000px) rotateX(-5deg) translateY(-15px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        }

        /* Ensure particle background doesn't block interactions */
        #particles-js {
            pointer-events: none; /* Allow clicks and hovers to pass through */
        }
        /* Hero Section Animations */
        .hero-section {
            background: linear-gradient(135deg, rgba(0,0,0,0.8), rgba(0,0,0,0.6)), url('images/bgg.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            align-items: center;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero-section h1 {
            animation: fadeInUp 1s ease;
            text-shadow: 0 4px 6px rgba(0,0,0,0.5);
        }

        .hero-section .lead {
            animation: fadeInUp 1s ease 0.5s backwards;
        }

        .hero-section .btn {
            animation: fadeInUp 1s ease 0.7s backwards;
        }
        .hero-section .container {
            z-index: 2;
        }

        /* Feature Cards Enhanced */
        .feature-card {
            background-color: var(--bg-card);
            border: 1px solid rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            transform: perspective(1000px) rotateX(0deg);
            transition: all 0.5s ease;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }

        .feature-card:hover {
            transform: perspective(1000px) rotateX(-5deg) translateY(-10px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.3);
        }

        .feature-card i {
            color: var(--primary-color);
            transition: transform 0.3s ease;
        }

        .feature-card:hover i {
            transform: scale(1.2) rotate(360deg);
        }

        /* Button Styles */
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            position: relative;
            overflow: hidden;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(120deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: all 0.5s ease;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-outline-light {
            border-color: rgba(255,255,255,0.5);
            transition: all 0.3s ease;
        }

        .btn-outline-light:hover {
            background-color: rgba(255,255,255,0.1);
        }

        /* Animations */
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

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .hero-section {
                height: auto;
                padding: 100px 0;
            }
        }

        /* Footer */
        footer {
            background-color: rgba(0,0,0,0.5) !important;
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body>
    <!-- Particles Background -->
    <div id="particles-js"></div>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-film me-2"></i>Movie Wishlist
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt me-2"></i>Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('signup.create') }}">
                                <i class="fas fa-user-plus me-2"></i>Sign Up
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('index.index') }}">
                                <i class="fas fa-home me-2"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('profile.show') }}">
                                <i class="fas fa-user me-2"></i>Profile
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero-section">
        <div class="container">
            <h1 class="display-4 mb-4">Discover, Track, and Explore Movies</h1>
            <p class="lead mb-5">Create your personal movie wishlist, track what you want to watch, and discover new favorites.</p>
            <div>
                <a href="{{ route('signup.create') }}" class="btn btn-primary btn-lg me-3">
                    Get Started <i class="fas fa-arrow-right ms-2"></i>
                </a>
                <a href="{{ route('search') }}" class="btn btn-outline-light btn-lg">
                    Browse Movies <i class="fas fa-search ms-2"></i>
                </a>
            </div>
        </div>
    </header>

    <!-- Features Section -->
    <section class="tes py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card feature-card h-100 text-center p-4">
                        <div class="card-body">
                            <i class="fas fa-list-alt fa-3x mb-3"></i>
                            <h4 class="card-title">Create Wishlists</h4>
                            <p class="card-text">Curate your own movie collections and keep track of films you want to watch.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card feature-card h-100 text-center p-4">
                        <div class="card-body">
                            <i class="fas fa-search fa-3x mb-3"></i>
                            <h4 class="card-title">Easy Search</h4>
                            <p class="card-text">Find movies quickly with our intuitive search functionality.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card feature-card h-100 text-center p-4">
                        <div class="card-body">
                            <i class="fas fa-user-circle fa-3x mb-3"></i>
                            <h4 class="card-title">Personal Profile</h4>
                            <p class="card-text">Manage your profile and keep your movie preferences in one place.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3">
        <div class="container">
            <p class="mb-0">&copy; 2024 Movie Wishlist. All rights reserved.</p>
        </div>
    </footer>

    <!-- Particle.js Library -->
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Particle.js Configuration
        particlesJS('particles-js', {
            particles: {
                number: { value: 80, density: { enable: true, value_area: 800 } },
                color: { value: '#ffffff' },
                shape: { type: 'circle' },
                opacity: { value: 0.5, random: false },
                size: { value: 3, random: true },
                line_linked: {
                    enable: true,
                    distance: 150,
                    color: '#ffffff',
                    opacity: 0.4,
                    width: 1
                },
                move: {
                    enable: true,
                    speed: 3,
                    direction: 'none',
                    random: false,
                    straight: false,
                    out_mode: 'out',
                    bounce: false
                }
            },
            interactivity: {
                detect_on: 'canvas',
                events: {
                    onhover: { enable: true, mode: 'repulse' },
                    onclick: { enable: true, mode: 'push' },
                    resize: true
                }
            },
            retina_detect: true
        });
    </script>
</body>
</html>