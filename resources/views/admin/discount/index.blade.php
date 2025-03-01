@extends('master.admin')

@section('title', 'Quản lý khuyến mãi')

@section('content')
<div class="container_discount container-sm p-0">
    <div class="row">
        <div class="sidebar col-md-3 d-none d-md-block">
            <p class="sidebar_title fs-3 fw-bold">Khuyến mãi</p>

            <!-- Nút Xóa bộ lọc -->
            <div class="filter_reset bg-white p-3 rounded-2 mb-4">
                <form method="GET" action="{{ route('discount.index') }}">
                    <button type="submit" class="btn btn-delete-filter w-100">Xóa bộ lọc</button>
                </form>
            </div>

            <form method="GET" action="{{ route('discount.index') }}" id="filterForm">
                <!-- Thời gian khuyến mãi -->
                <div class="filter_date bg-white p-3 rounded-2 mb-4">
                    <label for="filter_date" class="form-label d-flex justify-content-between fw-bold" id="headingOne">
                        Thời gian
                    </label>
                    <div class="ps-2">
                        <div class="mb-3">
                            <label for="startDate" class="form-label">Từ</label>
                            <input type="date" name="start_date" id="startDate" class="form-control" value="{{ request('start_date') }}" onchange="document.getElementById('filterForm').submit();" />
                        </div>
                        <div class="mb-3">
                            <label for="endDate" class="form-label">đến</label>
                            <input type="date" name="end_date" id="endDate" class="form-control" value="{{ request('end_date') }}" onchange="document.getElementById('filterForm').submit();" />
                        </div>
                    </div>
                </div>
                <!-- Giá trị áp dụng từ -->
                <div class="filter_value bg-white p-3 rounded-2 mb-4">
                    <div class="mb-3">
                        <label for="filter_value" class="form-label d-flex justify-content-between fw-bold">
                            Giá trị áp dụng từ
                        </label>
                        <input class="form-control" id="filter_value" name="filter_value" type="number"
                            placeholder="Nhập giá trị đơn hàng" value="{{ request('filter_value') }}" onchange="document.getElementById('filterForm').submit();" />
                    </div>
                </div>
            </form>
        </div>

        <!-- Mobile -->
        <div class="mobile_togger d-flex align-items-center d-md-none ms-3 my-3 p-0">
            <p class="mobile_title fs-2 fw-bold text-center w-100 m-0">
                KHUYẾN MÃI
            </p>
        </div>

        <!-- Content -->
        <div class="content col-md-9">
            <!-- Tìm kiếm -->
            <div class="group-top row d-flex justify-content-end">
                <div class="search col-md-6 d-flex mb-3">
                    <form method="GET" action="{{ route('discount.index') }}" class="d-flex w-100">
                        <input type="text" name="search" class="form-control me-1" placeholder="Tên khuyến mãi, mã giảm giá..." value="{{ request('search') }}" />
                        <button type="submit" class="btn btn_search text-nowrap">
                            Tìm kiếm
                        </button>
                    </form>
                </div>
                <div class="group_button col-md-6 d-flex mb-3">
                    <!-- Button trigger modal filter mobile -->
                    <button type="button"
                        class="btn_filter d-flex align-items-center justify-content-center p-0 d-md-none"
                        data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                        <span class="material-symbols-outlined d-md-none filter">
                            filter_alt
                        </span>
                    </button>
                    @can('create', App\Models\Discount::class)
                    <!-- Button add/import -->
                    <div class="button d-flex justify-content-end w-100">
                        <a class="btn btn_add me-2 d-flex align-items-center text-nowrap" id="btnAdd"
                            href="{{ route('discount.create') }}">
                            <span class="material-symbols-outlined add"> add </span>
                            Thêm
                        </a>
                    </div>
                    @endcan
                </div>
            </div>

            <!-- Table sản phẩm -->
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="serial" style="min-width: 40px">STT</th>
                            <th scope="promotion_title" style="min-width: 140px">Tên khuyến mãi</th>
                            <th scope="chanel_type" style="min-width: 85px">Kênh bán</th>
                            <th scope="start_date" style="min-width: 65px">Ngày BĐ</th>
                            <th scope="end_date" style="min-width: 65px">Ngày KT</th>
                            <th scope="value" style="min-width: 80px">Giá trị</th>
                            <th scope="order_value" style="min-width: 80px">Đơn từ</th>
                            <th scope="action" style="min-width: 100px">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($discounts as $discount)
                        <tr>
                            <td>{{ $discount->id }}</td>
                            <td>{{ $discount->name }}</td>
                            <td>{{ $discount->type }}</td>
                            <td>{{ \Carbon\Carbon::parse($discount->start_date)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($discount->end_date)->format('d/m/Y') }}</td>
                            <td>{{ number_format($discount->value) }}</td>
                            <td>{{ number_format($discount->starting_price) }}</td>
                            <td>
                                <a type="button" class="btn_preview p-0" id="btnPreview"
                                    href="{{ route('discount.show', $discount->id) }}">
                                    <span class="material-symbols-outlined details">visibility</span>
                                </a>
                                @can('update', $discount)
                                <a type="button" class="btn_edit p-0" id="btnEdit"
                                    href="{{ route('discount.edit', $discount->id) }}">
                                    <span class="material-symbols-outlined edit">border_color</span>
                                </a>
                                @endcan

                                @can('delete', $discount)
                                <form action="{{ route('discount.destroy', $discount->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class=" btn_delete p-0" id="btnDelete"
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
                                        <span class="material-symbols-outlined delete">delete</span>
                                    </button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                        @if($discounts->isEmpty())
                        <tr>
                            <td colspan="8" class="text-center">Không có chương trình khuyến mãi nào.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>

                <!-- Pagination links -->
                <div class="d-flex justify-content-center">
                    {{ $discounts->links('pagination::bootstrap-5') }}
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Modal Filter Mobile -->
<div class="modal modal-filter fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-fullscreen modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-3 fw-bold" id="staticBackdropLabel">
                    Khuyến mãi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Chi nhánh -->
                <div class="filter_branch bg-white p-3 rounded-2 mb-4">
                    <form id="branchForm">
                        <div class="mb-3">
                            <label for="filter_branch" class="form-label d-flex justify-content-between fw-bold">
                                Chi nhánh
                            </label>
                            <input class="form-control" list="branch_name" name="filter_branch" id="filter_branch"
                                placeholder="Chọn chi nhánh" onchange="loadTableData()" />
                            <datalist class="branch_name" id="branch_name">
                                <option value="TP HCM"></option>
                                <option value="Hà Nội"></option>
                            </datalist>
                        </div>
                    </form>
                </div>
                <!-- Thời gian khuyến mãi -->
                <div class="filter_date bg-white p-3 rounded-2 mb-4">
                    <label for="filter_date" class="form-label d-flex justify-content-between fw-bold">
                        Thời gian
                    </label>
                    <form>
                        <div class="mb-3">
                            <label for="startDate" class="form-label">Từ</label>
                            <input type="date" id="startDate" class="form-control" required />
                        </div>
                        <div class="mb-3">
                            <label for="endDate" class="form-label">đến</label>
                            <input type="date" id="endDate" class="form-control" required />
                        </div>
                    </form>
                </div>
                <!-- Giá trị áp dụng từ -->
                <div class="filter_value bg-white p-3 rounded-2 mb-4">
                    <form id="valueForm">
                        <div class="mb-3">
                            <label for="filter_value" class="form-label d-flex justify-content-between fw-bold">
                                Giá trị áp dụng từ
                            </label>
                            <input class="form-control" id="filter_value" type="number"
                                placeholder="Nhập giá trị đơn hàng" onchange="loadTableData()" />
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn_cancel" data-bs-dismiss="modal">
                    Hủy
                </button>
                <button type="button" class="btn btn_complete" data-bs-dismiss="modal">
                    Hoàn tất
                </button>
            </div>
        </div>
    </div>
</div>
<!-- End Mobile Sidebar -->

<!-- Modal Xóa khuyến mãi -->
<div class="modal modal_delete fade" id="modal_Delete">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h5 class="modal-title fs-3 fw-bold" id="staticBackdropLabel">
                    Xóa khuyến mãi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p>Bạn có chắc chắn muốn xóa khuyến mãi này?</p>
                <p class="fst-italic">
                    (Khi xóa, dữ liệu sẽ không được hoàn tác.)
                </p>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn btn_cancel me-4" data-bs-dismiss="modal">
                    Hủy
                </button>
                <button type="button" class="btn btn_agree" data-bs-dismiss="modal">
                    Đồng ý
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="{{ asset('assets/css/admin/discount/index.css') }}" rel="stylesheet">
@endpush

@push('scripts')
<script src="{{ asset('assets/js/admin/discount/index.js') }}"></script>
@endpush