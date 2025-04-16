<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Fonts -->
<link rel="preconnect" href="https://fonts.bunny.net">
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<style>
    * {
        font-family: Arial, Helvetica, sans-serif;
    }
</style>

<body>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Logged In!!'
            })
        </script>
    @endif

    <div class="">
       <div class="row w-full h-[90px] flex justify-end p-2">
        <div class="user_card w-[200px] h-full shadow rounded-2xl flex items-center gap-3 justify-center">
            <img class="h-[60px] w-[60px] rounded-full"
                src="https://cdn.vectorstock.com/i/500p/62/34/user-profile-icon-anonymous-person-symbol-blank-vector-53216234.jpg"
                alt="">
            <div>
                @if (!empty($user))
                    <h2 class="m-0 leading-5">Hello, <br> <b class="text-purple-500">{{ $user['name'] }}!</b></h2>
                    {{-- <small><a class="text-red-700" href="">Logout</a></small> --}}
                @else
                    <p><a href="{{ route('login.view') }}" class="text-green-700" href="">Login Account</a></p>
                @endif
            </div>

        </div>
       </div>

        {{-- create post  --}}
       
        <form  enctype="multipart/form-data" onsubmit="createPost(event)" class="hidden flex flex-col gap-2 p-5 createPost w-[300px]">
            <h1 class="text-2xl mb-3">Create Post</h1>
            @csrf
            <input type="text" name="title"
                class=" border-[1px] outline-0 border-stone-300 p-2 rounded-lg h-[40px] " placeholder="Enter Title">
            <textarea type="text" name="deps"
                class=" border-[1px] outline-0 border-stone-300 p-2 rounded-lg h-[150px] " placeholder="Enter Descripton"></textarea>
            <input type="file" class=" border-[1px] outline-0 border-stone-300 p-2 rounded-lg h-[40px]" name="image">
    
            <input type="submit" value="Post"
                class="w-full bg-purple-700 rounded-2xl text-white h-[40px] flex items-center justify-center cursor-pointer">
        </form>

        <div class="allPosts px-3 flex gap-3 flex-wrap">
           @foreach($posts as $post)
           <div class="card h-[320px] p-2 w-[250px] shadow rounded-2xl">
            <img class="w-full h-[150px] object-cover rounded-2xl" src="/storage/{{$post['image']}}" alt="">

            <div class="flex flex-col justify-between h-[150px]">
               <div>
                <h3 class="text-xl mt-2">{{$post['title']}}</h3>
                <p class="leading-5 mt-2">{{Str::substr($post['deps'],0, 100)}}...</p>
               </div>
               <div class="pt-2">
                <small>{{ \Carbon\Carbon::parse('2025-04-16 19:47:27')->format('F j, Y g:i A') }}</small>
               </div>
            </div>
        </div>
           @endforeach
        </div>
    </div>

    <script>
       function createPost(evt){
        evt.preventDefault()
        let data = $('.createPost')[0];
        data = new FormData(data)
        $.ajax({
            url : "{{route('create.post')}}",
            type : 'POST',
            data : data,
            contentType : false,
            processData : false,
            success : function(res){
                console.log(res);
            },
            error : function(res){
                console.log(res);
                
            }
        })
       }
    </script>

</body>
