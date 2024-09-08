<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            padding: 20px;
        }

        .logo {
            text-align: left;
            margin-bottom: 20px;
        }

        .logo img {
            width: 50px;
        }

        .invoice {
            margin: 0;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .invoice h3 {
            margin-top: 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .table th {
            background-color: #f2f2f2;
        }

        .text-right {
            text-align: right;
        }

        .font-weight-bold {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="logo">
            <h3><i class="bi bi-bag-check"> E-Commerce</i></h3>
        </div>
        <div class="invoice">
            <h3 class="text-center">Order Invoice</h3>
            <p class="text-center font-weight-bold">Your order has been confirmed!</p>
            <p>Hello, {{ Auth::user()->name }}</p>
            <p>Your order has been confirmed and will be shipped in the next two days!</p>

            <table class="table">
                <tbody>
                    <tr>
                        <td>
                            <div>
                                <span class="font-weight-bold">Order Date:</span>
                                <span>{{ $orders->first()->created_at->format('d M, Y') }}</span>
                            </div>
                        </td>
                        <td>
                            <div>
                                <span class="font-weight-bold">Order No:</span>
                                <span>{{ $orders->first()->id }}</span>
                            </div>
                        </td>
                        <td>
                            <div>
                                <span class="font-weight-bold">Payment:</span>
                                <span><img src="https://img.icons8.com/color/48/000000/mastercard.png" width="20"
                                        alt="Payment Method"></span>
                            </div>
                        </td>
                        <td>
                            <div>
                                <span class="font-weight-bold">Shipping Address:</span>
                                <span>{{ Auth::user()->address }}, {{ Auth::user()->city }}, {{ Auth::user()->state }},
                                    {{ Auth::user()->country }}, {{ Auth::user()->zipcode }}</span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th class="text-right">Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $item)
                        @php
                            $product = $item->product;
                        @endphp
                        <tr>
                            <td>{{ $product->name }} (Quantity: {{ $item->product_qty }})</td>
                            <td class="text-right">&#x20B9;{{ number_format($item->product_price, 2) }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="text-right font-weight-bold">Subtotal:</td>
                        <td class="text-right font-weight-bold">&#x20B9;{{ number_format($subtotal, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="text-right font-weight-bold">Shipping Fee:</td>
                        <td class="text-right font-weight-bold">&#x20B9;{{ number_format($shippingFee, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="text-right font-weight-bold">Tax:</td>
                        <td class="text-right font-weight-bold">&#x20B9;{{ number_format($taxFee, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="text-right font-weight-bold">Discount:</td>
                        <td class="text-right font-weight-bold">&#x20B9;{{ number_format($discount, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="text-right font-weight-bold">Total:</td>
                        <td class="text-right font-weight-bold">&#x20B9;{{ number_format($total, 2) }}</td>
                    </tr>
                </tbody>
            </table>
            <p class="mb-0">We will be sending a shipping confirmation email when the item is shipped successfully!
            </p>
            <p class="font-weight-bold mb-0">Thanks for shopping with us!</p>
            <span>E-commerce Team</span>
        </div>
    </div>
</body>

</html>
