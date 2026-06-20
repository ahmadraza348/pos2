@extends('backend.layouts.layout')
@section('title', 'Create Product - Raza Mall')

@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Sale Details</h4>
                    <h6>View sale details</h6>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="card-sales-split">
                        <h2>Sale Detail : {{ $order->order_number }}</h2>
                        <ul>
                            <li>
                                <a href="{{ route('sales.download_pdf', ['id' => $order->id]) }}"><img
                                        src="{{ asset('backend/assets/img/icons/pdf.svg') }}" alt="img"></a>
                            </li>
                            <li>
                                <a href="{{ route('sales.print', ['id' => $order->id]) }}" target="_blank">
                                    <img src="{{ asset('backend/assets/img/icons/printer.svg') }}" alt="img">
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="invoice-box table-height"
                        style="max-width: 1600px;width:100%;overflow: auto;margin:15px auto;padding: 0;font-size: 14px;line-height: 24px;color: #555;">
                        <table cellpadding="0" cellspacing="0" style="width: 100%;line-height: inherit;text-align: left;">
                            <tbody>
                                <tr class="top">
                                    <td colspan="6" style="padding: 5px;vertical-align: top;">
                                        <table style="width: 100%;line-height: inherit;text-align: left;">
                                            <tbody>
                                                <tr>
                                                    <td
                                                        style="padding:5px;vertical-align:top;text-align:left;padding-bottom:20px">
                                                        <font style="vertical-align: inherit;margin-bottom:25px;">
                                                            <font
                                                                style="vertical-align: inherit;font-size:14px;color:#7367F0;font-weight:600;line-height: 35px; ">
                                                                Billing Info</font>
                                                        </font><br>
                                                        <font style="vertical-align: inherit;">
                                                            <font
                                                                style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                                Name: {{ $order->billing_first_name }}
                                                                {{ $order->billing_last_name }}</font>
                                                        </font><br>

                                                        <font style="vertical-align: inherit;">
                                                            <font
                                                                style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                                Email: {{ $order->billing_email }} </font>
                                                        </font><br>

                                                        <font style="vertical-align: inherit;">
                                                            <font
                                                                style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                                Phone: {{ $order->billing_phone }}</font>
                                                        </font><br>
                                                        <font style="vertical-align: inherit;">
                                                            <font
                                                                style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                                Country: {{ $order->billing_country }}</font>
                                                        </font><br>

                                                        <font style="vertical-align: inherit;">
                                                            <font
                                                                style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                                City: {{ $order->billing_city ?? ' ' }}</font>
                                                        </font><br>
                                                        <font style="vertical-align: inherit;">
                                                            <font
                                                                style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                                State: {{ $order->billing_state ?? ' ' }}</font>
                                                        </font><br>
                                                        <font style="vertical-align: inherit;">
                                                            <font
                                                                style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                                Post Code: {{ $order->billing_postcode ?? ' ' }}</font>
                                                        </font><br>

                                                        <font style="vertical-align: inherit;">
                                                            <font
                                                                style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                                Company: {{ $order->billing_company ?? ' ' }}</font>
                                                        </font><br>

                                                        <font style="vertical-align: inherit;">
                                                            <font
                                                                style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                                Address 1: {{ $order->billing_address_1 }}</font>
                                                        </font><br>
                                                        <font style="vertical-align: inherit;">
                                                            <font
                                                                style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                                Address 2: {{ $order->billing_address_2 }}</font>
                                                        </font><br>
                                                    </td>
                                                    <td
                                                        style="padding:5px;vertical-align:top;text-align:left;padding-bottom:20px">
                                                        <font style="vertical-align: inherit;margin-bottom:25px;">
                                                            <font
                                                                style="vertical-align: inherit;font-size:14px;color:#7367F0;font-weight:600;line-height: 35px; ">
                                                                Shippin Info</font>
                                                        </font><br>
                                                        <font style="vertical-align: ginherit;">
                                                            <font
                                                                style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                                Name: {{ $order->shipping_first_name }}
                                                                {{ $order->shipping_last_name }}</font>
                                                        </font><br>

                                                        <font style="vertical-align: inherit;">
                                                            <font
                                                                style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                                Email: {{ $order->shipping_email }} </font>
                                                        </font><br>

                                                        <font style="vertical-align: inherit;">
                                                            <font
                                                                style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                                Phone: {{ $order->shipping_phone }}</font>
                                                        </font><br>
                                                        <font style="vertical-align: inherit;">
                                                            <font
                                                                style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                                Country: {{ $order->shipping_country }}</font>
                                                        </font><br>

                                                        <font style="vertical-align: inherit;">
                                                            <font
                                                                style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                                City: {{ $order->shipping_city ?? ' ' }}</font>
                                                        </font><br>
                                                        <font style="vertical-align: inherit;">
                                                            <font
                                                                style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                                State: {{ $order->shipping_state ?? ' ' }}</font>
                                                        </font><br>
                                                        <font style="vertical-align: inherit;">
                                                            <font
                                                                style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                                Post Code: {{ $order->shipping_postcode ?? ' ' }}</font>
                                                        </font><br>

                                                        <font style="vertical-align: inherit;">
                                                            <font
                                                                style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                                Company: {{ $order->shipping_company ?? ' ' }}</font>
                                                        </font><br>

                                                        <font style="vertical-align: inherit;">
                                                            <font
                                                                style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                                Address 2: {{ $order->shipping_address_2 }}</font>
                                                        </font><br>
                                                    </td>

                                                    <td
                                                        style="padding:5px;vertical-align:top;text-align:left;padding-bottom:20px">
                                                        <font style="vertical-align: inherit;margin-bottom:25px;">
                                                            <font
                                                                style="vertical-align: inherit;font-size:14px;color:#7367F0;font-weight:600;line-height: 35px; ">
                                                                Invoice Info</font>
                                                        </font><br>
                                                        <font style="vertical-align: inherit;">
                                                            <font
                                                                style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                                Reference </font>
                                                        </font><br>

                                                        <font style="vertical-align: inherit;">
                                                            <font
                                                                style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                                Order Status</font>
                                                        </font><br>
                                                    </td>
                                                    <td
                                                        style="padding:5px;vertical-align:top;text-align:right;padding-bottom:20px">
                                                        <font style="vertical-align: inherit;margin-bottom:25px;">
                                                            <font
                                                                style="vertical-align: inherit;font-size:14px;color:#7367F0;font-weight:600;line-height: 35px; ">
                                                                &nbsp;</font>
                                                        </font><br>
                                                        <font style="vertical-align: inherit;">
                                                            <font
                                                                style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                                {{ $order->order_number }} </font>
                                                        </font><br>
                                                        <font style="vertical-align: inherit;">
                                                            <font
                                                                style="vertical-align: inherit;font-size: 14px;color:#2E7D32;font-weight: 400;">
                                                                {{ $order->order_status }}</font>
                                                        </font><br>
                                                        <font style="vertical-align: inherit;">

                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <p> <strong>Order Note:</strong> {{ $order->order_note ?? ' ' }}</p>
                                    </td>
                                </tr>
                                <tr class="heading " style="background: #F3F2F7;">
                                    <td
                                        style="padding: 5px;vertical-align: middle;font-weight: 600;color: #5E5873;font-size: 14px;padding: 10px; ">
                                        Product
                                    </td>
                                    <td
                                        style="padding: 5px;vertical-align: middle;font-weight: 600;color: #5E5873;font-size: 14px;padding: 10px; ">
                                        QTY
                                    </td>
                                    <td
                                        style="padding: 5px;vertical-align: middle;font-weight: 600;color: #5E5873;font-size: 14px;padding: 10px; ">
                                        Price
                                    </td>
                                    <td
                                        style="padding: 5px;vertical-align: middle;font-weight: 600;color: #5E5873;font-size: 14px;padding: 10px; ">
                                        Subtotal
                                    </td>
                                </tr>

                                @foreach ($order->items as $item)
                                    <tr class="details" style="border-bottom:1px solid #E9ECEF ;">

                                        @php
                                            $colorImage = $item->images->where('color_id', $item->color_id)->first();
                                        @endphp
                                        <td style="padding: 10px;vertical-align: top; display: flex;align-items: center;">

                                            <a href="{{ route('pro.details', $item->product->slug) }}">
                                                <img src="{{ asset('storage/' . $colorImage->image) }}" alt="img"
                                                    class="me-2" style="width:100px;height:100px;">
                                            </a>

                                            {{ $item->product_name }} <br>
                                            Color : {{ $item->color_name }} <br>
                                            {{ $item->attribute_name }} :
                                            {{ $item->attribute_value }} <br>

                                        </td>
                                        <td style="padding: 10px;vertical-align: top; ">
                                            {{ $item->quantity }}
                                        </td>
                                        <td style="padding: 10px;vertical-align: top; ">
                                            {{ $item->price }}
                                        </td>
                                        <td style="padding: 10px;vertical-align: top; ">
                                            {{ $item->line_total }}
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">


                        <div class="row">
                            <div class="col-lg-6 ">

                                <form action="{{ route('sales.update.status', $order->id) }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select class="select" name="order_status">
                                            <option>Choose Status</option>
                                            <option {{ $order->order_status == 'pending' ? 'selected' : '' }}
                                                value="pending">Pending</option>
                                            <option {{ $order->order_status == 'completed' ? 'selected' : '' }}
                                                value="completed">Completed</option>
                                            <option {{ $order->order_status == 'cancelled' ? 'selected' : '' }}
                                                value="cancelled">Cancelled</option>
                                            <option {{ $order->order_status == 'ready_to_pickup' ? 'selected' : '' }}
                                                value="ready_to_pickup">Ready to pickup</option>
                                            <option {{ $order->order_status == 'advance_payment' ? 'selected' : '' }}
                                                value="advance_payment">Advance Payment</option>
                                            <option {{ $order->order_status == 'on_hold' ? 'selected' : '' }}
                                                value="on_hold">On Hold</option>
                                            <option {{ $order->order_status == 'returned' ? 'selected' : '' }}
                                                value="returned">Order Returned</option>

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Comment</label>
                                        <textarea name="order_comment" class="form-control" rows="5">{{ $order->order_comment }}</textarea>
                                    </div>

                                    <div class="col-lg-12">
                                        <button type="submit" class="btn btn-submit me-2">Update Status</button>
                                    </div>

                                </form>


                            </div>
                            <div class="col-lg-6 ">
                                <div class="total-order w-100 max-widthauto m-auto mb-4">
                                    <ul>
                                        <li>
                                            <h4>Sub Total</h4>
                                            <h5>{{ $order->subtotal }}</h5>
                                        </li>
                                        <li>
                                            <h4>Shipping</h4>
                                            <h5>{{ $order->shipping_charge }}</h5>
                                        </li>
                                        <li>
                                            <h4>Discount </h4>
                                            <h5>{{ $order->discount }}</h5>
                                        </li>

                                        <li class="total">
                                            <h4>Grand Total</h4>
                                            <h5>{{ $order->total_amount }}</h5>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
