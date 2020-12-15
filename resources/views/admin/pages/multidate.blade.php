<!DOCTYPE html>
<html>
<head>
    <title>Voucher PDF file</title>
    <style>
        article, aside, figcaption, figure, footer, header, hgroup, main, nav, section {
            display: block;
        }
        *, ::after, ::before {
            box-sizing: border-box;
        }

        div {
            display: block;
        }

        .col, .col-1, .col-10, .col-11, .col-12, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-auto, .col-lg, .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-auto, .col-md, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-auto, .col-sm, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-auto, .col-xl, .col-xl-1, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-auto {
            position: relative;
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
        }
        .table-col2{
            position: relative;
            padding-right: 15px;
            padding-left: 15px;
        }
        body {
            background: #e7e9ed;
            color: #535b61;
            font-family: "Poppins", sans-serif;
            font-size: 14px;
            line-height: 22px;
        }
        .align-items-center {
            align-items: center!important;
        }
        .row {
            display: flex;
            margin-right: -15px;
            margin-left: -15px;
        }

        .text-center-logo {
            text-align: left!important;
        }
        .order-sm-1 {
            order: 1;
        }
        address {
            margin-bottom: 1rem;
            font-style: normal;
            line-height: inherit;
        }

        hr {
            margin-top: 1rem;
            margin-bottom: 1rem;
            border: 0;
            border-top: 1px solid rgba(0,0,0,.1);
        }
        img {
            vertical-align: middle;
            border-style: none;
        }

        .invoice-container {
            margin: 15px auto;
            padding: 70px;
            max-width: 850px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        .container-fluid {
            width: 100%;
            padding-right: 65px;
            padding-left: 65px;
            margin-left: auto;
        }

        tbody {
            display: table-row-group;
            vertical-align: middle;
            border-color: inherit;
        }
        thead {
            display: table-header-group;
            vertical-align: middle;
            border-color: inherit;
        }
        .card {
            position: relative;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid rgba(0,0,0,.125);
            border-radius: .25rem;
        }
        body {
            background: #e7e9ed;
            color: #535b61;
            font-family: "Poppins", sans-serif;
            font-size: 14px;
            line-height: 22px;
        }

        .card-header:first-child {
            border-radius: calc(.25rem - 1px) calc(.25rem - 1px) 0 0;
        }
        .card-header {
            padding: .75rem 1.25rem;
            margin-bottom: 0;
            background-color: rgba(0,0,0,.03);
            border-bottom: 1px solid rgba(0,0,0,.125);
        }

        .mb-0, .my-0 {
            margin-bottom: 0!important;
        }
        h1, h2, h3, h4, h5, h6 {
            color: #0c2f54;
            font-family: "Poppins", sans-serif;
        }
        .h4, h4 {
            font-size: 1.5rem;
        }
        .h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {
            margin-bottom: .5rem;
        }
        h1, h2, h3, h4, h5, h6 {
            margin-top: 0;
            margin-bottom: .5rem;
        }

        .bg-light-2 {
            background-color: #f8f8fa !important;
        }

        .border-top-0 {
            border-top: 0!important;
        }
        .text-sm-right {
            text-align: right!important;
        }
        .col-6 {
            -ms-flex: 0 0 50%;
            flex: 0 0 50%;
            max-width: 50%;
        }

        .text-center {
            text-align: center!important;
        }
        .text-end {
            text-align: right!important;
        }
        .text-right {
            text-align: right!important;
        }
        .font-weight-600 {
            font-weight: 600 !important;
        }
        .text-4 {
            font-size: 18px !important
        }
        .card-body {
            flex: 1 1 auto;
            padding: 1.25rem;
        }
        .table-responsive {
            display: block;
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        .table {
            color: #535b61;
        }
        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
        }
        table {
            border-collapse: collapse;
        }

        .table td, .table th {
            padding: .75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }

        @media print{ @page { margin-top: 30px; margin-bottom: 30px;}}

        .btn {
            display: inline-block;
            margin-bottom: 0;
            font-weight: 400;
            text-align: center;
            touch-action: manipulation;
            cursor: pointer;
            border: 1px solid transparent;
            white-space: nowrap;
            padding: 4px 14px;
            font-size: 14px;
            line-height: 1.52857143;
            user-select: none;
        }
        .btn-primary {
            color: #fff;
            background-color: #5d9cec;
        }
        .btn-light {
            color: #363333;
            background-color: #ffffff;
        }
        a{
            text-decoration: none;
        }
        .btn-group{
          text-align: center;
            margin-right: 40px;
        }
        .border{
            margin-left: 10px;
        }
        .padding-bottom{
            margin-bottom: 10px;
            text-align: center;
        }
        .hidden{
            display: none;
        }
    </style>
</head>
<body>
<section class="header-print">
{{--    <span class="font-weight-600 text-4">Booking Summary</span>--}}
    <div class="btn-group">
        <strong>Print - Jojayo e-Commerce office voucher</strong><br/>
        <button onclick="printerDiv('print-content')" class="btn btn-primary border">
            <i class="fa fa-print"></i> Print</button>
        <button onclick="goBack()" class="btn btn-light border">
            <i class="fa fa-download"></i> Done </button>
{{--        <a href="{{ URL::previous() }}" class="hidden" id="laravel-link"></a>--}}
    </div>
</section>

    <div class="container-fluid invoice-container" id="print-content">
        <header>
            <div class="row align-items-center" >
                <div class="col-sm-7 text-center-logo text-sm-left mb-3 mb-sm-0">
                    <img id="logo" src="{{ asset('images/login_logo.png')}}" title="jojayo" alt="jojayologo"/> </div>
                <div class="col-sm-5 text-end text-sm-right">
                    <h4 class="mb-0">Voucher</h4>
                    <p class="mb-0">Generated date - {{ $date = Carbon\Carbon::now()->format('j-F-Y') }}</p>
                </div>
            </div>
            <hr>
        </header>

        <main>
            <div class="row">
                <div class="col-sm-6 text-sm-right order-sm-1"> <strong>Contact info</strong>
                    <address>
                        @if(!empty($sitedata))
                            @foreach($sitedata as $s)
                                {{ $s->landline }}<br/>
                                {{ $s->mobile }}<br/>
                                {{ $s->email }}<br/>
                            @endforeach
                        @endif
                    </address>
                </div>
                <div class="col-sm-6 order-sm-0"> <strong>Company Details</strong>
                    <address>
                        @if(!empty($sitedata))
                            @foreach($sitedata as $s)
                        {{ $s->company }}<br>
                                {{ str_replace(',Nepal','',$s->location) }}<br>
                        P.O. Box: {{ $s->pobox }}<br>
                              Nepal
                            @endforeach
                        @endif
                    </address>
                </div>
            </div>
            <div class="card">
        <div class="card-header"> <span class="font-weight-600 text-4">Voucher Summary</span> </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <td class="table-col2 border-top-0"><strong>Voucher ID</strong></td>
                        <td class="table-col2 text-center border-top-0"><strong>Category</strong></td>
                        <td class="table-col2 text-center border-top-0"><strong>Description</strong></td>
                        <td class="table-col2 text-center border-top-0"><strong>Narrative</strong></td>
                        <td class="table-col2 text-right border-top-0"><strong>Amount</strong></td>
                    </tr>
                    </thead>
                    @php $total =0; @endphp
                    <tbody>
                    @if(!empty($voucher))
                        @foreach($voucher as $v)
                    <tr>
                        <td><span class="text-3">{{ $v->voucherid  }}</span></td>
                        <td class="text-center">{{ \App\Officecategory::find($v->category_id)->name }}</td>
                        <td class="text-center">{{ strip_tags($v->description) }}</td>
                        <td class="text-center">{{ strip_tags($v->narrative)  }}</td>
                        <td class="text-right">Npr. {{ $v->price  }}</td>
                    </tr>
                    <span class="hidden">{!! $total += $v->price !!}</span>
                        @endforeach
                    @endif
                    <tr>
                        <td colspan="4" class="bg-light-2 text-right"><strong>Total( Npr. )</strong></td>
                        <td colspan="2" class="bg-light-2 text-right"> {{ $total }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
        </main>
    </div>
</body>
<script type="text/javascript">
    function printerDiv(divID) {
        var divElements = document.getElementById(divID).innerHTML;
        var oldPage = document.body.innerHTML;
        document.body.innerHTML =
            "<html><head><title></title></head><body>" +
            divElements + "</body>";
        //Print Page
        window.print();
        //Restore orignal HTML
        document.body.innerHTML = oldPage;

    }
    function goBack() {
        //document.getElementById('laravel-link').click();
        window.history.back();
        close();

    }
</script>
</html>
