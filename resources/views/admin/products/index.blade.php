@extends('layouts.app_admin')

@section('content')
<style>
    .table-custom th {
        background-color: #222;
        color: #f7a831;
    }
    .table-custom td {
        background-color: #111;
        color: #fff;
    }
</style>

<div class="container py-4">
    <h2 class="mb-4 text-warning">📦 Products</h2>

    @include('admin.products._flash')

    <a href="{{ route('admin.products.create') }}" class="btn btn-primary mb-3">
        + New Product
    </a>

    @if($products->count())
        <div class="table-responsive rounded">
            <table class="table table-custom align-middle">
                <thead>
                    <tr>
                        <th style="width:90px">Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th class="text-end">Price</th>
                        <th class="text-center">Stock</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $p)
                        <tr>
                            <td>
                                <img src="{{ $p->images->first()?->image ? Storage::url($p->images->first()->image) : asset('images/placeholder.jpg') }}"
                                     class="img-fluid rounded" style="height:60px; object-fit:cover;">
                            </td>
                            <td>{{ $p->name }}</td>
                            <td>{{ $p->category?->name . ' - ' . $p->category?->country ?? '—' }}</td>
                            <td class="text-end">${{ number_format($p->price, 0) }}</td>
                            <td class="text-center">{{ $p->stock }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.products.edit', $p) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $p) }}" method="POST"
                                      class="d-inline" onsubmit="return confirm('Delete this product?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3 text-white">
            {{ $products->links() }}
        </div>
    @else
        <p class="text-muted">No products found.</p>
    @endif
</div>
@endsection
