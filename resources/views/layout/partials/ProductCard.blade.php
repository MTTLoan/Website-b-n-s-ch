@extends('layout.app')
<!-- Giả sử bạn đang sử dụng layout `app` -->

@section('title', 'Product Card')

@section('content')
<div class="col">
    <div class="card custom-card">
        <img src="{{ $product['image'] }}" class="card-img-top" alt="ảnh sản phẩm">
        <div class="card-body">
            <h5 class="card-title">{{ $product['price'] }}</h5>
            <p class="card-text">{{ $product['name'] }}</p>
            <div class="d-flex">
                <p class="card-text sold">Đã bán {{ $product['sold'] }}</p>
                <a href="GioHang.php" class="btn btn-addcart" onclick="addToCart(event, @json($product))">
                    <i class="bi bi-cart-plus"></i>
                </a>
                <a href="GioHang.php" class="btn btn-buynow">
                    Mua ngay
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Product Card CSS */
.product-card {
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 15px;
    text-align: center;
    transition: transform 0.2s ease-in-out;
    background-color: #ffffff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.product-card:hover {
    transform: scale(1.05);
}

.product-image {
    border-radius: 5px;
    margin-bottom: 10px;
}

.product-card h6 {
    color: #C53327;
    font-weight: bold;
}

.card.custom-card {
    border: 1px solid #ddd;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.card.custom-card .card-img-top {
    width: 85%;
    height: auto;
    object-fit: cover;
    margin: 1rem;
    display: block;
    margin-left: auto;
    margin-right: auto;
}

.card.custom-card .card-body {
    padding: 1rem;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

.card.custom-card .card-title {
    font-size: 1.25rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
    text-align: left;
}

.card.custom-card .card-text {
    font-size: 1rem;
    margin-bottom: 1rem;
    text-align: left;
}

.card.custom-card .sold {
    font-size: 0.9rem;
    margin-right: 10px;
    align-items: center;
}

.card.custom-card .card-body .d-flex {
    display: flex;
    align-items: center;
    justify-content: flex-start;
}

.card.custom-card .btn-buynow {
    background-color: #C53327;
    color: white;
    font-size: 15px;
    font-weight: bold;
    text-align: center;
    display: inline-block;
    margin-right: 5px;
    transition: background-color 0.3s ease;
}

.card.custom-card .btn-buynow:hover {
    background-color: #9E291F;
}

.card.custom-card .btn-addcart {
    color: #C53327;
    border-color: #C53327;
    display: inline-block;
    margin-right: 5px;
    transition: background-color 0.3s ease;
}

.card.custom-card .btn-addcart:hover {
    opacity: 50%;
}

.card.custom-card {
    margin-bottom: 1.5rem;
}
</style>
@endpush

@push('scripts')
<script>
// JavaScript to handle Add to Cart button
function addToCart(event, product) {
    event.preventDefault(); // Ngừng hành động mặc định của link
    console.log('Thêm vào giỏ hàng: ', product);

    // Chức năng thêm vào giỏ hàng (có thể lưu vào localStorage hoặc gửi tới server)
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    cart.push(product); // Thêm sản phẩm vào giỏ hàng
    localStorage.setItem('cart', JSON.stringify(cart)); // Lưu giỏ hàng vào localStorage
    alert('Sản phẩm đã được thêm vào giỏ hàng!');
}
</script>
@endpush