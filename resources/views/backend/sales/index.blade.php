@extends('backend.layouts.layout')
@section('title', 'Create Product - Raza Mall')

@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Sales List</h4>
                    <h6>Manage your sales</h6>
                </div>
                {{-- <div class="page-btn">
                        <a href="add-sales.html" class="btn btn-added"><img src="{{asset('backend/assets/img/icons/plus.svg')}}" alt="img"
                                class="me-1">Add Sales</a>
                    </div> --}}
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-top">
                        <div class="search-set">
                            {{-- <div class="search-path">
                                    <a class="btn btn-filter" id="filter_search">
                                        <img src="{{asset('backend/assets/img/icons/filter.svg')}}" alt="img">
                                        <span><img src="{{asset('backend/assets/img/icons/closes.svg')}}" alt="img"></span>
                                    </a>
                                </div> --}}

                        </div>
                        <div class="wordset">
                            <ul>
                                <li><a href="{{ route('sales.export') }}" data-bs-toggle="tooltip" title="Download Excel">
                                        <img src="{{ asset('backend/assets/img/icons/excel.svg') }}" alt="img">
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- <div class="card" id="filter_inputs">
                            <div class="card-body pb-0">
                                <div class="row">
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <input type="text" placeholder="Enter Name">
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <input type="text" placeholder="Enter Reference No">
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <select class="select">
                                                <option>Completed</option>
                                                <option>Paid</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <a class="btn btn-filters ms-auto"><img
                                                    src="{{asset('backend/assets/img/icons/search-whites.svg')}}" alt="img"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}

                    <div class="table-responsive">
                        <table class="table  datanew">
                            <thead>
                                <tr>
                                    <th>
                                        <label class="checkboxs">
                                            <input type="checkbox" id="select-all">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </th>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Reference</th>
                                    <th>Customer</th>
                                    <th>Total</th>
                                    <th>Payment </th>
                                    <th>Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sales as $item)
                                    <tr>
                                        <td>
                                            <label class="checkboxs">
                                                <input type="checkbox">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('Y-m-d\ H:i') }}</td>
                                        <td>Website</td>
                                        <td>{{ $item->order_number }}</td>
                                        <td>{{ $item->billing_first_name }} {{ $item->billing_last_name }}</td>
                                        <td>{{ $item->total_amount }}</td>
                                        <td>{{ $item->payment_method }}</td>
                                        @if ($item->payment_status == 'paid')
                                            <td><span class="badges bg-lightgreen">Paid</span></td>
                                        @else
                                            <td><span class="badges bg-danger">Pending</span></td>
                                        @endif
                                        <td class="text-center">
                                            <a class="action-set" href="javascript:void(0);" data-bs-toggle="dropdown"
                                                aria-expanded="true">
                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a href="{{ route('sales.detail', $item->id) }}"
                                                        class="dropdown-item"><img
                                                            src="{{ asset('backend/assets/img/icons/eye1.svg') }}"
                                                            class="me-2" alt="img">Sale
                                                        Detail</a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('sales.download_pdf', ['id' => $item->id]) }}"
                                                        class="dropdown-item"><img
                                                            src="{{ asset('backend/assets/img/icons/download.svg') }}"
                                                            class="me-2" alt="img">Download pdf</a>
                                                </li>
                                            </ul>
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
