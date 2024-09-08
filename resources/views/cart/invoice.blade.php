@extends('layouts.main')

@section('main')
    <div class="container mt-5 mb-5">
        <div class="d-flex justify-content-center mt-3 mb-2">
            <a href="{{ route('invoice.generate', ['order_number' => $orders->first()->order_number]) }}" class="btn btn-dark text-center">
                <i class="bi bi-file-earmark-arrow-down"> Download</i>
            </a>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="text-left logo p-2 px-5 mt-2">
                        <h3><i class="bi bi-bag-check"> E-Commerce</i></h3>
                    </div>
                    <h3 class="text-center">Order Invoice</h3>
                    <div class="invoice p-5 my-0">
                        <h5 class="text-center">Your order has been confirmed!</h5>
                        <span class="font-weight-bold d-block mt-4">Hello, {{ Auth::user()->name }}</span>
                        <span>Your order has been confirmed and will be shipped in the next two days!</span>

                        <div class="payment border-top mt-3 mb-3 border-bottom table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="py-2">
                                                <span class="d-block text-muted">Order Date</span>
                                                <span>{{ $orders->first()->created_at->format('d M, Y') }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="py-2">
                                                <span class="d-block text-muted">Order No</span>
                                                <span>{{ $orders->first()->id }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="py-2">
                                                <span class="d-block text-muted">Payment</span>
                                                <span>
                                                    <img src="https://img.icons8.com/color/48/000000/mastercard.png" width="20" alt="Payment Method">
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="py-2">
                                                <span class="d-block text-muted">Shipping Address</span>
                                                <span>
                                                    {{ Auth::user()->address }}, {{ Auth::user()->city }},
                                                    {{ Auth::user()->state }}, {{ Auth::user()->country }},
                                                    {{ Auth::user()->zipcode }}
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="product border-bottom table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    @foreach ($orders as $item)
                                        @php
                                            $product = $item->product;
                                            $images = json_decode($product->image);
                                        @endphp
                                        <tr>
                                            <td width="20%">
                                                @if (!empty($images))
                                                    <img src="{{ asset('storage/' . $images[0]) }}" width="90" alt="{{ $product->name }}">
                                                @endif
                                            </td>
                                            <td width="60%">
                                                <span class="font-weight-bold">{{ $product->name }}</span>
                                                <div class="product-qty">
                                                    <span class="d-block">Quantity: {{ $item->product_qty }}</span>
                                                </div>
                                            </td>
                                            <td width="20%">
                                                <div class="text-right">
                                                    <span class="font-weight-bold">₹{{ number_format($item->product_price, 2) }}</span>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="2" class="text-right">
                                            <span class="font-weight-bold">Subtotal:</span>
                                        </td>
                                        <td>
                                            <div class="text-right">
                                                <span class="font-weight-bold">₹{{ number_format($subtotal, 2) }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="text-right">
                                            <span class="font-weight-bold">Shipping Fee:</span>
                                        </td>
                                        <td>
                                            <div class="text-right">
                                                <span class="font-weight-bold">₹{{ number_format($shippingFee, 2) }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="text-right">
                                            <span class="font-weight-bold">Tax:</span>
                                        </td>
                                        <td>
                                            <div class="text-right">
                                                <span class="font-weight-bold">₹{{ number_format($taxFee, 2) }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="text-right">
                                            <span class="font-weight-bold">Discount:</span>
                                        </td>
                                        <td>
                                            <div class="text-right">
                                                <span class="font-weight-bold">₹{{ number_format($discount, 2) }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="text-right">
                                            <span class="font-weight-bold">Total:</span>
                                        </td>
                                        <td>
                                            <div class="text-right">
                                                <span class="font-weight-bold">₹{{ number_format($total, 2) }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <p class="mb-0">We will be sending a shipping confirmation email when the item is shipped successfully!</p>
                        <p class="font-weight-bold mb-0">Thanks for shopping with us!</p>
                        <span>E-commerce Team</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
