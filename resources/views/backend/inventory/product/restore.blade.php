@extends('backend.layouts.layout')
@section('title', 'Trashed Products')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Trashed Products</h4>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table datanew">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>SKU</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Featured</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $item)
                                <tr>
                                    <td>
                                        <img src="{{ $item->image ? asset('storage/' . $item->image) : asset('backend/assets/img/noimage.png') }}"
                                            alt="{{ $item->name }}"
                                            style="width:60px; height:60px; border-radius:8px; object-fit:cover;">
                                    </td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->sku }}</td>
                                    <td>{{ number_format($item->selling_price, 2) }}</td>
                                    <td>{{ $item->stock }}</td>
                                    <td>
                                        @if ($item->is_featured)
                                            <span class="badge rounded-pill bg-success">Yes</span>
                                        @else
                                            <span class="badge rounded-pill bg-danger">No</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->status)
                                            <span class="badge rounded-pill bg-success">Active</span>
                                        @else
                                            <span class="badge rounded-pill bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="d-flex gap-2">
                                        <form action="{{ route('product.restore', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-success">Restore</button>
                                        </form>

                                        <form id="deletepro-{{ $item->id }}"
                                            action="{{ route('product.forceDelete', $item->id) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('delete')
                                        </form>

                                        <a onclick="if(confirm('Are you sure to permanently delete this?')) { document.getElementById('deletepro-{{ $item->id }}').submit(); } return false;"
                                            class="btn btn-sm btn-danger">
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection