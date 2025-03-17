@extends('backend.layouts.master')

@section('content')
    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Import
    </button>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('admin.import-data') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Import sản phẩm</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="file" name="file" id="file" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary btn-sm">Lưu thay đổi</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
