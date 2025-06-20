<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manager Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap CSS (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white text-center">
                        <h4 class="mb-0">Manager Login</h4>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('manager.login.submit') }}">
                            @csrf

                            <div class="mb-3">
                                <label>Email:</label>
                                <input type="email" name="email" class="form-control" required>
                                @error('email') 
                                    <small class="text-danger">{{ $message }}</small> 
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label>Password:</label>
                                <input type="password" name="password" class="form-control" required>
                                @error('password') 
                                    <small class="text-danger">{{ $message }}</small> 
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </form>

                        @if ($errors->has('email'))
                            <div class="alert alert-danger mt-3">
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>
</html>
