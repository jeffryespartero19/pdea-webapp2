@extends('layouts.template')

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
            min: 1
        },

        series: [{
            data: data,
            name: 'Ops',
        
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
        $('#area_ID').val('0128');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-ilocos-sur'),function(e) {
        $('#area_ID').val('0129');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-la-union'),function(e) {
        $('#area_ID').val('0133');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-pangasinan'),function(e) {
        $('#area_ID').val('0155');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-batanes'),function(e) {
        $('#area_ID').val('0209');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-cagayan'),function(e) {
        $('#area_ID').val('0215');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-isabela'),function(e) {
        $('#area_ID').val('0231');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-nueva-vizcaya'),function(e) {
        $('#area_ID').val('0250');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-quirino'),function(e) {
        $('#area_ID').val('0257');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-bataan'),function(e) {
        $('#area_ID').val('0308');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-bulacan'),function(e) {
        $('#area_ID').val('0314');
        $('#getAreaX').submit(); 
        
    });

    $(document).on('click',('.highcharts-name-nueva-ecija'),function(e) {
        $('#area_ID').val('0349');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-pampanga'),function(e) {
        $('#area_ID').val('0354');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-tarlac'),function(e) {
        $('#area_ID').val('0369');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-zambales'),function(e) {
        $('#area_ID').val('0371');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-aurora'),function(e) {
        $('#area_ID').val('0377');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-batangas'),function(e) {
        $('#area_ID').val('0410');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-cavite'),function(e) {
        $('#area_ID').val('0421');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-laguna'),function(e) {
        $('#area_ID').val('0434');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-quezon'),function(e) {
        $('#area_ID').val('0456');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-rizal'),function(e) {
        $('#area_ID').val('0458');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-albay'),function(e) {
        $('#area_ID').val('0505');
        $('#getAreaX').submit(); 
        
    });

    $(document).on('click',('.highcharts-name-camarines-norte'),function(e) {
        $('#area_ID').val('0516');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-camarines-sur'),function(e) {
        $('#area_ID').val('0517');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-catanduanes'),function(e) {
        $('#area_ID').val('0520');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-masbate'),function(e) {
        $('#area_ID').val('0541');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-sorsogon'),function(e) {
        $('#area_ID').val('0562');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-aklan'),function(e) {
        $('#area_ID').val('0604');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-antique'),function(e) {
        $('#area_ID').val('0606');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-capiz'),function(e) {
        $('#area_ID').val('0619');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-iloilo'),function(e) {
        $('#area_ID').val('0630');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-negros-occidental'),function(e) {
        $('#area_ID').val('0645');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-guimaras'),function(e) {
        $('#area_ID').val('0679');
        $('#getAreaX').submit(); 
        
    });

    $(document).on('click',('.highcharts-name-bohol'),function(e) {
        $('#area_ID').val('0712');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-cebu'),function(e) {
        $('#area_ID').val('0722');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-negros-oriental'),function(e) {
        $('#area_ID').val('0746');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-siquijor'),function(e) {
        $('#area_ID').val('0761');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-eastern-samar'),function(e) {
        $('#area_ID').val('0826');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-leyte'),function(e) {
        $('#area_ID').val('0837');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-northern-samar'),function(e) {
        $('#area_ID').val('0848');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-samar'),function(e) {
        $('#area_ID').val('0860');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-southern-leyte'),function(e) {
        $('#area_ID').val('0864');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-biliran'),function(e) {
        $('#area_ID').val('0878');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-zamboanga-del-norte'),function(e) {
        $('#area_ID').val('0972');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-zamboanga-del-sur'),function(e) {
        $('#area_ID').val('0973');
        $('#getAreaX').submit(); 
        
    });

    $(document).on('click',('.highcharts-name-zamboanga-sibugay'),function(e) {
        $('#area_ID').val('0983');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-bukidon'),function(e) {
        $('#area_ID').val('1013');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-camiguin'),function(e) {
        $('#area_ID').val('1018');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-lanao-del-norte'),function(e) {
        $('#area_ID').val('1035');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-misamis-occidental'),function(e) {
        $('#area_ID').val('1042');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-misamis-oriental'),function(e) {
        $('#area_ID').val('1043');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-davao-del-norte'),function(e) {
        $('#area_ID').val('137503');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-davao-del-sur'),function(e) { //davao occidental
        $('#area_ID').val('1186');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-davao-oriental'),function(e) {
        $('#area_ID').val('1125');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-compostela-valley'),function(e) {
        $('#area_ID').val('1182');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-davao'),function(e) { //davao del sur
        $('#area_ID').val('1124');
        $('#getAreaX').submit(); 
        
    });

    $(document).on('click',('.highcharts-name-cotabato'),function(e) { //north cotabato
        $('#area_ID').val('1247');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-south-cotabato'),function(e) {
        $('#area_ID').val('1263');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-sultan-kudarat'),function(e) {
        $('#area_ID').val('1265');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-sarangani'),function(e) {
        $('#area_ID').val('1280');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-abra'),function(e) {
        $('#area_ID').val('1401');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-benguet'),function(e) {
        $('#area_ID').val('1411');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-ifugao'),function(e) {
        $('#area_ID').val('1427');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-kalinga'),function(e) {
        $('#area_ID').val('1432');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-mountain-province'),function(e) {
        $('#area_ID').val('1444');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-apayao'),function(e) {
        $('#area_ID').val('1481');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-basilan'),function(e) {
        $('#area_ID').val('1507');
        $('#getAreaX').submit(); 
        
    });

    $(document).on('click',('.highcharts-name-lanao-del-sur'),function(e) {
        $('#area_ID').val('1536');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-maguindanao'),function(e) {
        $('#area_ID').val('1538');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-sulu'),function(e) {
        $('#area_ID').val('1566');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-tawi-tawi'),function(e) {
        $('#area_ID').val('1570');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-agusan-del-norte'),function(e) {
        $('#area_ID').val('1602');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-agusan-del-sur'),function(e) {
        $('#area_ID').val('1603');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-surigao-del-norte'),function(e) {
        $('#area_ID').val('1667');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-surigao-del-sur'),function(e) {
        $('#area_ID').val('1668');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-marinduque'),function(e) {
        $('#area_ID').val('1740');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-mindoro-occidental'),function(e) {
        $('#area_ID').val('1751');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-mindoro-oriental'),function(e) {
        $('#area_ID').val('1752');
        $('#getAreaX').submit(); 
        
    });

    $(document).on('click',('.highcharts-name-palawan'),function(e) {
        $('#area_ID').val('1753');
        $('#getAreaX').submit(); 
        
    });
    $(document).on('click',('.highcharts-name-romblon'),function(e) {
        $('#area_ID').val('1759');
        $('#getAreaX').submit(); 
        
    });

   //NCR
    $(document).on('click',('.highcharts-name-navotas'),function(e) {
        $('#area_ID').val('137503');
        $('#getAreaX').submit(); 
    });
    $(document).on('click',('.highcharts-name-malabon'),function(e) {
        $('#area_ID').val('137502');
        $('#getAreaX').submit();
    });
    $(document).on('click',('.highcharts-name-valenzuela'),function(e) {
        $('#area_ID').val('137504');
        $('#getAreaX').submit();
    });
    $(document).on('click',('.highcharts-name-caloocan'),function(e) {
        $('#area_ID').val('137501');
        $('#getAreaX').submit();
    });
    $(document).on('click',('.highcharts-name-manila'),function(e) {
        $('#area_ID').val('1');
        $('#getAreaX').submit();//133901-133914
    });
    $(document).on('click',('.highcharts-name-san-juan'),function(e) {
        $('#area_ID').val('137405');
        $('#getAreaX').submit();
    });
    $(document).on('click',('.highcharts-name-quezon-city'),function(e) {
        $('#area_ID').val('137404');
        $('#getAreaX').submit();
    });
    $(document).on('click',('.highcharts-name-marikina'),function(e) {
        $('#area_ID').val('137402');
        $('#getAreaX').submit();
    });
    $(document).on('click',('.highcharts-name-pasay'),function(e) {
        $('#area_ID').val('137605');
        $('#getAreaX').submit();
    });
    $(document).on('click',('.highcharts-name-makati'),function(e) {
        $('#area_ID').val('137602');
        $('#getAreaX').submit();
    });
    $(document).on('click',('.highcharts-name-mandaluyong-city'),function(e) {
        $('#area_ID').val('137401');
        $('#getAreaX').submit();
    });
    $(document).on('click',('.highcharts-name-pasig'),function(e) {
        $('#area_ID').val('137403');
        $('#getAreaX').submit();
    });
    $(document).on('click',('.highcharts-name-paranaque'),function(e) {
        $('#area_ID').val('137604');
        $('#getAreaX').submit();
    });
    $(document).on('click',('.highcharts-name-taguig'),function(e) {
        $('#area_ID').val('137607');
        $('#getAreaX').submit();
    });
    $(document).on('click',('.highcharts-name-pateros'),function(e) {
        $('#area_ID').val('137606');
        $('#getAreaX').submit();
    });
    $(document).on('click',('.highcharts-name-las-pinas'),function(e) {
        $('#area_ID').val('137601');
        $('#getAreaX').submit();
    });
    $(document).on('click',('.highcharts-name-muntinlupa'),function(e) {
        $('#area_ID').val('137603');
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