<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://kit.fontawesome.com/f63a52de74.js" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Post List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    @include('layout.dist')
</head>

<body>
    @include('layout.sidebar')

    <style type="text/css">
        .pagination li{
            float: left;
            list-style-type: none;
            margin:5px;
        }
        table{min-width:300px;}
    </style>

    @include('layout.wrapper')

    <div class="container mt-1">
        <div class="row">
            <div class="col-md-12">
                <h1>POST</h1><br>
                
                <!-- Notifikasi menggunakan flash session data -->
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                @if (session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
                @endif

                <div class="card border-0 shadow rounded">
                    <div class="card-body">
                        <form action="/post/search" method="GET">
                            <input type="text" name="search" placeholder="Search posts with title ..." value="{{ old('search') }}">
                            <select name="search_category">
                                <option value="-1" selected>All Categories</option>
                                <option value="0">No Category</option>
                                @foreach ($category as $cat)
                                    <option value="{{$cat->id}}">{{$cat->name}}</option>
                                @endforeach
                            </select>
                            <input type="submit" value="search">
                        </form>
                        <a href="{{ route('post.create') }}" class="btn btn-md btn-success mb-3 float-right">New
                            Post</a>

                        <table class="table table-bordered mt-1">
                            <thead>
                                <tr>
                                    <th scope="col">@sortablelink('title', 'Title')</th>
                                    <th scope="col">@sortablelink('status', 'Status')</th>
                                    <th scope="col">@sortablelink('category', 'Category')</th>
                                    <th scope="col">@sortablelink('created_at', 'Created At')</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($posts as $post)
                                <tr>
                                    <td>{{ $post->title }}</td>
                                    <td>{{ $post->status == 0 ? 'Draft':'Publish' }}</td>
                                    <td>{{ $post->Category->name ?? 'No Category' }}</td>
                                    <td>{{ $post->created_at->format('d-m-Y H:i:s') }}</td>
                                    <td class="text-center">
                                        <form onsubmit="return confirm('Apakah Anda Yakin ?');"
                                            action="{{ route('post.destroy', $post->id) }}" method="POST">
                                            <a href="{{ route('post.edit', $post->id) }}"
                                                class="btn btn-sm btn-primary">EDIT</a>
                                            <a href="{{ route('post.show', $post->id) }}"
                                                class="btn btn-sm btn-primary">VIEW</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">HAPUS</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="text-center text-mute" colspan="4">Data post tidak tersedia</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <!-- <div>
                            Halaman : {{ $posts->currentPage() }} <br/>
                            Jumlah Data : {{ $posts->total() }} <br/>
                            Data Per Halaman : {{ $posts->perPage() }} <br/> 
                        </div>
                        <br>
                        <div>
                            {{ $posts->links() }}
                        </div> -->
                        {!! $posts->appends(\Request::except('page'))->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>