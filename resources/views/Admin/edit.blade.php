<!DOCTYPE html>
<html>
<header>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory</title>
    <link href="{{ asset('/css/edit.css') }}" type="text/css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('/logo/R_logo_2.jpg') }}">
    @extends('Admin.layout')
</header>

<body style="background-image:url('/images/bgbgbg.jpg')">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif
    <div class="container ">
        <div class="cont-card">
            <div class="row justify-content-center">
                <div class="col-md-12 d-flex justify-content-center align-items-center" style="width:100%;">
                    <div class="wrap" style="width: 100%;">
                        <form id="edit-product-form" method="POST"
                            action="{{ route('Admin.update', ['product' => $product->id]) }}" style="width: 100%; padding: 30px; border-radius: 10px;">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="product_id" id="edit_product_id" value="{{ $product->id }}">

                            <div class="">
                                <label for="edit_item_name" class="form-label">Item Name</label>
                                <input type="text" class="form-control" id="edit_item_name" name="item_name"
                                    value="{{ $product->item_name }}">
                            </div>

                            <div class="">
                                <label for="edit_price" class="form-label">Price</label>
                                <input type="text" class="form-control" id="edit_price" name="price"
                                    value="{{ $product->price }}">
                            </div>

                            <div class="">
                                <label for="edit_stocks_s" class="form-label">Stocks S</label>
                                <input type="text" class="form-control" id="edit_stocks_s" name="stocks_s"
                                    value="{{ $product->stocks_s }}">
                            </div>
                            <div class="">
                                <label for="edit_stocks_m" class="form-label">Stocks M</label>
                                <input type="text" class="form-control" id="edit_stocks_m" name="stocks_m"
                                    value="{{ $product->stocks_m }}">
                            </div>
                            <div class="">
                                <label for="edit_stocks_l" class="form-label">Stocks L</label>
                                <input type="text" class="form-control" id="edit_stocks_l" name="stocks_l"
                                    value="{{ $product->stocks_l }}">
                            </div>
                            <div class="">
                                <label for="edit_stocks_xl" class="form-label">Stocks XL</label>
                                <input type="text" class="form-control" id="edit_stocks_xl" name="stocks_xl"
                                    value="{{ $product->stocks_xl }}">
                            </div>
                            <div class="">
                                <label for="edit_stocks_2xl" class="form-label">Stocks 2XL</label>
                                <input type="text" class="form-control" id="edit_stocks_2xl" name="stocks_2xl"
                                    value="{{ $product->stocks_2xl }}">
                            </div>
                            <div class="mb-3">
                                <label for="edit_stocks_3xl" class="form-label">Stocks 3XL</label>
                                <input type="text" class="form-control" id="edit_stocks_3xl" name="stocks_3xl"
                                    value="{{ $product->stocks_3xl }}">
                            </div>

                            <div>
                            <a href="/dashboard" class="btn btn-secondary" onclick="return confirmCancel()">Cancel</a>
                            <button type="submit" class="btn btn-primary btn-custom" onclick="return confirmSave()">Save changes</button>
                            
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function confirmCancel() {
            return confirm('Are you sure you want to cancel the action?');
        }
        function confirmSave() {
            return confirm('Are you sure you want to save changes?');
        }
    </script>
</body>

</html>
