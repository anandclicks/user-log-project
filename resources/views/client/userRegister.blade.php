<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.17.2/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.17.2/dist/sweetalert2.min.css" rel="stylesheet">
</head>
<body class="min-h-screen bg-gradient-to-br from-purple-100 to-indigo-200 flex items-center justify-center p-4">
    <div class="flex flex-col md:flex-row max-w-4xl w-full bg-white rounded-2xl shadow-2xl overflow-hidden">
        <div class="w-full md:w-1/2 p-8 flex items-center justify-center">
            <form onsubmit="registerUser(event)" class="registerForm flex flex-col gap-4 w-full max-w-md">
                <h1 class="text-3xl font-bold text-gray-800 mb-4">Sign Up for Your Account</h1>
                @csrf
                <input 
                    type="text" 
                    name="name"
                    class="border border-gray-300 rounded-lg p-3 w-full focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-200 placeholder-gray-400"
                    placeholder="Enter Name"
                >
                <input 
                    type="text" 
                    name="email"
                    class="border border-gray-300 rounded-lg p-3 w-full focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-200 placeholder-gray-400"
                    placeholder="Enter Email"
                >
                <input 
                    type="text" 
                    name="number"
                    class="border border-gray-300 rounded-lg p-3 w-full focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-200 placeholder-gray-400"
                    placeholder="Enter Number"
                >
                <input 
                    type="password" 
                    name="password"
                    class="border border-gray-300 rounded-lg p-3 w-full focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-200 placeholder-gray-400"
                    placeholder="Enter Password"
                >
                <div class="flex justify-end">
                    <p class="text-sm text-gray-600">
                        Go for <a class="text-purple-600 hover:text-purple-800 font-medium" href="{{route('login.view')}}">Login</a>
                    </p>
                </div>
                <input 
                    type="submit" 
                    value="Sign-up"
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

    <script>
        function registerUser(event) {
            event.preventDefault();
            let formVal = $('.registerForm').serialize();
            
            $.ajax({
                url: '{{ route('user.register') }}',
                type: 'POST',
                data: formVal,
                success: function(res){
                    if(res.success){
                        Swal.fire({
                            icon: 'success',
                            title: "Registered Successful!",
                        }).then(() => $('.registerForm')[0].reset()).then(() => window.open('{{route('login.view')}}', '_self'));
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: res.message ?? "Something Is Wrong!",
                        });
                    }
                },
                error: function(xhr){
                    Swal.fire({
                        icon: "error",
                        title: xhr.responseText ?? 'Internal Server Error!'
                    });
                }
            });
        }
    </script>
</body>
</html>