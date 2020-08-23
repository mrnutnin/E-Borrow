
@extends('layouts.home.app')

@section('title', 'Main page')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="ibox">
                <div class="ibox-title">
                    <div class="pull-right">
                        <button type="button" id="addItemModalBtn" class="btn btn-primary">
                            <i class="fa fa-plus"></i> เพิ่มครุภัณฑ์
                        </button>
                    </div>
                    <h3>รายการครุภัณฑ์</h3>
                </div>
                <div class="ibox-content">
                    <table class="table table-bordered" id="item_list_table" style="width:100%">
                        <thead>
                            <tr>
                                <th>column1</th>
                                <th>column2</th>
                                <th>column3</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">เพิ่มครุภัณฑ์</h4>
                </div>

                <div class="modal-body">

                    <label><span style="color:red">*</span>รหัสครุภัณฑ์</label>
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" class="form-control" id="" name=""
                                placeholder="Ex 1235" required>
                            <div class="btn-info input-group-addon" style="cursor:pointer" id="randomCode"> สุ่ม </div>
                        </div>
                    </div>

                    <label>ประเภทครุภัณฑ์</label>
                    <div class="form-group">
                        <select id="" name="" class="form-control">

                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
                    <button type="button" id="addItem" class="btn btn-primary">บันทึก</button>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('script')
<script>

$("#addItemModalBtn").click(function () {
    $('#addItemModal').modal("show");
});


// $("#item_list_table").DataTable( {
//     "responsive": true,
//     "pageLength": 25,
//     "order": [[ 0, "desc" ]],
// } );

$(document).ready( function () {
    $('#item_list_table').DataTable();
} );
</script>
@stop
