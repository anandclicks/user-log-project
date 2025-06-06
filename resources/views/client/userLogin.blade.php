<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <div class="flex flex-col md:flex-row max-w-4xl w-full bg-white rounded-2xl shadow-2xl overflow-hidden">
        <div class="w-full md:w-1/2 p-8 flex items-center justify-center">
            <form onsubmit="loginUser(event)" class="loginForm flex flex-col gap-4 w-full max-w-md">
                <h1 class="text-3xl font-bold text-gray-800 mb-4">Login to Your Account</h1>
                @csrf
                <input 
                    type="text" 
                    name="email"
                    class="border border-gray-300 rounded-lg p-3 w-full focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-200 placeholder-gray-400"
                    placeholder="Enter Email"
                >
                <input 
                    type="password" 
                    name="password"
                    class="border border-gray-300 rounded-lg p-3 w-full focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-200 placeholder-gray-400"
                    placeholder="Enter Password"
                >
                <div class="flex justify-end">
                    <p class="text-sm text-gray-600">
                        Create a New <a class="text-purple-600 hover:text-purple-800 font-medium" href="{{route('register.view')}}">Account</a>
                    </p>
                </div>
                <input 
                    type="submit" 
                    value="Login"
                    class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-lg p-3 cursor-pointer transition duration-200"
                >
            </form>
        </div>
        <div class="hidden md:block w-full md:w-1/2">
            <img 
                class="h-full w-full object-cover"
                src="https://images.unsplash.com/photo-1619045119136-349759036541?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8cHVycGxlJTIwYWVzdGhldGljfGVufDB8fDB8fHww" 
                alt="Purple aesthetic"
            >
        </div>
    </div>

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: '{{session('error')}}'
            })
        </script>
    @endif
    @if(session('success'))
    <script>
        Swal.fire({
            icon : success,
            title: '{{session('success')}}'
        })
    </script>
    @endif

    <script>
        function loginUser(event){
            event.preventDefault();
            let finalData = $('.loginForm').serialize();

            $.ajax({
                url: '{{route('user.login')}}',
                type: 'post',
                data: finalData,
                success: function(res){
                    if(res.success){
                        window.open('{{route('/')}}', '_self')
                    } else {
                        console.log(res)
                        Swal.fire({
                            icon: 'error',
                            title: res.message ?? 'Something is wrong!'
                        })
                    }
                },
                error: function(err, xhr){
                    console.log(err)
                    Swal.fire({
                        icon: 'error',
                        title: err.responseJSON.message ?? 'Internal Server Error!'
                    })
                }
            })
        }
    </script>
</body>
</html>