<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Explorer</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Movie Explorer</a>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row mb-4">
            <div class="col-md-8 offset-md-2">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search movies..." id="search-input">
                    <button class="btn btn-success" type="button" id="search-button">Search</button>
                </div>
            </div>
        </div>

        <div class="row" id="movie-list">
            <!-- Movies will be dynamically added here -->
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Movie Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Movie details will be dynamically added here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Required Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function searchMovie() {
            $('#movie-list').html('');

            $.ajax({
                url: 'https://www.omdbapi.com/',
                type: 'get',
                dataType: 'json',
                data: {
                    'apikey': '901e696',
                    's': $('#search-input').val()
                },
                success: function (result) {
                    if (result.Response == "True") {
                        let movies = result.Search;

                        $.each(movies, function (i, data) {
                            $('#movie-list').append(`
                                <div class="col-md-4">
                                    <div class="card mb-3">
                                        <img src="${data.Poster !== 'N/A' ? data.Poster : 'https://via.placeholder.com/300x450.png?text=No+Image'}" class="card-img-top" alt="...">
                                        <div class="card-body">
                                        <h5 class="card-title">${data.Title}</h5>
                                        <h6 class="card-subtitle mb-2 text-muted">${data.Year}</h6>
                                        <a href="#" class="card-link see-detail me-2" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="${data.imdbID}">See Detail</a>
                                        <button class="btn btn-success btn-sm add-to-database ms-2" 
                                            data-id="${data.imdbID}" 
                                            data-title="${data.Title}" 
                                            data-genre="${data.Type}" 
                                            data-year="${data.Year}">
                                            Add to Wishlist
                                        </button>
                                        </div>
                                    </div>
                                </div>
                            `);
                        });

                        $('#search-input').val('');

                    } else {
                        $('#movie-list').html(`
                            <div class="col">
                                <h1 class="text-center">${result.Error}</h1>
                            </div>
                        `)
                    }
                },
                error: function() {
                    $('#movie-list').html(`
                        <div class="col">
                            <h1 class="text-center">Network Error. Please try again.</h1>
                        </div>
                    `)
                }
            });
        }

        $('#search-button').on('click', function () {
            searchMovie();
        });

        $('#search-input').on('keyup', function (e) {
            if (e.which === 13) {
                searchMovie();
            }
        });

        $('#movie-list').on('click', '.see-detail', function () {
            $.ajax({
                url: 'https://www.omdbapi.com/',
                dataType: 'json',
                type: 'get',
                data: {
                    'apikey': '901e696',
                    'i': $(this).data('id')
                },
                success: function (movie) {
                    if (movie.Response === "True") {
                        $('.modal-body').html(`
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-4">
                                        <img src="${movie.Poster !== 'N/A' ? movie.Poster : 'https://via.placeholder.com/300x450.png?text=No+Image'}" class="img-fluid">
                                    </div>

                                    <div class="col-md-8">
                                        <ul class="list-group">
                                            <li class="list-group-item"><h3>${movie.Title}</h3></li>
                                            <li class="list-group-item">Released : ${movie.Released}</li>
                                            <li class="list-group-item">Genre : ${movie.Genre}</li>                 
                                            <li class="list-group-item">Director : ${movie.Director}</li>                 
                                            <li class="list-group-item">Actor : ${movie.Actors}</li>                 
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        `);
                    }
                }
            });
        });
    </script>
</body>
</html>