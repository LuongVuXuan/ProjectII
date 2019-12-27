@extends('layouts.app')

@section('content')
<h1>Students</h1>
{{-- <form> --}}
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">
                <label>Khóa</label>
                <select name="khoa" class="form-control">
                    <option selected value="">- Chọn Khóa -</option>
                    @foreach ($ddkhoa as $khoa)
                    <option>{{ $khoa }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label>Khoa/Viện</label>
                <select name="vien" class="form-control">
                    <option selected value="">- Chọn Khoa/Viện -</option>
                    @foreach ($ddvien as $vien)
                    <option>{{ $vien }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label>Lớp sinh viên</label>
                <select name="lop" class="form-control">
                    <option selected value="">- Chọn Lớp -</option>
                    @foreach ($ddlop as $lop)
                    <option>{{ $lop }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <label>Mã sinh viên</label>
                <input type="text" name="mssv" class="form-control">
            </div>
            <div class="col-md-6">
                <label>Tên sinh viên</label>
                <input type="text" name="hoten" class="form-control">
            </div>
            <div class="col-md-2 d-flex align-items-end justify-content-end">
                <button id="search" class="btn btn-primary">Search</button>
            </div>
        </div>
{{-- </form> --}}
</div>

<table class="table">
    <thead class="thead-dark">
        <tr>
            <th scope="col">Viện</th>
            <th scope="col">Khóa</th>
            <th scope="col">Lớp</th>
            <th scope="col">MSSV</th>
            <th scope="col">Họ</th>
            <th scope="col">Đệm</th>
            <th scope="col">Tên</th>
            <th scope="col">Ngày sinh</th>
            <th scope="col">Trạng thái</th>
        </tr>
    </thead>

    <tbody>
    </tbody>
</table>

<script>
$(document).ready(function(){
    var searchApp = new SeacrhApp();
});

class SeacrhApp{
    constructor(){
        this.loadData();
        this.initEvents();
    }

    // Hàm gán sự kiện cho các elements
    initEvents(){
        $('#search').on('click', this.loadData);
    }

    // Hàm load dữ liệu
    loadData(){
        
        var obj = {};
        obj.vien = $("select[name='vien']").val();
        obj.khoa = $("select[name='khoa']").val();
        obj.lop = $("select[name='lop']").val();
        obj.mssv = $("input[name='mssv']").val();
        obj.hoten = $("input[name='hoten']").val();
        
        $('table tbody').empty();
        $.ajax({
            url: '/students/search',
            method: 'POST',
            dataType: 'json',
            data: obj,
            success: function(res){
                if (res == ''){
                    var rowHTML = '<tr><td align="center" colspan="9">No Data Found</td></tr>';
                    $('tbody').append(rowHTML);
                }
                else{
                    debugger
                    $.each(res, function(index, item){
                    
                        var rowHTML = $('<tr></tr>');
                        
                        rowHTML.append('<td>'+item.vien+'</td>');
                        rowHTML.append('<td>'+item.khoa+'</td>');
                        rowHTML.append('<td>'+item.lop+'</td>');
                        rowHTML.append('<td>'+item.mssv+'</td>');
                        rowHTML.append('<td>'+item.ho+'</td>');
                        rowHTML.append('<td>'+item.dem+'</td>');
                        rowHTML.append('<td>'+item.ten+'</td>');
                        rowHTML.append('<td>'+item.ngaysinh+'</td>');
                        rowHTML.append('<td>'+item.trangthai+'</td>');
                        
                        
                        $('table tbody').append(rowHTML);
                    });
                }
            }
        })
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
    }
}
    
</script>

@endsection