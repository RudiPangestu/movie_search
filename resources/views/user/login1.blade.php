<!doctype html>
<html lang="en">
<head>
<title>Sign up</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<link rel="stylesheet" href="css/style.css">
<style>
    .img {
        position: relative;
        background-size: cover;
        background-position: center;
    }
    
    .img::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.4); /* Warna overlay dengan opacity */
        z-index: 1; /* Overlay di atas background */
    }
    
    .ftco-section {
        position: relative;
        z-index: 2; /* Konten berada di atas overlay */
    }
    
</style>
    
    
</head>
<body class="img js-fullheight " style="background-image: url(images/bggg.jpg);">
<section class="ftco-section ">
    <div class="container ">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center mb-1">
                <h2 class="heading-section">Wishlist Website Login</h2>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="login-wrap p-0">
            <h3 class="mb-1 text-center">Have an account?</h3>
            <div class="card-body">
                <form method="POST" action="{{ route('login.post') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-warning w-100">Login</button>
                </form>
                <p class="mt-3 text-center">Don't have an account? <a href="{{ route('signup.create') }}" class="">Sign up here</a></p>
            </div>
            
        </div> 
    </div>
</section>

<script src="js/jquery.min.js"></script>
<script src="js/popper.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>

</body>
</html>

