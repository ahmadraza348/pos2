@extends('backend.layouts.layout')
@section('title', 'All Attributes Values- Raza Mall')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Manage Attributes Value</h4>
                    
                </div>
                <div class="page-btn">
                    
                </div>
                <div class="page-btn">
                    <a href="{{ route('attributevalue.create') }}" class="btn btn-added"><img
                            src="{{ asset('backend/assets/img/icons/plus.svg') }}" alt="img">Add Attribute Value</a>
                </div>
        
            </div>


            <div class="card">
                
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table datanew">
                            <thead>
                                <tr>
                                    <th>Attribute</th>
                                    <th>Value</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($value as $item)
                                    <tr>
                  
                                        <td>{{ $item->attribute->name }} </td>
                                        <td>{{ $item->name }} </td>
                                    
                                      
                                        <td>
                                            @if ($item->status == '1')
                                                <span class="badge rounded-pill bg-success">Active</span>
                                            @else
                                                <span class="badge rounded-pill bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="
                                            {{ route('attributevalue.edit', $item->id) }}
                                             " class="me-3">
                                                <img src="{{ asset('backend/assets/img/icons/edit.svg') }}" alt="edit">
                                            </a>
            
                                            <!-- Delete Form (hidden) -->
                                            <form id="deleteCat-{{ $item->id }}" action="
                                                {{ route('attributevalue.destroy', $item->id) }}
                                                 " method="POST" style="display: none;">
                                                @csrf
                                                @method('delete')
                                            </form>
                                            
                                            <!-- Delete Icon -->
                                            <a onclick="if(confirm('Are you sure to permanently delete this?')) { document.getElementById('deleteCat-{{ $item->id }}').submit(); } return false;" class="me-3">
                                                <img src="{{ asset('backend/assets/img/icons/delete.svg') }}" alt="delete">
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <button id="delete-selected-btn" class="btn btn-danger btn-sm mt-3" style="display: none; " onclick="deleteSelectedCategories()">Delete Selected</button>
                </div>
            </div>

           
        </div>
    </div>
  
@endsection
