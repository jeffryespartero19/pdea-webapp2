@extends('layouts.template')

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<meta http-equiv="Refresh" content="300">
<script>
    $(document).ready(function(){
        $('.opsTable').hide();
    });
</script>
<!-- Content Header (Page header) -->
@if(Session::has('warning'))
    <div class="alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{ Session::get('warning') }}
    </div>
@endif
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Geo Mapping</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" onclick="removeCokie();">Home</a></li>
                    <li class="breadcrumb-item active">Geo Mapping</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <form id="getAreaX" method="GET" action="{{ route('ops_details') }}" autocomplete="off" enctype="multipart/form-data">@csrf
        <input id="area_ID" name="area_ID" value="" hidden>
    </form>
    <!-- Default box -->
    <div class="card card-info full_vh">
        <div class="card-body">
            <div class="card">
                <div class="card-body full_vh2">
                    <!--The div element for the map -->
                    <div id="container"></div>

                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
    <!-- /.card -->

</section>
<!-- /.content -->

<!-- Set menu to collapse and active -->
@endsection

@section('scripts')
<script src="https://code.highcharts.com/maps/highmaps.js"></script>
<script src="https://code.highcharts.com/maps/modules/exporting.js"></script>
<script src="https://code.highcharts.com/mapdata/countries/ph/ph-all.js"></script>

