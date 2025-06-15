<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Movie Search App</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f4;
        }
        .movie-card {
            transition: transform 0.3s ease;
        }
        .movie-card:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(0,0,0,0.12);
        }
        .movie-poster {
            height: 450px;
            object-fit: cover;
        }
        .movie-details-modal .modal-content {
            background-color: #f8f9fa;
        }
        .nav-link.active {
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="container mt-4 py-5 w-100">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-lg">
                    <div class="card-header bg-success text-white">
                        <h2 class="text-center mb-0">
                            <i class="fas fa-film me-2"></i>Movie Search App
                        </h2>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-8 offset-md-2">
                                <div class="input-group">
                                    <input type="text" id="search-input" class="form-control form-control-lg" 
                                           placeholder="Search for movies...">
                                    <button id="search-button" class="btn btn-success">
                                        <i class="fas fa-search"></i> Search
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div id="movie-list" class="row g-4">
                            <!-- Movies will be dynamically inserted here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Movie Details Modal -->
    <div class="modal fade movie-details-modal" id="movieDetailModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="movieModalTitle">Movie Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="movieModalBody">
                    <!-- Movie details will be dynamically inserted here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function searchMovie() {
            $('#movie-list').html('<div class="col text-center"><div class="spinner-border text-success" role="status"><span class="visually-hidden">Loading...</span></div></div>');

            $.ajax({
                url: 'http://omdbapi.com',
                type: 'get',
                dataType: 'json',
                data: {
                    'apikey': '901e696',
                    's': $('#search-input').val()
                },
                success: function (result) {
                    if (result.Response == "True") {
                        let movies = result.Search;
                        $('#movie-list').empty();

                        $.each(movies, function (i, data) {
                            $('#movie-list').append(`
                                <div class="col-md-4">
                                    <div class="card movie-card shadow-sm h-100">
                                        <img src="${data.Poster !== 'N/A' ? data.Poster : 'https://via.placeholder.com/300x450.png?text=No+Image'}" 
                                             class="card-img-top movie-poster" alt="${data.Title}">
                                        <div class="card-body">
                                            <h5 class="card-title">${data.Title}</h5>
                                            <p class="card-text text-muted">
                                                <i class="fas fa-calendar me-2"></i>${data.Year} 
                                                <span class="badge bg-success ms-2">${data.Type}</span>
                                            </p>
                                            <div class="d-flex justify-content-between">
                                                <button class="btn btn-outline-success see-detail" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#movieDetailModal" 
                                                        data-id="${data.imdbID}">
                                                    <i class="fas fa-info-circle me-2"></i>Details
                                                </button>
                                                <button class="btn btn-success add-to-database" 
                                                        data-id="${data.imdbID}">
                                                    <i class="fas fa-plus me-2"></i>Wishlist
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `);
                        });

                        $('#search-input').val('');
                    } else {
                        $('#movie-list').html(`
                            <div class="col text-center">
                                <h3 class="text-danger">
                                    <i class="fas fa-exclamation-triangle me-2"></i>${result.Error}
                                </h3>
                            </div>
                        `);
                    }
                },
                error: function() {
                    $('#movie-list').html(`
                        <div class="col text-center">
                            <h3 class="text-danger">
                                <i class="fas fa-wifi me-2"></i>Connection Error
                            </h3>
                        </div>
                    `);
                }
            });
        }

        // Search trigger on button click
        $('#search-button').on('click', searchMovie);

        // Search trigger on enter key
        $('#search-input').on('keyup', function (e) {
            if (e.which === 13) {
                searchMovie();
            }
        });

        // Show movie details
        $('#movie-list').on('click', '.see-detail', function () {
            const movieId = $(this).data('id');
            
            $.ajax({
                url: 'http://omdbapi.com',
                type: 'get',
                dataType: 'json',
                data: {
                    'apikey': '901e696',
                    'i': movieId
                },
                success: function (movie) {
                    if (movie.Response === "True") {
                        $('#movieModalTitle').text(movie.Title);
                        $('#movieModalBody').html(`
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-4">
                                        <img src="${movie.Poster !== 'N/A' ? movie.Poster : 'https://via.placeholder.com/300x450.png?text=No+Image'}" 
                                             class="img-fluid rounded shadow" alt="${movie.Title}">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <tbody>
                                                    <tr>
                                                        <th><i class="fas fa-heading me-2"></i>Title</th>
                                                        <td>${movie.Title}</td>
                                                    </tr>
                                                    <tr>
                                                        <th><i class="fas fa-calendar-alt me-2"></i>Released</th>
                                                        <td>${movie.Released}</td>
                                                    </tr>
                                                    <tr>
                                                        <th><i class="fas fa-film me-2"></i>Genre</th>
                                                        <td>${movie.Genre}</td>
                                                    </tr>
                                                    <tr>
                                                        <th><i class="fas fa-user-tie me-2"></i>Director</th>
                                                        <td>${movie.Director}</td>
                                                    </tr>
                                                    <tr>
                                                        <th><i class="fas fa-users me-2"></i>Actors</th>
                                                        <td>${movie.Actors}</td>
                                                    </tr>
                                                    <tr>
                                                        <th><i class="fas fa-star me-2"></i>Rating</th>
                                                        <td>${movie.imdbRating} / 10 (${movie.imdbVotes} votes)</td>
                                                    </tr>
                                                    <tr>
                                                        <th><i class="fas fa-language me-2"></i>Language</th>
                                                        <td>${movie.Language}</td>
                                                    </tr>
                                                    <tr>
                                                        <th><i class="fas fa-globe me-2"></i>Country</th>
                                                        <td>${movie.Country}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <h5 class="mt-3">Plot</h5>
                                        <p class="text-muted">${movie.Plot}</p>
                                    </div>
                                </div>
                            </div>
                        `);
                    }
                }
            });
        });

        // Add to database
        $('#movie-list').on('click', '.add-to-database', function () {
            const imdbID = $(this).data('id');
            
            $.ajax({
                url: 'http://omdbapi.com',
                type: 'get',
                dataType: 'json',
                data: {
                    apikey: '901e696',
                    i: imdbID
                },
                success: function (movie) {
                    $.ajax({
                        url: '/produk/add',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            _token: '{{ csrf_token() }}',
                            nama: movie.Title,
                            jenis: movie.Genre,
                            release_year: movie.Year,
                            actors: movie.Actors,
                            foto: movie.Poster,
                        },
                        success: function (response) {
                            alert(response.message);
                        },
                        error: function (xhr) {
                            alert('Gagal menambahkan ke wishlist.');
                        }
                    });
                },
                error: function () {
                    alert('Gagal mengambil data film dari API.');
                }
            });
        });
    </script>
</body>
</html>