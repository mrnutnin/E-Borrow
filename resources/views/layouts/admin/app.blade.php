<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INSPINIA - @yield('title') </title>


    <link rel="stylesheet" href="{!! asset('css/vendor.css') !!}" />
    <link rel="stylesheet" href="{!! asset('css/app.css') !!}" />

    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="/css/animate.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <link href="/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">

    {{-- <link href="/css/plugins/dataTables/datatables.min.css" rel="stylesheet"> --}}
    <link href="/css/plugins/dataTables/responsive.dataTables.min.css" rel="stylesheet">

    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.21/r-2.2.5/datatables.min.css"/> --}}
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">

    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.28.0/moment.min.js"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap.min.css" />


    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet"/> --}}



</head>
<body>
    <style>

    </style>
  <!-- Wrapper-->
    <div id="wrapper">

        <!-- Navigation -->
        @include('layouts.admin.nav')

        <!-- Page wraper -->
        <div id="page-wrapper" class="gray-bg">

            <!-- Page wrapper -->
            @include('layouts.admin.topnavbar')

            <!-- Main view  -->
            {{-- @yield('content') --}}
            <div class="wrapper wrapper-content">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
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
                @yield('content')
            </div>

            <!-- Footer -->
            @include('layouts.admin.footer')

        </div>
        <!-- End page wrapper-->

    </div>
    <!-- End wrapper-->

<script src="{!! asset('js/app.js') !!}" type="text/javascript"></script>

<!-- Mainly scripts -->
<script src="/js/jquery-3.1.1.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="/js/plugins/pace/pace.min.js"></script>

<!-- jQuery UI -->
<script src="/js/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="/js/plugins/datapicker/bootstrap-datepicker.js"></script>
<script src="/js/jquery-number-2.1.6/jquery.number.min.js"></script>
<script src="/js/plugins/sweetalert/sweetalert.min.js"></script>

{{-- <script type="text/javascript" src="/js/plugins/dataTables/datatables.min.js"></script>
<script type="text/javascript" src="/js/plugins/dataTables/dataTables.responsive.min.js"></script> --}}
{{--
<script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.21/r-2.2.5/datatables.min.js"></script> --}}
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js" ></script>

<script>
 $( document ).ready(function() {
    countGoodApprove();
    countMatApprove();
    countTeachingMatApprove();
});


function countGoodApprove(){

      $.post("/countGoodApprove", data = {
            _token: '{{ csrf_token() }}',
         },
            function (res) {
                console.log(res);
                $('.numGood').text(res);
            },
        );



}


function countMatApprove(){

      $.post("/countMatApprove", data = {
            _token: '{{ csrf_token() }}',
         },
            function (res) {
                console.log(res);
                $('.numMat').text(res);
            },
        );
}

function countTeachingMatApprove(){

      $.post("/countTeachingMatApprove", data = {
            _token: '{{ csrf_token() }}',
         },
            function (res) {
                console.log(res);
                $('.numTMat').text(res);
            },
        );
}

</script>

@section('script')




@show

</body>
</html>