<script>
    // Prepare demo data
    // Data is joined to map using value of 'hc-key' property by default.
    // See API docs for 'joinBy' for more info on linking data and map.
    var data = [
        ['ph-mn', {{$Misamis_Oriental}}], //Misamis_Oriental
        ['ph-4218',0],//some random island
        ['ph-tt', {{$Tawi_Tawi}}], //Tawi-Tawi
        ['ph-bo', {{$Bohol}}], //Bohol
        ['ph-cb', {{$Cebu}}], //Cebu
        ['ph-bs', {{$Basilan}}], //Basilan
        ['ph-2603', {{$Zamboanga_Sibugay}}],//Zamboanga Sibugay
        ['ph-su', {{$Sulu}}],//Sulu
        ['ph-aq', {{$Antique}}],//Antique
        ['ph-pl', {{$Palawan}}],//Palawan
        ['ph-ro', {{$Romblon}}],//Romblon
        ['ph-al', {{$Albay}}],//Albay
        ['ph-cs', {{$Camarines_Sur}}],//Camarines Sur
        ['ph-6999',0],//Naga
        ['ph-bn',{{$Batanes}}], //Batanes
        ['ph-cg',{{$Cagayan}}], //Cagayan
        ['ph-pn',{{$Pangasinan}}],//Pangasinan
        ['ph-bt',{{$Batangas}}],//Batangas
        ['ph-mc',{{$Occidental_Mindoro}}],//Mindoro Occidental
        ['ph-qz',{{$Quezon}}], //Quezon Province
        ['ph-es',{{$Eastern_Samar}}],//Eastern Samar
        ['ph-le',{{$Leyte}}],//Leyte
        ['ph-sm',{{$Samar}}],//Samar
        ['ph-ns',{{$Northern_Samar}}],//Northern Samar
        ['ph-cm',{{$Camiguin}}],//Camiguin
        ['ph-di',{{$Surigao_del_Norte}}],//Surigao Del Norte
        ['ph-ds',{{$Davao_del_Sur}}],//Davao Del Sur
        ['ph-6457', 0],//Isabela CIty
        ['ph-6985', 0],//Lapu Lapu
        ['ph-ii', 0],//Iloilo
        ['ph-7017', 0],//Angeles
        ['ph-7021', 0],//Bagiuo City
        ['ph-lg', {{$Laguna}}],//Laguna
        ['ph-ri', {{$Rizal}}], //Rizal
        ['ph-ln', {{$Lanao_del_Norte}}],//Lanao Del Norte
        ['ph-6991',0],//Illigan
        ['ph-ls',{{$Lanao_del_Sur}}],//Lanao Del Sur
        ['ph-nc',{{$North_Cotabato}}],//Cotabato
        ['ph-mg',{{$Maguindanao}}],//Maguindanao
        ['ph-sk',{{$Sultan_Kudarat}}],//Sultan Kudarat
        ['ph-sc',{{$South_Cotabato}}],//South Cotabato
        ['ph-sg',{{$Sarangani}}],//Sarangani
        ['ph-an',{{$Agusan_del_Norte}}],//Agusan Del Norte
        ['ph-ss',{{$Surigao_del_Sur}}],//Surigao Del Sur
        ['ph-as',{{$Agusan_del_Sur}}],//Agusan Del Sur
        ['ph-do',{{$Davao_Oriental}}],//Davao Oriental
        ['ph-dv',{{$Davao_del_Norte}}],//Davao Del Norte
        ['ph-bk',{{$Bukidnon}}],//Bukidnon
        ['ph-cl',{{$Compostela_Valley}}],//Compostela Valley
        ['ph-6983',0],//Cebu City
        ['ph-6984',0],//Mandaue
        ['ph-6987',0],//Bacolod
        ['ph-6986',0],//Iloilo City
        ['ph-6988',0],//Cotabato City
        ['ph-6989',{{$Davao_Occidental}}],//Davao
        ['ph-6990',0],//General Santos City
        ['ph-6992',0],//Cagayan de Oro
        ['ph-6995',0],//Butuan
        ['ph-6996',0],//Puerto Princessa
        ['ph-6997',0],//Ormoc
        ['ph-6998',0],//Tacloban
        ['ph-nv', {{$Nueva_Vizcaya}}], //Nueva Vizcaya
        ['ph-7020',0],//Santiago City
        ['ph-7018',0], //Olongapo
        ['ph-7022',0],//Dagupan
        ['ph-1852',{{$Mandaluyong}}],//Mandaluyong City
        ['ph-7000',{{$Manila}}],//Manila City
        ['ph-7001',{{$Navotas}}],//Navotas City
        ['ph-7002',{{$Caloocan}}],//Caloocan City
        ['ph-7003',{{$Malabon}}],//Malabon City
        ['ph-7004',{{$Valenzuela}}],//Valenzuela City
        ['ph-7006',{{$Quezon_City}}],//Quezon City
        ['ph-7007',{{$Marikina}}],//Marikina City
        ['ph-7008',{{$San_Juan}}],//San Juan City
        ['ph-7009',{{$Pasig}}],//Pasig City
        ['ph-7010',{{$Makati}}],//Makati City
        ['ph-7011',{{$Pasay}}],//Pasay City
        ['ph-7012',{{$Paranaque}}],//Paranaque City
        ['ph-7013',{{$Las_Pinas}}],//Las Pinas City
        ['ph-7014',{{$Muntinlupa}}],//Muntinlupa City
        ['ph-7015',{{$Taguig}}], //Taguig City
        ['ph-7016',{{$Pateros}}], //Pateros City
        ['ph-7019',0],//Lucena
        ['ph-6456',{{$Zamboanga_del_Sur}}],//Zamboanga
        ['ph-zs', {{$Zamboanga_del_Sur}}],//Zamboanga Del Sur
        ['ph-nd', {{$Negros_Occidental}}],//Negros Occidental
        ['ph-zn', {{$Zamboanga_del_Norte}}],//Zamboanga Del Norte
        ['ph-md', {{$Misamis_Occidental}}],//Misamis Occidental
        ['ph-ab', {{$Abra}}], //Abra
        ['ph-2658', {{$Apayao }}], //Apayao
        ['ph-ap', {{$Kalinga}}], //Kalinga
        ['ph-au', {{$Aurora}}], //Aurora
        ['ph-ib', {{$Isabela}}], //Isabela
        ['ph-if', {{$Ifugao}}], //Ifugao
        ['ph-mt', {{$Mountain_Province}}], //Mountain Province
        ['ph-qr', {{$Quirino}}], //Quirino
        ['ph-ne', {{$Nueva_Ecija}}], //Nueva Ecija
        ['ph-pm', {{$Pampanga}}],//Pampanga
        ['ph-ba', {{$Bataan}}],//Bataan
        ['ph-bg', {{$Benguet}}],//Benguet
        ['ph-zm', {{$Zambales}}],//Zambales
        ['ph-cv', {{$Cavite}}],//Cavite
        ['ph-bu', {{$Bulacan}}],//Bulacan
        ['ph-mr', {{$Oriental_Mindoro}}],//Mindoro Oriental
        ['ph-sq', {{$Siquijor}}],//Siquijor
        ['ph-gu', {{$Guimaras}}],//Guimaras
        ['ph-ct', {{$Catanduanes}}],//Catanduanes
        ['ph-mb', {{$Masbate}}],//Masbate
        ['ph-mq', {{$Marinduque}}],//Marinduque
        ['ph-bi', {{$Biliran}}],//Biliran
        ['ph-sl', {{$Southern_Leyte}}],//Southern Leyte
        ['ph-nr', {{$Negros_Oriental}}],//Negros Oriental
        ['ph-ak', {{$Aklan}}],//Aklan
        ['ph-cp', {{$Capiz}}],//Capiz
        ['ph-cn', {{$Camarines_Norte}}],//Camarines Norte
        ['ph-sr', {{$Sorsogon}}],//Sorsogon
        ['ph-in', {{$Ilocos_Norte}} ], //Ilocos Norte
        ['ph-is', {{$Ilocos_Sur}} ], //Ilocos Sur
        ['ph-tr', {{$Tarlac}}],//Tarlac
        ['ph-lu', {{$La_Union}}], //La Union
        
    ];

    // Create the chart
    Highcharts.mapChart('container', {
        chart: {
            height: 800,
            map: 'countries/ph/ph-all',
            plotBackgroundColor:'#808080',
            
        },
        title: {
            text: 'Philippines'
        },

        // subtitle: {
        //     text: 'Source map: <a href="http://code.highcharts.com/mapdata/countries/ph/ph-all.js">Philippines</a>'
        // },

        mapNavigation: {
            enabled: true,
            buttonOptions: {
                verticalAlign: 'bottom'
            }
        },

        colorAxis: {
            min: 0,
            max: 3
        },

        series: [{
            data: data,
            name: 'Ongoing-Ops',
        
            states: {
                hover: {
                    color: '#FA8072'
                },
                
            },
            dataLabels: {
                enabled: true,
                format: '{point.name}',
                
            },
            
        }]
    });
