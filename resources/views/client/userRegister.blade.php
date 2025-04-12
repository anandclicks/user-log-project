<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>


<div class="h-[100vh] w-[100vw] flex items-center justify-center">
    <form onsubmit="registerUser(event)" class="color-white flex flex-col gap-2 shadow-xl p-5 rounded-2xl registerForm">
        <h1 class="text-2xl mb-3">Sign-up Your Account</h1>
        @csrf
        <input type="text" name="name"
            class=" border-[1px] outline-0 border-stone-300 p-2 rounded-lg h-[40px] w-[320px]" placeholder="Enter Name">
        <input type="text" name="email"
            class=" border-[1px] outline-0 border-stone-300 p-2 rounded-lg h-[40px] w-[320px]" placeholder="Enter Email">
        <input type="text" name="number"
            class=" border-[1px] outline-0 border-stone-300 p-2 rounded-lg h-[40px] w-[320px]"
            placeholder="Enter Number">
        <input type="text" name="password"
            class=" border-[1px] outline-0 border-stone-300 p-2 rounded-lg h-[40px] w-[320px]"
            placeholder="Enter Password">

        <div class="w-full flex justify-end">
            <p>Go For <a class="text-blue-500" href="">Login</a></p>
        </div>

        <input type="submit"
            class="w-full bg-blue-600 text-white h-[40px] flex items-center justify-center cursor-pointer">

    </form>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="
    https://cdn.jsdelivr.net/npm/sweetalert2@11.17.2/dist/sweetalert2.all.min.js
    "></script>
    <link href="
    https://cdn.jsdelivr.net/npm/sweetalert2@11.17.2/dist/sweetalert2.min.css
    " rel="stylesheet">

<script>
    function registerUser(event) {
        event.preventDefault();
        let formVal = $('.registerForm').serialize()
        
        $.ajax({
            url: '{{ route('user.register') }}',
            type: 'POST',
            data: formVal,
            success : function(res){
                if(res.success){
                    Swal.fire({
                        icon : 'success',
                        title : "Registered Successful!",
                    });
                }else {
                    Swal.fire({
                        icon : 'warning',
                        title : res.message ?? "Something Is Wrong!",
                    });
                }
            },
            error : function(xhr){
                    Swal.fire({
                        icon : "error",
                        title : xhr.responseText ?? 'Internal Server Error!'
                    })
                }
        })
    }
</script>
