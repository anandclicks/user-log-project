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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.css"
    integrity="sha512-kJlvECunwXftkPwyvHbclArO8wszgBGisiLeuDFwNM8ws+wKIw0sv1os3ClWZOcrEB2eRXULYUsm8OVRGJKwGA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
    * {
        font-family: Arial, Helvetica, sans-serif;
    }
    .prevent-select {
  -webkit-user-select: none; 
  -ms-user-select: none; 
  user-select: none; 
}
</style>

<body>

    @if (session('success'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                icon: 'success',
                title: 'Logged in Succesfull!',
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })
        </script>
    @endif

    <div class="">
        <div class="row w-full h-[90px] flex justify-between p-2 items-center ">
            <div
                class="closeCreatePost bg-purple-600 rounded-2xl h-[40px] w-[150px] flex justify-center items-center text-white cursor-pointer gap-2 text-sm">
                <i class="ri-quill-pen-ai-line"></i> Create Post
            </div>

            <div class="user_card w-[200px] h-full shadow rounded-2xl flex items-center gap-3 justify-center">
                <img class="h-[60px] w-[60px] rounded-full"
                    src="https://cdn.vectorstock.com/i/500p/62/34/user-profile-icon-anonymous-person-symbol-blank-vector-53216234.jpg"
                    alt="">
                <div>
                    @if (!empty($user))
                        <h2 class="m-0 leading-5">Hello, <br> <b class="text-purple-500">{{ $user['name'] }}!</b></h2>
                        {{-- <small><a class="text-red-700" href="">Logout</a></small> --}}
                    @else
                        <p><a href="{{ route('login.view') }}" class="text-green-700" href="">Login Account</a>
                        </p>
                    @endif
                </div>

            </div>
        </div>

        {{-- create post  --}}

        <div
            class="hidden post_wrapper h-[100vh] w-[100vw] absolute top-0 left-0 bg-[#00000022] flex items-center justify-center z-50">
            <form enctype="multipart/form-data" onsubmit="createPost(event)"
                class="bg-white relative shadow rounded-xl flex flex-col gap-2 p-5 createPost w-[400px]">
                <i class="ri-close-large-line closeCreatePost absolute top-0 right-0 text-2xl cursor-pointer m-2"></i>

                <h1 class="text-2xl mb-3">Create Post</h1>
                @csrf
                {{-- priveiw image  --}}
                <div
                    class=" h-[250px] w-full card flex justify-center bg-stone-200 rounded-xl relative overflow-hidden">
                    <input type="file" accept="image/*"
                        class="imageInput absolute cursor-pointer top-0 z-30 left-0 opacity-0 h-full w-full border-[1px] outline-0 border-stone-300 p-2 rounded-lg "
                        name="image">
                    <img class="h-full w-auto object-contain previmg z-20" src="" alt="">
                    <p class="absolute h-full flex items-center">Upload Image</p>
                </div>
                <textarea type="text" name="deps"
                    class=" text-sm border-[1px] outline-0 border-stone-300 p-2 rounded-lg h-[70px] " placeholder="Your Thoughts...!"></textarea>
              

                <input type="submit" value="Post"
                    class="w-full bg-purple-700 rounded-2xl text-white h-[40px] flex items-center justify-center cursor-pointer image">
            </form>
        </div>

        <div class="allPosts px-3 flex gap-3 items-center flex-wrap">
            @foreach ($posts as $post)
                <div class="card h-min-[400px] p-2 w-[300px] shadow rounded-2xl ">
                    <div class="pt-2 flex gap-2 items-center justify-between mb-2">
                       <div class="flex gap-2 items-center">
                        <i class="ri-user-line text-3xl"></i>
                        <div>
                         <p class="leading-2">{{$post->user?->name ?? 'Known User'}}</p>
                         <small>{{ \Carbon\Carbon::parse($post['created_at'])->timezone('Asia/Kolkata')->format('F j, Y g:i A') }}</small>
                        </div>
                       </div>
                       <div class="relative">
                           <i class="ri-more-2-line cursor-pointer actionShowBtn"></i>
                           <div class="absolute actionBtnWrapper top-5 right-0 min-h-[40px] w-[100px] shadow bg-white rounded-xl flex p-3 gap-2 justify-center flex-col prevent-select hidden">
                            <small copyUrl="{{URL::to('/posts/' . base64_encode($post['id']))}}" class="sharePost cursor-pointer">
                                <i class="ri-share-fill"></i> Share
                            </small>
                            @if(Auth::user()->id == $post['user_id'])
                            <small class="editPost cursor-pointer">
                                <i class="ri-pencil-fill"></i> Edit
                            </small>
                            <small class="deletePost cursor-pointer">
                                <i class="ri-delete-bin-6-line"></i> Delete
                            </small>
                            @endif
                           </div>
                       </div>
                    </div>

                    <div class="w-full flex justify-center">
                        <img class="w-auto h-[300px] object-cover rounded-2xl" src="/storage/{{ $post['image'] }}"
                            alt="">
                    </div>

                    <div class="flex flex-col justify-between mt-2">
                        <div>
                            <p class="leading-5 mt-2">{{$post['deps']}}</p>
                        </div>
                        
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        function createPost(evt) {
            evt.preventDefault()
            let data = $('.createPost')[0];
            data = new FormData(data)
            $.ajax({
                url: "{{ route('create.post') }}",
                type: 'POST',
                data: data,
                contentType: false,
                processData: false,
                success: function(res) {
                    if (!res.success) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            icon: 'info',
                            title: res.message,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        });
                    }
                    if (res.success) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            icon: 'success',
                            title: res.message,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        }).then(() => {
                            $('.post_wrapper')[0].classList.add('hidden')
                        });
                    }
                },
                error: function(res) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        icon: 'info',
                        title: res.responseJSON.message ?? 'Internal server error!',
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    });
                }
            })
        }

        $(".imageInput").change(function(event) {
            let imageUrl = URL.createObjectURL(event.target.files[0])
            $('.previmg')[0].src = imageUrl
            console.log($('.previmg')[0]);
        })

        $('.closeCreatePost').click(function() {
            if ($('.post_wrapper')[0].classList.contains('hidden')) {
                $('.post_wrapper')[0].classList.remove('hidden')
            } else {
                $('.post_wrapper')[0].classList.add('hidden')
            }
        })
        $('.actionShowBtn').click(function(evt){
            evt.target.classList.toggle('ri-more-2-line')
            evt.target.classList.toggle('ri-close-large-line')
            let el = evt.target.nextElementSibling
            el.select
            el.classList.contains('hidden') ? el.classList.remove('hidden') : el.classList.add('hidden')
        })
        $('.sharePost').click(function(evt){
            $('.actionBtnWrapper').each(function () {
                this.classList.add('hidden');
            })
            let urlForCopy = evt.target.getAttribute('copyUrl')
            navigator.clipboard.writeText(urlForCopy).then(()=>
            Swal.fire({
                toast : true,
                position : 'top-end',
                showConfirmButton : false,
                timer : 2000,
                icon : 'success',
                title : 'Url Cpoied!',
            })
        );
        })
    </script>

</body>