</script>
<script>
    //Provinces
    $(document).on('click',('.highcharts-name-ilocos-norte'),function(e) {
        $('#area_ID').val('0000000036');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-ilocos-sur'),function(e) {
        $('#area_ID').val('0000000037');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-la-union'),function(e) {
        $('#area_ID').val('0000000041');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-pangasinan'),function(e) {
        $('#area_ID').val('0000000065');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-batanes'),function(e) {
        $('#area_ID').val('0000000011');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-cagayan'),function(e) {
        $('#area_ID').val('0000000018');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-isabela'),function(e) {
        $('#area_ID').val('0000000039');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-nueva-vizcaya'),function(e) {
        $('#area_ID').val('0000000060');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-quirino'),function(e) {
        $('#area_ID').val('0000000067');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-bataan'),function(e) {
        $('#area_ID').val('0000000010');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-bulacan'),function(e) {
        $('#area_ID').val('0000000017');
        $('#getAreaX').submit(); 
        
    });

    $(document).on('click',('.highcharts-name-nueva-ecija'),function(e) {
        $('#area_ID').val('0000000059');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-pampanga'),function(e) {
        $('#area_ID').val('0000000064');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-tarlac'),function(e) {
        $('#area_ID').val('0000000080');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-zambales'),function(e) {
        $('#area_ID').val('0000000082');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-aurora'),function(e) {
        $('#area_ID').val('0000000008');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-batangas'),function(e) {
        $('#area_ID').val('0000000012');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-cavite'),function(e) {
        $('#area_ID').val('0000000024');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-laguna'),function(e) {
        $('#area_ID').val('0000000042');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-quezon'),function(e) {
        $('#area_ID').val('0000000066');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-rizal'),function(e) {
        $('#area_ID').val('0000000068');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-albay'),function(e) {
        $('#area_ID').val('0000000005');
        $('#getAreaX').submit(); 
        
    });

    $(document).on('click',('.highcharts-name-camarines-norte'),function(e) {
        $('#area_ID').val('0000000019');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-camarines-sur'),function(e) {
        $('#area_ID').val('0000000020');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-catanduanes'),function(e) {
        $('#area_ID').val('0000000023');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-masbate'),function(e) {
        $('#area_ID').val('0000000048');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-sorsogon'),function(e) {
        $('#area_ID').val('0000000073');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-aklan'),function(e) {
        $('#area_ID').val('0000000004');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-antique'),function(e) {
        $('#area_ID').val('0000000006');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-capiz'),function(e) {
        $('#area_ID').val('0000000022');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-iloilo'),function(e) {
        $('#area_ID').val('0000000038');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-negros-occidental'),function(e) {
        $('#area_ID').val('NP00000001');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-guimaras'),function(e) {
        $('#area_ID').val('0000000034');
        $('#getAreaX').submit(); 
        
    });

    $(document).on('click',('.highcharts-name-bohol'),function(e) {
        $('#area_ID').val('0000000015');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-cebu'),function(e) {
        $('#area_ID').val('0000000025');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-negros-oriental'),function(e) {
        $('#area_ID').val('NP00000002');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-siquijor'),function(e) {
        $('#area_ID').val('0000000072');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-eastern-samar'),function(e) {
        $('#area_ID').val('0000000033');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-leyte'),function(e) {
        $('#area_ID').val('0000000045');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-northern-samar'),function(e) {
        $('#area_ID').val('0000000058');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-samar'),function(e) {
        $('#area_ID').val('0000000070');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-southern-leyte'),function(e) {
        $('#area_ID').val('0000000075');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-biliran'),function(e) {
        $('#area_ID').val('0000000014');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-zamboanga-del-norte'),function(e) {
        $('#area_ID').val('0000000083');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-zamboanga-del-sur'),function(e) {
        $('#area_ID').val('0000000084');
        $('#getAreaX').submit(); 
        
    });

    $(document).on('click',('.highcharts-name-zamboanga-sibugay'),function(e) {
        $('#area_ID').val('0000000085');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-bukidon'),function(e) {
        $('#area_ID').val('0000000016');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-camiguin'),function(e) {
        $('#area_ID').val('0000000021');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-lanao-del-norte'),function(e) {
        $('#area_ID').val('0000000043');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-misamis-occidental'),function(e) {
        $('#area_ID').val('0000000049');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-misamis-oriental'),function(e) {
        $('#area_ID').val('0000000050');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-davao-del-norte'),function(e) {
        $('#area_ID').val('0000000029');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-davao-del-sur'),function(e) { //davao occidental
        $('#area_ID').val('0000000030');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-davao-oriental'),function(e) {
        $('#area_ID').val('0000000031');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-compostela-valley'),function(e) {
        $('#area_ID').val('0000000027');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-davao'),function(e) { //davao del sur
        $('#area_ID').val('1124');
        $('#getAreaX').submit(); 
        
    });

    $(document).on('click',('.highcharts-name-cotabato'),function(e) { //north cotabato
        $('#area_ID').val('COTABATO');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-south-cotabato'),function(e) {
        $('#area_ID').val('0000000074');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-sultan-kudarat'),function(e) {
        $('#area_ID').val('0000000076');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-sarangani'),function(e) {
        $('#area_ID').val('0000000071');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-abra'),function(e) {
        $('#area_ID').val('0000000001');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-benguet'),function(e) {
        $('#area_ID').val('0000000013');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-ifugao'),function(e) {
        $('#area_ID').val('0000000035');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-kalinga'),function(e) {
        $('#area_ID').val('0000000040');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-mountain-province'),function(e) {
        $('#area_ID').val('0000000051');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-apayao'),function(e) {
        $('#area_ID').val('0000000007');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-basilan'),function(e) {
        $('#area_ID').val('0000000009');
        $('#getAreaX').submit(); 
        
    });

    $(document).on('click',('.highcharts-name-lanao-del-sur'),function(e) {
        $('#area_ID').val('0000000044');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-maguindanao'),function(e) {
        $('#area_ID').val('0000000046');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-sulu'),function(e) {
        $('#area_ID').val('0000000077');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-tawi-tawi'),function(e) {
        $('#area_ID').val('0000000081');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-agusan-del-norte'),function(e) {
        $('#area_ID').val('0000000002');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-agusan-del-sur'),function(e) {
        $('#area_ID').val('0000000003');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-surigao-del-norte'),function(e) {
        $('#area_ID').val('0000000078');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-surigao-del-sur'),function(e) {
        $('#area_ID').val('0000000079');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-marinduque'),function(e) {
        $('#area_ID').val('0000000047');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-mindoro-occidental'),function(e) {
        $('#area_ID').val('0000000061');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-mindoro-oriental'),function(e) {
        $('#area_ID').val('0000000062');
        $('#getAreaX').submit(); 
        
    });

    $(document).on('click',('.highcharts-name-palawan'),function(e) {
        $('#area_ID').val('0000000063');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-romblon'),function(e) {
        $('#area_ID').val('0000000069');
        $('#getAreaX').submit(); 
        
    });

   //NCR
    $(document).on('click',('.highcharts-name-navotas'),function(e) {
        $('#area_ID').val('0000000009c');
        $('#getAreaX').submit(); 
    });
    $(document).on('click',('.highcharts-name-malabon'),function(e) {
        $('#area_ID').val('0000000008c');
        $('#getAreaX').submit();
    });
    $(document).on('click',('.highcharts-name-valenzuela'),function(e) {
        $('#area_ID').val('0000000010c');
        $('#getAreaX').submit();
    });
    $(document).on('click',('.highcharts-name-caloocan'),function(e) {
        $('#area_ID').val('0000000007c');
        $('#getAreaX').submit();
    });
    $(document).on('click',('.highcharts-name-manila'),function(e) {
        $('#area_ID').val('1');
        $('#getAreaX').submit();//133901-133914
    });
    $(document).on('click',('.highcharts-name-san-juan'),function(e) {
        $('#area_ID').val('0000000006c');
        $('#getAreaX').submit();
    });
    $(document).on('click',('.highcharts-name-quezon-city'),function(e) {
        $('#area_ID').val('0000000005c');
        $('#getAreaX').submit();
    });
    $(document).on('click',('.highcharts-name-marikina'),function(e) {
        $('#area_ID').val('0000000003c');
        $('#getAreaX').submit();
    });
    $(document).on('click',('.highcharts-name-pasay'),function(e) {
        $('#area_ID').val('0000000015c');
        $('#getAreaX').submit();
    });
    $(document).on('click',('.highcharts-name-makati'),function(e) {
        $('#area_ID').val('0000000012c');
        $('#getAreaX').submit();
    });
    $(document).on('click',('.highcharts-name-mandaluyong-city'),function(e) {
        $('#area_ID').val('0000000002c');
        $('#getAreaX').submit();
    });
    $(document).on('click',('.highcharts-name-pasig'),function(e) {
        $('#area_ID').val('0000000004c');
        $('#getAreaX').submit();
    });
    $(document).on('click',('.highcharts-name-paranaque'),function(e) {
        $('#area_ID').val('0000000014c');
        $('#getAreaX').submit();
    });
    $(document).on('click',('.highcharts-name-taguig'),function(e) {
        $('#area_ID').val('0000000017c');
        $('#getAreaX').submit();
    });
    $(document).on('click',('.highcharts-name-pateros'),function(e) {
        $('#area_ID').val('0000000016c');
        $('#getAreaX').submit();
    });
    $(document).on('click',('.highcharts-name-las-pinas'),function(e) {
        $('#area_ID').val('0000000011c');
        $('#getAreaX').submit();
    });
    $(document).on('click',('.highcharts-name-muntinlupa'),function(e) {
        $('#area_ID').val('0000000013c');
        $('#getAreaX').submit();
    });
</script>
<style>
    #container {
        height: 100%;
        width: 100%;
        margin: 0 auto;
    }

    .loading {
        margin-top: 10em;
        text-align: center;
        color: gray;
    }
</style>

<script>
    $(function() {
        $('#geo_link').addClass('active');
    });
</script>


@endsection