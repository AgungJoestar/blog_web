<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://kit.fontawesome.com/f63a52de74.js" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Category List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    @include('layout.dist')
</head>

<body>
    @include('layout.sidebar')
    @include('layout.wrapper')
    <div class="container mt-1">
        <div class="row">
            <div class="col-md-12">
                <h1>CATEGORY</h1>
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
                        <a href="{{ route('category.create') }}" class="btn btn-md btn-success mb-3 float-right">New
                            Category</a>

                        <table class="table table-bordered mt-1">
                            <thead>
                                <tr>
                                    <th scope="col">@sortablelink('name', 'Category')</th>
                                    <th scope="col">@sortablelink('created_at', 'Created At')</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($category as $cat)
                                <tr>
                                    <td>{{ $cat->name }}</td>
                                    <td>{{ $cat->created_at->format('d-m-Y H:i:s') }}</td>
                                    <td class="text-center">
                                        <form onsubmit="return confirm('Apakah Anda Yakin ?');"
                                            action="{{ route('category.destroy', $cat->id) }}" method="POST">
                                            <a href="{{ route('category.edit', $cat->id) }}"
                                                class="btn btn-sm btn-primary">EDIT</a>
                                            @csrf
                                            <a href="{{ route('category.delete', $cat->id) }}"
                                                class="btn btn-sm btn-danger" value="{{$cat->id}}" onclick="return confirm('Anda akan menghapus semua post dengan kategori yang dipilih, Apakah anda yakin?')">KOSONGKAN</a>
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">HAPUS</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="text-center text-mute" colspan="4">Data Kategori tidak tersedia</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {!! $category->appends(\Request::except('page'))->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>