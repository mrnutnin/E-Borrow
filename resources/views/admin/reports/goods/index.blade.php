
@extends('layouts.admin.app')

@section('title', 'Main page')

@section('content')

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="ibox">
                <div class="ibox-title">

                    <h3>รายงานรายการครุภัณฑ์</h3>
                </div>
                <div class="ibox-content">

                    <div class="row">
                        <div class="col-md-4">

                        </div>
                        <div class="col-md-4">
                            <form action=" {{ route('reports.goods.show') }}" method="GET" id="goodExport"  form="goodExport">

                                <br>
                                <label for="">ประจำปีงบประมาณ : </label>
                                <input type="number" id="year" name="year" form="goodExport" class="form-control" required>
                                <br>
                                <label for="">รูปแบบรายการ : </label>
                               <select name="select" id="select" form="goodExport" class="form-control" required>
                                   <option value="1">ทั้งหมด</option>
                                   <option value="2">มูลค่าต่ำกว่า 5,000 บาท</option>
                                   <option value="3">มูลค่ามากกว่า 5,000 บาท</option>
                               </select>
                                <br>

                            </form>
                        </div>
                        <div class="col-md-4">

                        </div>
                    </div>
                    <div style="display: flex; justify-content: flex-end">
                        <div class="col-md-4">

                        </div>
                        <div class="col-md-4">
                            <div class="pull-right">
                            <button style="background-color: #4CAF50; color: white; margin-right:3px;" name="type" value="excel" form="goodExport" type="submit" class="btn btn">
                            <i class="fa fa-file-excel-o"></i> ShowExcel
                            </button>

                            <button style="background-color: #1c84c6; color: white; margin-right:3px;" name="type" value="pdf" form="goodExport" type="submit" class="btn btn">
                                <i class="fa fa-file-pdf-o"></i> ShowPDF
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4">

                        </div>

                    </div>

                </div>
            </div>

            <div class="ibox">
                <div class="ibox-title">

                    <h3>รายงานรายการครุภัณฑ์คงเหลือ</h3>
                </div>
                <div class="ibox-content">

                    <div class="row">
                        <div class="col-md-4">

                        </div>
                        <div class="col-md-4">
                        <form action=" {{ route('reports.goods.show2') }}" method="GET" id="goodExport2"  form="goodExport2">
                            <br>
                            <label for="">ประจำปีงบประมาณ : </label>
                            <input type="number" id="year" name="year" form="goodExport2" class="form-control" required>
                            <br>

                            <label for="">รูปแบบรายการ : </label>
                              <select name="select" id="select" form="goodExport2" class="form-control" required>
                                   <option value="1">ทั้งหมด</option>
                                   <option value="2">มูลค่าต่ำกว่า 5,000 บาท</option>
                                   <option value="3">มูลค่ามากกว่า 5,000 บาท</option>
                               </select>
                            <br>
                        </form>
                        </div>
                        <div class="col-md-4">

                        </div>
                        <br>

                    </div>
                    <div style="display: flex; justify-content: flex-end">
                        <div class="col-md-4">

                        </div>
                        <div class="col-md-4">
                            <div class="pull-right">
                            <button style="background-color: #4CAF50; color: white; margin-right:3px;" form="goodExport2" name="type" value="excel" type="submit" class="btn btn">
                            <i class="fa fa-file-excel-o"></i> ShowExcel
                            </button>

                            <button style="background-color: #1c84c6; color: white; margin-right:3px;" form="goodExport2"  name="type" value="pdf" type="submit" class="btn btn">
                                <i class="fa fa-file-pdf-o"></i> ShowPDF
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4">

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>


@endsection

@section('script')
<script>


</script>
@stop
