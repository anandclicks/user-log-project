<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Social Media Page</title>
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
            font-family: 'Instrument Sans', Arial, Helvetica, sans-serif;
        }
        .prevent-select {
            -webkit-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
    </style>
</head>
<body class="min-h-screen from-purple-100 to-indigo-200">
    @if (session('success'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
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

    <div class="flex flex-col min-h-screen">
        <!-- Navbar -->
        <nav class="w-full h-[80px] flex justify-between items-center px-4 md:px-8 bg-white shadow-md sticky top-0 z-40">
            <button class="closeCreatePost bg-purple-600 hover:bg-purple-700 text-white rounded-xl h-10 px-4 flex items-center gap-2 text-sm font-semibold transition duration-200">
                <i class="ri-quill-pen-ai-line"></i> Create Post
            </button>
            <div class="user_card w-[180px] md:w-[200px] h-14 bg-white shadow rounded-xl flex items-center gap-3 px-3">
                <img class="h-10 w-10 rounded-full object-cover"
                    src="https://cdn.vectorstock.com/i/500p/62/34/user-profile-icon-anonymous-person-symbol-blank-vector-53216234.jpg"
                    alt="User profile">
                <div>
                    @if (!empty($user))
                        <h2 class="text-sm font-semibold text-gray-800">Hello, <br><b class="text-purple-500">{{ $user['name'] }}</b></h2>
                    @else
                        <p><a href="{{ route('login.view') }}" class="text-purple-600 hover:text-purple-800 font-medium text-sm">Login Account</a></p>
                    @endif
                </div>
            </div>
        </nav>

        <!-- Create Post Modal -->
        <div class="hidden post_wrapper h-screen w-screen fixed top-0 left-0 bg-black/50 flex items-center justify-center z-50">
            <form enctype="multipart/form-data" onsubmit="createPost(event)"
                class="bg-white relative shadow-2xl rounded-xl flex flex-col gap-4 p-6 createPost w-full max-w-md">
                <input type="hidden" name="post_id" class="post_id">
                <i class="ri-close-large-line closeCreatePost absolute top-4 right-4 text-xl cursor-pointer text-gray-600 hover:text-gray-800"></i>
                <h1 class="text-2xl font-bold text-gray-800 createPostTitleAndBtn">Create Post</h1>
                @csrf
                <!-- Image Preview -->
                <div class="h-48 w-full bg-gray-100 rounded-xl relative overflow-hidden flex items-center justify-center">
                    <input type="file" accept="image/*"
                        class="imageInput absolute cursor-pointer top-0 left-0 opacity-0 h-full w-full z-30"
                        name="image">
                    <img class="h-full w-auto object-contain previmg z-20" src="" alt="">
                    <p class="absolute text-gray-500 font-medium">Upload Image</p>
                </div>
                <textarea name="deps"
                    class="depsTextarea text-sm border border-gray-300 rounded-lg p-3 w-full h-20 resize-none focus:ring-2 focus:ring-purple-500 focus:border-transparent placeholder-gray-400"
                    placeholder="Your Thoughts...!"></textarea>
                <input type="submit" value="Post"
                    class="createPostTitleAndBtn w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-lg p-3 cursor-pointer transition duration-200">
            </form>
        </div>

        <!-- Posts Section -->
        <div class="allPosts z-10 relative px-4 py-6 flex flex-col items-center gap-6 md:grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 md:gap-4 max-w-7xl mx-auto">
            @if (count($posts) > 0)
                @foreach ($posts as $post)
                    <div class="card w-full max-w-sm bg-white p-4 shadow-lg rounded-2xl">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-2">
                                <i class="ri-user-line text-2xl text-gray-600"></i>
                                <div>
                                    <p class="text-sm font-medium text-gray-800">{{ $post->user?->name ?? 'Known User' }}</p>
                                    <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($post['created_at'])->timezone('Asia/Kolkata')->format('F j, Y g:i A') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <button onclick="follow(this)" isFollow='0' class="bg-purple-600 hover:bg-purple-700 text-white px-3 py-1 rounded-lg text-xs font-medium followBtn cursor-pointer transition duration-200">Follow</button>
                                <!-- Action Menu -->
                                <div class="relative">
                                    <i class="ri-more-2-line cursor-pointer actionShowBtn text-lg text-gray-600 hover:text-gray-800"></i>
                                    <div class="absolute actionBtnWrapper top-6 right-0 w-28 bg-white shadow-lg rounded-xl p-3 flex flex-col gap-2 text-sm prevent-select hidden">
                                        <small copyUrl="{{ URL::to('/posts/' . encrypt($post['id'])) }}"
                                            class="sharePost cursor-pointer flex items-center gap-1 text-gray-700 hover:text-purple-600">
                                            <i class="ri-share-fill"></i> Share
                                        </small>
                                        @if (Auth::user()?->id == $post['user_id'])
                                            <small onclick="editPost({{ $post['id'] }})" class="editPost cursor-pointer flex items-center gap-1 text-gray-700 hover:text-purple-600">
                                                <i class="ri-pencil-fill"></i> Edit
                                            </small>
                                            <small onclick="deletePost('{{ $post['id'] }}')" class="deletePost cursor-pointer flex items-center gap-1 text-gray-700 hover:text-purple-600">
                                                <i class="ri-delete-bin-6-line"></i> Delete
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-full flex justify-center">
                            <img class="w-full h-64 object-cover rounded-xl" src="/storage/{{ $post['image'] }}" alt="Post image">
                        </div>
                        <div class="mt-3">
                            <p class="text-sm text-gray-700 leading-relaxed">{{ $post['deps'] }}</p>
                        </div>
                    </div>
                @endforeach
            @else
                <h2 class="text-xl font-semibold text-gray-600">No Post Found yet!</h2>
            @endif
        </div>
    </div>

    <script>
        function createPost(evt) {
            if ('{{ !Auth::check() }}') {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                    icon: 'info',
                    title: 'You Need to login!',
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                }).then(() => {
                    window.open('/login', '_self')
                });
            }
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
                            timer: 2000,
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
                        $('.post_wrapper')[0].classList.add('hidden')
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true,
                            icon: 'success',
                            title: res.message,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })
                    }
                },
                error: function(res) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
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
            $('.post_id').val('')
            $('.createPost')[0].reset()
            $('.createPostTitleAndBtn').text('Create Post')
            $('.previmg').attr('src', '')
            if ($('.post_wrapper')[0].classList.contains('hidden')) {
                $('.post_wrapper')[0].classList.remove('hidden')
            } else {
                $('.post_wrapper')[0].classList.add('hidden')
            }
        })
        $('.actionShowBtn').click(function(evt) {
            evt.target.classList.toggle('ri-more-2-line')
            evt.target.classList.toggle('ri-close-large-line')
            let el = evt.target.nextElementSibling
            el.classList.contains('hidden') ? el.classList.remove('hidden') : el.classList.add('hidden')
        })
        $('.sharePost').click(function(evt) {
            $('.actionBtnWrapper').each(function() {
                this.classList.add('hidden');
            })
            $('.actionShowBtn').each(function() {
                this.classList.add('ri-more-2-line')
                this.classList.remove('ri-close-large-line')
            })
            let urlForCopy = evt.target.getAttribute('copyUrl')
            navigator.clipboard.writeText(urlForCopy).then(() =>
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    icon: 'success',
                    title: 'Url Cpoied!',
                })
            );
        })
        function editPost(post_id) {
            $('.createPostTitleAndBtn').text('Edit Post')
            $.ajax({
                url: '{{ route('get.post') }}',
                type: 'get',
                data: {
                    post_id
                },
                success: function(res) {
                    if (res.status) {
                        $(".previmg").attr('src', `/storage/${res.post.image}`)
                        $(".depsTextarea").val(res.post.deps);
                    }
                },
                error: function(err) {}
            })
            $('.actionShowBtn').each(function() {
                this.classList.add('ri-more-2-line')
                this.classList.remove('ri-close-large-line')
            })
            $('.actionBtnWrapper').addClass('hidden')
            if (post_id) {
                $('.post_id').val(post_id)
            }
            if ($('.post_wrapper')[0].classList.contains('hidden')) {
                $('.post_wrapper')[0].classList.remove('hidden')
            } else {
                $('.post_wrapper')[0].classList.add('hidden')
            }
        }
        function deletePost(post_id) {
            $('.actionBtnWrapper').each(function() {
                this.classList.add('hidden');
            })
            $('.actionShowBtn').each(function() {
                this.classList.add('ri-more-2-line')
                this.classList.remove('ri-close-large-line')
            })
            if (!post_id) {
                return Swal.fire({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                    icon: 'info',
                    title: 'Post Id is required!',
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });
            }
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('delete.post') }}',
                        type: 'GET',
                        data: {
                            post_id: post_id
                        },
                        success: function(res) {
                            if (res.success) {
                                Swal.fire({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 2000,
                                    icon: 'success',
                                    title: res.message,
                                })
                            } else {
                                Swal.fire({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 2000,
                                    icon: 'info',
                                    title: res.message,
                                })
                            }
                        },
                        error: function(err) {}
                    })
                } else {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        icon: 'info',
                        title: "Post Could'nt delete!",
                    })
                }
            })
        }
        function follow(el){     
            let isFollow = el.getAttribute('isFollow') 
            if(isFollow == 0){
                el.innerText = 'Following'
                el.setAttribute('isFollow', 1)
            } else {
                el.innerText = 'Follow'
                el.setAttribute('isFollow', 0)
            }
        }
    </script>
</body>
</html>