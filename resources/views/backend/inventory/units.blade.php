@extends('backend.layouts.layout')
@section('title', 'All Units - Raza Mall')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Manage units</h4>
                    <h6>Manage your  Units</h6>
                </div>            
            </div>          

            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5>{{ $editable_unit ? 'Edit Unit' : 'Add Unit' }}</h5>
                            <hr>

                           <form method="POST"
                                action="{{ $editable_unit ? route('unit.update', $editable_unit) : route('unit.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                @if($editable_unit)
                                    @method('PUT')
                                @endif

                                <div class="form-group mb-3">
                                    <label class="form-label" for="name">Name*</label>
                                    <input type="text" required name="name" id="name" class="form-control"
                                           value="{{ old('name', $editable_unit->name ?? '') }}">
                                    @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                              
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary w-100">{{ $editable_unit ? 'Update' : 'Submit' }}</button>
                                    @if($editable_unit)
                                        <a href="{{ route('unit.index') }}" class="btn btn-light w-100">Cancel</a>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table datanew">
                                    <thead>
                                        <tr>                                         
                                           
                                            <th>Unit</th>        
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($units_data as $unit)
                                        <tr class="{{ $editable_unit && $editable_unit->id === $unit->id ? 'table-primary' : '' }}">
                                         
                                          
                                            <td>{{ $unit->name }}</td>
                                          
                                            <td>
                                                <a href="{{ route('unit.edit', $unit->id) }}" class="me-3">
                                                    <img src="{{ asset('backend/assets/img/icons/edit.svg') }}" alt="edit">
                                                </a>

                                                <a href="#" onclick="if(confirm('Are you sure to permanently delete this?')) { document.getElementById('deleteUnit-{{ $unit->id }}').submit(); } return false;">
                                                    <img src="{{ asset('backend/assets/img/icons/delete.svg') }}" alt="delete">
                                                </a>
                                                <form id="deleteUnit-{{ $unit->id }}" action="{{ route('unit.destroy', $unit->id) }}" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
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

        
        </div>
    </div>

@endsection