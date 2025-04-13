<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<div class="h-[100vh] w-[100vw] flex items-center justify-center">
    <div class="left w-[30%] h-[100%] flex items-center">
        <form onsubmit="loginUser(event)" class=" flex flex-col gap-2 p-5 loginForm">
            <h1 class="text-2xl mb-3">Login Your Account</h1>
            @csrf
            <input type="text" name="email"
                class=" border-[1px] outline-0 border-stone-300 p-2 rounded-lg h-[40px] w-[320px]" placeholder="Enter Email">
            <input type="text" name="password"
                class=" border-[1px] outline-0 border-stone-300 p-2 rounded-lg h-[40px] w-[320px]" placeholder="Enter Password">
            
            <div class="w-full flex justify-end">
                <p>Create A New <a class="text-blue-500" href="{{route('register.view')}}">Account</a></p>
            </div>
    
            <input type="submit" value="Login"
                class="w-full bg-purple-700 rounded-2xl text-white h-[40px] flex items-center justify-center cursor-pointer">
        </form>
    </div>
    {{-- <div class="right w-[30%] h-[100%] flex items-center">
        <img class="h-[80%] w-full bg-cover rounded-2xl" src="https://images.unsplash.com/photo-1619045119136-349759036541?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8cHVycGxlJTIwYWVzdGhldGljfGVufDB8fDB8fHww" alt="">
    </div> --}}
    @if (session('error'))
    {{-- @dd('ddd') --}}
        <script>
            Swal.fire({
                      icon : 'error',
                      title : '{{session('error')}}'
                  })
      </script>
</div>
@endif



<script>
    function loginUser(event){
        event.preventDefault();
        let finalData = $('.loginForm').serialize();

        $.ajax({
            url : '{{route('user.login')}}',
            type : 'post',
            data : finalData,
            success : function(res){
                if(res.success){
                   window.open('{{route('/')}}', '_self')
                }else {
                    Swal.fire({
                        icon : 'warning',
                        title : res.message ?? 'Something is wrong!'
                    })
                }
            },
            error : function(err){
                Swal.fire({
                    icon : 'error',
                    title : err.responseText ?? 'Internal Server Error!'
                })
            }
        })
    }
</script>