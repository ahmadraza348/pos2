@extends('backend.layouts.layout')
@section('title', 'All Customers - Raza Mall')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Manage Customers</h4>
                    <h6>Manage your Customers</h6>
                </div>            
            </div>

             <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5>{{ $editable_customer ? 'Edit Customer' : 'Add Customer' }}</h5>
                            <hr>

                           <form method="POST"
                                action="{{ $editable_customer ? route('customer.update', $editable_customer) : route('customer.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                @if($editable_customer)
                                    @method('PUT')
                                @endif

                             <div class="row">
                                
                                   <div class="col-md-6 form-group mb-3">
                                    <label class="form-label" for="name">Name*</label>
                                    <input type="text" required name="name" id="name" class="form-control"
                                           value="{{ old('name', $editable_customer->name ?? '') }}">
                                    @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6 form-group mb-3">
                                    <label class="form-label" for="email">Email</label>
                                    <input type="email" name="email" id="email" class="form-control"
                                           value="{{ old('email', $editable_customer->email ?? '') }}">
                                    @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                 <div class="col-md-6 form-group mb-3">
                                    <label class="form-label" for="phone">Phone</label>
                                    <input type="text" name="phone" id="phone" class="form-control"
                                           value="{{ old('phone', $editable_customer->phone ?? '') }}">
                                    @error('phone') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                 <div class="col-md-6 form-group mb-3">
                                    <label class="form-label" for="city">City</label>
                                    <input type="text" name="city" id="city" class="form-control"
                                           value="{{ old('city', $editable_customer->city ?? '') }}">
                                    @error('city') <span class="text-danger small">{{ $message }}</span> @enderror
                                 </div> 
                                 
                                 <div class="col-md-6 form-group mb-3">
                                    <label class="form-label" for="address">Address</label>
                                    <input type="text" name="address" id="address" class="form-control"
                                           value="{{ old('address', $editable_customer->address ?? '') }}">
                                    @error('address') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                              

                                
                                <div class="col-md-6 form-group mb-3">
                                    <label class="form-label" for="opening_balance">Opening Balance</label>
                                    <input type="number"  name="opening_balance" id="opening_balance" class="form-control"
                                           value="{{ old('opening_balance', $editable_customer->opening_balance ??  '0') }}">
                                    @error('opening_balance') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                  
                                
                               
                                <div class="col-md-6 form-group mb-3">
                                    <label class="form-label" for="balance_type">Balance Type</label>
                                    <select name="balance_type" id="balance_type" class="form-select">
                                        <option value="" {{ old('balance_type', $editable_customer->balance_type ?? '') == '' ? 'selected' : '' }}>Select</option>
                                        <option value="receivable" {{ old('balance_type', $editable_customer->balance_type ?? '') == 'receivable' ? 'selected' : '' }}>Receivable</option>
                                        <option value="payable" {{ old('balance_type', $editable_customer->balance_type ?? '') == 'payable' ? 'selected' : '' }}>Payable</option>
                                    </select>
                                    @error('balance_type') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                
                                <div class="col-md-6 form-group mb-3">
                                    <label class="form-label" for="status">Status*</label>
                                    <select name="status" required class="form-select" id="status">
                                        <option value="0" {{ old('status', $editable_customer->status ?? '0') == '0' ? 'selected' : '' }}>Blocked</option>
                                        <option value="1" {{ old('status', $editable_customer->status ?? '1') == '1' ? 'selected' : '' }}>Active</option>
                                    </select>
                                    @error('status') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                
                                 <div class="col-md-6  form-group mb-3">
                                    <label class="form-label" for="image">Image</label>
                                    <input type="file" name="image" class="form-control" id="image" accept="image/*" onchange="previewImage(event)">
                                    @error('image') <span class="text-danger small">{{ $message }}</span> @enderror
                                 </div>
                            <div class="col-md-6 form-group mb-3">
                                    
                                    <div class="mt-2 text-center">
                                        @if($editable_customer && $editable_customer->image)
                                            <img id="imagePreview" src="{{ asset('storage/' . $editable_customer->image) }}" alt="Preview" style="max-width: 100%; max-height: 150px; border-radius: 8px;">
                                        @else
                                            <img id="imagePreview" src="#" alt="Preview" style="display: none; max-width: 100%; max-height: 150px; border-radius: 8px;">
                                        @endif
                                    </div>
                                </div>

                                 <div class="form-group mb-3">
                                    <label class="form-label" for="notes">Notes</label>
                                    <textarea name="notes" class="form-control" id="notes" rows="4">{{ old('notes', $editable_customer->notes ?? '') }}</textarea>
                                    @error('notes') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>



                               

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary ">{{ $editable_customer ? 'Update' : 'Submit' }}</button>
                                    @if($editable_customer)
                                        <a href="{{ route('customer.index') }}" class="btn btn-light ">Cancel</a>
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
                            <h5>All Customers</h5>
                            <hr>
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
                                            <th>Phone</th>                  
                                            <th>City</th>                  
                                            <th>Opening Balance</th>                  
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customer_data as $customer)
                                        <tr class="{{ $editable_customer && $editable_customer->id === $customer->id ? 'table-primary' : '' }}">
                                            <td>
                                                <label class="checkboxs">
                                                    <input type="checkbox" class="select-option" data-id="{{ $customer->id }}" onchange="toggleDeleteButton()">
                                                    <span class="checkmarks"></span>
                                                </label>
                                            </td>                                            
                                            <td>{{ $customer->name }}</td>
                                            <td>{{ $customer->city }}</td>
                                            <td>{{ $customer->phone }}</td>
                                            <td>{{ $customer->opening_balance }}</td>
                                            <td>
                                                <span class="badge rounded-pill {{ $customer->status == '1' ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $customer->status == '1' ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('customer.edit', $customer->id) }}" class="me-3">
                                                    <img src="{{ asset('backend/assets/img/icons/edit.svg') }}" alt="edit">
                                                </a>

                                                <a href="#" onclick="if(confirm('Are you sure to permanently delete this?')) { document.getElementById('deleteCustomer-{{ $customer->id }}').submit(); } return false;">
                                                    <img src="{{ asset('backend/assets/img/icons/delete.svg') }}" alt="delete">
                                                </a>
                                                <form id="deleteCustomer-{{ $customer->id }}" action="{{ route('customer.destroy', $customer->id) }}" method="POST" style="display: none;">
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
           

            <form id="bulk-delete-form" action="{{ route('customer.bulk-delete') }}" method="POST" style="display: none;">
                @csrf
                <input type="hidden" name="customer_ids" id="option-ids">
            </form>
        </div>
    </div>

@endsection