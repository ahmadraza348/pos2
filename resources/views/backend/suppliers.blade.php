@extends('backend.layouts.layout')
@section('title', 'All Suppliers - Raza Mall')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Manage Suppliers</h4>
                    <h6>Manage your Product Suppliers</h6>
                </div>            
            </div>

             <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5>{{ $editable_supplier ? 'Edit Supplier' : 'Add Supplier' }}</h5>
                            <hr>

                           <form method="POST"
                                action="{{ $editable_supplier ? route('supplier.update', $editable_supplier) : route('supplier.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                @if($editable_supplier)
                                    @method('PUT')
                                @endif

                             <div class="row">
                                
                                   <div class="col-md-6 form-group mb-3">
                                    <label class="form-label" for="name">Name*</label>
                                    <input type="text" required name="name" id="name" class="form-control"
                                           value="{{ old('name', $editable_supplier->name ?? '') }}">
                                    @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6 form-group mb-3">
                                    <label class="form-label" for="email">Email*</label>
                                    <input type="email" required name="email" id="email" class="form-control"
                                           value="{{ old('email', $editable_supplier->email ?? '') }}">
                                    @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                
                                <div class="col-md-6 form-group mb-3">
                                    <label class="form-label" for="company_name">Company Name*</label>
                                    <input type="text" required name="company_name" id="company_name" class="form-control"
                                           value="{{ old('company_name', $editable_supplier->company_name ?? '') }}">
                                    @error('company_name') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                   <div class="col-md-6 form-group mb-3">
                                    <label class="form-label" for="phone">Phone*</label>
                                    <input type="text" required name="phone" id="phone" class="form-control"
                                           value="{{ old('phone', $editable_supplier->phone ?? '') }}">
                                    @error('phone') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                              
                                
                                <div class="col-md-6 form-group mb-3">
                                    <label class="form-label" for="address">Address*</label>
                                    <input type="text" required name="address" id="address" class="form-control"
                                           value="{{ old('address', $editable_supplier->address ?? '') }}">
                                    @error('address') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6 form-group mb-3">
                                    <label class="form-label" for="opening_balance">Opening Balance*</label>
                                    <input type="number" required name="opening_balance" id="opening_balance" class="form-control"
                                           value="{{ old('opening_balance', $editable_supplier->opening_balance ?? '') }}">
                                    @error('opening_balance') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>


                                <div class="col-md-6 form-group mb-3">
                                    <label class="form-label" for="status">Status*</label>
                                    <select name="status" required class="form-select" id="status">
                                        <option value="1" {{ old('status', $editable_supplier->status ?? '1') == '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status', $editable_supplier->status ?? '0') == '0' ? 'selected' : '' }}>Blocked</option>
                                    </select>
                                    @error('status') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                               

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary ">{{ $editable_supplier ? 'Update' : 'Submit' }}</button>
                                    @if($editable_supplier)
                                        <a href="{{ route('supplier.index') }}" class="btn btn-light ">Cancel</a>
                                    @endif
                                </div>
                             </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5>All Suppliers</h5>
                            <hr                       
                            <div class="table-responsive">
                                <table class="table datanew">
                                    <thead>
                                        <tr>
                                            <th>
                                                <label class="checkboxs">
                                                    <input type="checkbox" id="select-all" onclick="selectAll(this)">
                                                    <span class="checkmarks"></span>
                                                </label>
                                            </th>
                                            <th>Name</th>                  
                                            <th>Company Name</th>                  
                                            <th>Email</th>                  
                                            <th>Phone</th>                  
                                            <th>Address</th>                  
                                            <th>Opening Balance</th>                  
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($suppliers_data as $supplier)
                                        <tr class="{{ $editable_supplier && $editable_supplier->id === $supplier->id ? 'table-primary' : '' }}">
                                            <td>
                                                <label class="checkboxs">
                                                    <input type="checkbox" class="select-option" data-id="{{ $supplier->id }}" onchange="toggleDeleteButton()">
                                                    <span class="checkmarks"></span>
                                                </label>
                                            </td>                                            
                                            <td>{{ $supplier->name }}</td>
                                            <td>{{ $supplier->company_name }}</td>
                                            <td>{{ $supplier->email }}</td>
                                            <td>{{ $supplier->phone }}</td>
                                            <td>{{ $supplier->address }}</td>
                                            <td>{{ $supplier->opening_balance }}</td>
                                            <td>
                                                <span class="badge rounded-pill {{ $supplier->status == '1' ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $supplier->status == '1' ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('supplier.edit', $supplier->id) }}" class="me-3">
                                                    <img src="{{ asset('backend/assets/img/icons/edit.svg') }}" alt="edit">
                                                </a>

                                                <a href="#" onclick="if(confirm('Are you sure to permanently delete this?')) { document.getElementById('deleteSupplier-{{ $supplier->id }}').submit(); } return false;">
                                                    <img src="{{ asset('backend/assets/img/icons/delete.svg') }}" alt="delete">
                                                </a>
                                                <form id="deleteSupplier-{{ $supplier->id }}" action="{{ route('supplier.destroy', $supplier->id) }}" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <button id="delete-selected-btn" class="btn btn-danger m-3" style="display: none;width:100px" onclick="deleteSelectedOptions()">
                                Delete 
                            </button>
                        </div>
                    </div>
                </div>
           

            <form id="bulk-delete-form" action="{{ route('supplier.bulk-delete') }}" method="POST" style="display: none;">
                @csrf
                <input type="hidden" name="supplier_ids" id="option-ids">
            </form>
        </div>
    </div>

@endsection