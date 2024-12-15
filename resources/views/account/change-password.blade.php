<!DOCTYPE html>
<html lang="en">

<head>
    <title>Đổi mật khẩu</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- link google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet" />
    <!-- link google material -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,1,0" />
    <!-- link css -->
    <link rel="stylesheet" href="/css/DoiMatKhau.css" />
</head>

<body>
    <div class="container-sm p-0">
        <div class="content p-4 bg-white rounded">
            <div class="title">
                <h2 class="fs-1 fw-bold">Đổi mật khẩu</h2>
                <h5 class="text-secondary">Cập nhật mật khẩu của bạn</h5>

                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <hr />
                <h7 class="text-secondary">
                    Mật khẩu của bạn phải chứa ít nhất 8 ký tự, đồng thời
                    bao gồm cả chữ số, chữ cái và ký tự đặc biệt (!@#$%).
                </h7>
            </div>
            <form action="{{route('account.change-password')}}" method="'POST">
                @csrf
                <div class="form_xemsanpham">
                    <div class="d-flex align-items-center my-3 py-2">
                        <span for="current_password" class="form-label fw-bold text-nowrap me-2">
                            Mật khẩu cũ (*)
                        </span>
                        <input type="password" class="form-control" name="current_password" id="current_password"
                            placeholder="Nhập mật khẩu cũ" required />
                    </div>
                    <div class="d-flex align-items-center mb-3 py-2">
                        <span for="new_password" class="form-label fw-bold text-nowrap me-2">
                            Mật khẩu mới (*)
                        </span>
                        <input type="password" class="form-control" name="new_password" id="new_password"
                            placeholder="Nhập mật khẩu mới" required />
                    </div>
                    <div class="d-flex align-items-center mb-3 py-2">
                        <span for="new_password_confirmation" class="form-label fw-bold text-nowrap me-2">
                            Xác nhận mật khẩu (*)
                        </span>
                        <input type="password" class="form-control" name="new_password_confirmation"
                            id="new_password_confirmation" placeholder="Nhập lại mật khẩu mới" required />
                    </div>
                    <div class="d-flex justify-content-end text-danger">
                        <a href="{{route('account.forgot-password')}}" id="forgot">Bạn quên mật khẩu ư?</a>
                    </div>
                </div>
                <div class="group_btn d-flex justify-content-end mt-4 p-2">
                    <button class="btn btn_cancel me-3" id="btnCancel" type="button">
                        Hủy
                    </button>
                    <button type="submit" class="btn btn_save" id="btnSave">
                        Lưu
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- The Modal -->
    <div class="modal fade" id="modal_ChangePassWord" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Đổi mật khẩu</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    Bạn đã đổi mật khẩu thành công.
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn_close" id="btnClose" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script src="/js/DoiMatKhau.js"></script>
</body>

</html>