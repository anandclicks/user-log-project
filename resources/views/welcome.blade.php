<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        


        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    * {
        font-family: Arial, Helvetica, sans-serif;
    }
</style>
    </head>

    <body>
    @if(Auth::check())
    <h1>Welcome {{Auth::user()->name}}</h1>
    
    @endif
        @if(session('success'))
        <script>
              Swal.fire({
                        icon : 'success',
                        title : 'Logged In!!'
                    })
        </script>
        @endif
    </body>
    
</html>


