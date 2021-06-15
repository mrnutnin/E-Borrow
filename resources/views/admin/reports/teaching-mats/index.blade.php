
@extends('layouts.admin.app')

@section('title', 'Main page')

@section('content')

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="ibox">
                <div class="ibox-title">

                    <h3>รายงานรายการวัสดุคงเหลือ</h3>
                </div>
                <div class="ibox-content">

                    <div class="row">
                        <div class="col-md-4">

                        </div>
                        <div class="col-md-4">
                            <form action=" {{ route('reports.teaching-mats.show2') }}" method="GET" id="matExport2"  form="matExport2">

                                <br>
                                <label for="">ประจำปีงบประมาณ : </label>
                                <input type="number" id="year" name="year" form="matExport2" class="form-control" required>
                                <br>
                                {{-- <label for="">รูปแบบรายการ : </label>
                               <select name="select" id="select" form="matExport2" class="form-control" required>
                                     @foreach ($types as $type)
                                        <option value="{{ $type->id }}"> {{ $type->name }}</option>
                                    @endforeach>
                               </select> --}}
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
                            <button style="background-color: #4CAF50; color: white; margin-right:3px;" name="type" value="excel" form="matExport2" type="submit" class="btn btn">
                            <i class="fa fa-file-excel-o"></i> ShowExcel
                            </button>

                            <button style="background-color: #1c84c6; color: white; margin-right:3px;" name="type" value="pdf" form="matExport2" type="submit" class="btn btn">
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

                    <h3>รายงานตรวจวัสดุคงเหลือ</h3>
                </div>
                <div class="ibox-content">

                    <div class="row">
                        <div class="col-md-4">

                        </div>
                        <div class="col-md-4">
                        <form action=" {{ route('reports.teaching-mats.show') }}" method="GET" id="matExport"  form="matExport">
                            <br>
                            <label for="">ประจำปีงบประมาณ : </label>
                            <input type="number" id="year" name="year" form="matExport" class="form-control" required>
                            <br>

                            {{-- <label for="">รูปแบบรายการ : </label>
                            <select name="select" id="select" form="matExport" class="form-control" required>
                                @foreach ($types as $type)
                                    <option value="{{ $type->id }}"> {{ $type->name }}</option>
                                @endforeach
                            </select> --}}
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
                            <button style="background-color: #4CAF50; color: white; margin-right:3px;" form="matExport" name="type" value="excel" type="submit" class="btn btn">
                            <i class="fa fa-file-excel-o"></i> ShowExcel
                            </button>

                            <button style="background-color: #1c84c6; color: white; margin-right:3px;" form="matExport"  name="type" value="pdf" type="submit" class="btn btn">
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
