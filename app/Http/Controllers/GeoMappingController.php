<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Carbon\Carbon;

// Register autoloader
// require_once($_SERVER['DOCUMENT_ROOT'] . '/../vendor/gasparesganga/php-shapefile/src/Shapefile/ShapefileAutoloader.php');

use Shapefile\ShapefileAutoloader;

// Import classes
use Shapefile\Shapefile;
use Shapefile\ShapefileException;
use Shapefile\ShapefileReader;

class GeoMappingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //ops_status_updater
        $datetime_now = Carbon::now()->format('Y-m-d H:i:s');

        $on_going_ops = DB::table('preops_header')->where('operation_datetime', '<=', $datetime_now)->where('validity', '>=', $datetime_now)->pluck('preops_number');
        $finished_ops = DB::table('preops_header')->where('validity', '<=', $datetime_now)->pluck('preops_number');
        //dd($on_going_ops);
        DB::table('preops_area')->whereIn('preops_number', $on_going_ops)->update(
            array(
                'ops_status'  =>  1,
            )
        );
        DB::table('preops_area')->whereIn('preops_number', $finished_ops)->update(
            array(
                'ops_status'  =>  0,
            )
        );
        //Provinces

        //Region 1
        if (Auth::user()->regional_office_id == 1 || Auth::user()->regional_office_id == 18 || Auth::user()->regional_office_id == 19) {
            $Ilocos_Norte  = DB::table('preops_area')->where('province_c', '0000000036')->where('ops_status', 1)->count();
            $Ilocos_Sur    = DB::table('preops_area')->where('province_c', '0000000037')->where('ops_status', 1)->count();
            $La_Union      = DB::table('preops_area')->where('province_c', '0000000041')->where('ops_status', 1)->count();
            $Pangasinan    = DB::table('preops_area')->where('province_c', '0000000065')->where('ops_status', 1)->count();
        } else {
            $Ilocos_Norte  = 0;
            $Ilocos_Sur    = 0;
            $La_Union      = 0;
            $Pangasinan    = 0;
        }

        //Region 2
        if (Auth::user()->regional_office_id == 2 || Auth::user()->regional_office_id == 18 || Auth::user()->regional_office_id == 19) {
            $Batanes       = DB::table('preops_area')->where('province_c', '0000000011')->where('ops_status', 1)->count();
            $Cagayan       = DB::table('preops_area')->where('province_c', '0000000018')->where('ops_status', 1)->count();
            $Isabela       = DB::table('preops_area')->where('province_c', '0000000039')->where('ops_status', 1)->count();
            $Nueva_Vizcaya = DB::table('preops_area')->where('province_c', '0000000060')->where('ops_status', 1)->count();
            $Quirino       = DB::table('preops_area')->where('province_c', '0000000067')->where('ops_status', 1)->count();
        } else {
            $Batanes       = 0;
            $Cagayan       = 0;
            $Isabela       = 0;
            $Nueva_Vizcaya = 0;
            $Quirino       = 0;
        }

        //Region 3
        if (Auth::user()->regional_office_id == 3 || Auth::user()->regional_office_id == 18 || Auth::user()->regional_office_id == 19) {
            $Bataan        = DB::table('preops_area')->where('province_c', '0000000010')->where('ops_status', 1)->count();
            $Bulacan       = DB::table('preops_area')->where('province_c', '0000000017')->where('ops_status', 1)->count();
            $Nueva_Ecija   = DB::table('preops_area')->where('province_c', '0000000059')->where('ops_status', 1)->count();
            $Pampanga      = DB::table('preops_area')->where('province_c', '0000000064')->where('ops_status', 1)->count();
            $Tarlac        = DB::table('preops_area')->where('province_c', '0000000080')->where('ops_status', 1)->count();
            $Zambales      = DB::table('preops_area')->where('province_c', '0000000082')->where('ops_status', 1)->count();
            $Aurora        = DB::table('preops_area')->where('province_c', '0000000008')->where('ops_status', 1)->count();
        } else {
            $Bataan        = 0;
            $Bulacan       = 0;
            $Nueva_Ecija   = 0;
            $Pampanga      = 0;
            $Tarlac        = 0;
            $Zambales      = 0;
            $Aurora        = 0;
        }

        //Region 4-a
        if (Auth::user()->regional_office_id == 4 || Auth::user()->regional_office_id == 18 || Auth::user()->regional_office_id == 19) {
            $Batangas      = DB::table('preops_area')->where('province_c', '0000000012')->where('ops_status', 1)->count();
            $Cavite        = DB::table('preops_area')->where('province_c', '0000000024')->where('ops_status', 1)->count();
            $Laguna        = DB::table('preops_area')->where('province_c', '0000000042')->where('ops_status', 1)->count();
            $Quezon        = DB::table('preops_area')->where('province_c', '0000000066')->where('ops_status', 1)->count();
            $Rizal         = DB::table('preops_area')->where('province_c', '0000000068')->where('ops_status', 1)->count();
        } else {
            $Batangas      = 0;
            $Cavite        = 0;
            $Laguna        = 0;
            $Quezon        = 0;
            $Rizal         = 0;
        }

        //Region 5
        if (Auth::user()->regional_office_id == 6 || Auth::user()->regional_office_id == 18 || Auth::user()->regional_office_id == 19) {
            $Albay         = DB::table('preops_area')->where('province_c', '0000000005')->where('ops_status', 1)->count();
            $Camarines_Norte  = DB::table('preops_area')->where('province_c', '0000000019')->where('ops_status', 1)->count();
            $Camarines_Sur    = DB::table('preops_area')->where('province_c', '0000000020')->where('ops_status', 1)->count();
            $Catanduanes   = DB::table('preops_area')->where('province_c', '0000000023')->where('ops_status', 1)->count();
            $Masbate       = DB::table('preops_area')->where('province_c', '0000000048')->where('ops_status', 1)->count();
            $Sorsogon      = DB::table('preops_area')->where('province_c', '0000000073')->where('ops_status', 1)->count();
        } else {
            $Albay            = 0;
            $Camarines_Norte  = 0;
            $Camarines_Sur    = 0;
            $Catanduanes      = 0;
            $Masbate          = 0;
            $Sorsogon         = 0;
        }

        //Region 6
        if (Auth::user()->regional_office_id == 7 || Auth::user()->regional_office_id == 18 || Auth::user()->regional_office_id == 19) {
            $Aklan         = DB::table('preops_area')->where('province_c', '0000000004')->where('ops_status', 1)->count();
            $Antique       = DB::table('preops_area')->where('province_c', '0000000006')->where('ops_status', 1)->count();
            $Capiz         = DB::table('preops_area')->where('province_c', '0000000022')->where('ops_status', 1)->count();
            $Iloilo        = DB::table('preops_area')->where('province_c', '0000000038')->where('ops_status', 1)->count();
            $Negros_Occidental  = DB::table('preops_area')->where('province_c', 'NP00000001')->where('ops_status', 1)->count();
            $Guimaras      = DB::table('preops_area')->where('province_c', '0000000034')->where('ops_status', 1)->count();
        } else {
            $Aklan         = 0;
            $Antique       = 0;
            $Capiz         = 0;
            $Iloilo        = 0;
            $Negros_Occidental  = 0;
            $Guimaras      = 0;
        }

        //Region 7
        if (Auth::user()->regional_office_id == 8 || Auth::user()->regional_office_id == 18 || Auth::user()->regional_office_id == 19) {
            $Bohol         = DB::table('preops_area')->where('province_c', '0000000015')->where('ops_status', 1)->count();
            $Cebu          = DB::table('preops_area')->where('province_c', '0000000025')->where('ops_status', 1)->count();
            $Negros_Oriental  = DB::table('preops_area')->where('province_c', 'NP00000002')->where('ops_status', 1)->count();
            $Siquijor      = DB::table('preops_area')->where('province_c', '0000000072')->where('ops_status', 1)->count();
        } else {
            $Bohol         = 0;
            $Cebu          = 0;
            $Negros_Oriental  = 0;
            $Siquijor      = 0;
        }

        //Region 8
        if (Auth::user()->regional_office_id == 9 || Auth::user()->regional_office_id == 18 || Auth::user()->regional_office_id == 19) {
            $Eastern_Samar = DB::table('preops_area')->where('province_c', '0000000033')->where('ops_status', 1)->count();
            $Leyte         = DB::table('preops_area')->where('province_c', '0000000045')->where('ops_status', 1)->count();
            $Northern_Samar = DB::table('preops_area')->where('province_c', '0000000058')->where('ops_status', 1)->count();
            $Samar         = DB::table('preops_area')->where('province_c', '0000000070')->where('ops_status', 1)->count();
            $Southern_Leyte = DB::table('preops_area')->where('province_c', '0000000075')->where('ops_status', 1)->count();
            $Biliran       = DB::table('preops_area')->where('province_c', '0000000014')->where('ops_status', 1)->count();
        } else {
            $Eastern_Samar = 0;
            $Leyte         = 0;
            $Northern_Samar = 0;
            $Samar         = 0;
            $Southern_Leyte = 0;
            $Biliran       = 0;
        }

        //Region 9
        if (Auth::user()->regional_office_id == 10 || Auth::user()->regional_office_id == 18 || Auth::user()->regional_office_id == 19) {
            $Zamboanga_del_Norte = DB::table('preops_area')->where('province_c', '0000000083')->where('ops_status', 1)->count();
            $Zamboanga_del_Sur = DB::table('preops_area')->where('province_c', '0000000084')->where('ops_status', 1)->count();
            $Zamboanga_Sibugay = DB::table('preops_area')->where('province_c', '0000000085')->where('ops_status', 1)->count();
        } else {

            $Zamboanga_del_Norte = 0;
            $Zamboanga_del_Sur = 0;
            $Zamboanga_Sibugay = 0;
        }

        //Region 10
        if (Auth::user()->regional_office_id == 11 || Auth::user()->regional_office_id == 18 || Auth::user()->regional_office_id == 19) {
            $Bukidnon      = DB::table('preops_area')->where('province_c', '0000000016')->where('ops_status', 1)->count();
            $Camiguin      = DB::table('preops_area')->where('province_c', '0000000021')->where('ops_status', 1)->count();
            $Lanao_del_Norte = DB::table('preops_area')->where('province_c', '0000000043')->where('ops_status', 1)->count();
            $Misamis_Occidental = DB::table('preops_area')->where('province_c', '0000000049')->where('ops_status', 1)->count();
            $Misamis_Oriental  = DB::table('preops_area')->where('province_c', '0000000050')->where('ops_status', 1)->count();
        } else {
            $Bukidnon      = 0;
            $Camiguin      = 0;
            $Lanao_del_Norte = 0;
            $Misamis_Occidental = 0;
            $Misamis_Oriental  = 0;
        }

        //Region 11
        if (Auth::user()->regional_office_id == 12 || Auth::user()->regional_office_id == 18 || Auth::user()->regional_office_id == 19) {
            $Davao_del_Norte   = DB::table('preops_area')->where('province_c', '0000000029')->where('ops_status', 1)->count();
            $Davao_del_Sur     = DB::table('preops_area')->where('province_c', '0000000030')->where('ops_status', 1)->count();
            $Davao_Oriental    = DB::table('preops_area')->where('province_c', '0000000031')->where('ops_status', 1)->count();
            $Compostela_Valley  = DB::table('preops_area')->where('province_c', '0000000027')->where('ops_status', 1)->count();
            $Davao_Occidental   = DB::table('preops_area')->where('province_c', 'DAVOCC')->where('ops_status', 1)->count();
        } else {
            $Davao_del_Norte   = 0;
            $Davao_del_Sur     = 0;
            $Davao_Oriental    = 0;
            $Compostela_Valley  = 0;
            $Davao_Occidental   = 0;
        }

        //Region 12
        if (Auth::user()->regional_office_id == 13 || Auth::user()->regional_office_id == 18 || Auth::user()->regional_office_id == 19) {
            $North_Cotabato  = DB::table('preops_area')->where('province_c', 'NCOT')->where('ops_status', 1)->count();
            $South_Cotabato  = DB::table('preops_area')->where('province_c', '0000000074')->where('ops_status', 1)->count();
            $Sultan_Kudarat  = DB::table('preops_area')->where('province_c', '0000000076')->where('ops_status', 1)->count();
            $Sarangani       = DB::table('preops_area')->where('province_c', '0000000071')->where('ops_status', 1)->count();
        } else {
            $North_Cotabato  = 0;
            $South_Cotabato  = 0;
            $Sultan_Kudarat  = 0;
            $Sarangani       = 0;
        }

        //NCR
        if (Auth::user()->regional_office_id == 17 || Auth::user()->regional_office_id == 18 || Auth::user()->regional_office_id == 19) {
            $Manila        = DB::table('preops_area')->where('city_c', 133902)->where('ops_status', 1)->count();
            $Mandaluyong   = DB::table('preops_area')->where('city_c', '0000000002')->where('ops_status', 1)->count();
            $Marikina      = DB::table('preops_area')->where('city_c', '0000000003')->where('ops_status', 1)->count();
            $Pasig         = DB::table('preops_area')->where('city_c', '0000000004')->where('ops_status', 1)->count();
            $Quezon_City   = DB::table('preops_area')->where('city_c', '0000000005')->where('ops_status', 1)->count();
            $San_Juan      = DB::table('preops_area')->where('city_c', '0000000006')->where('ops_status', 1)->count();
            $Caloocan      = DB::table('preops_area')->where('city_c', '0000000007')->where('ops_status', 1)->count();
            $Malabon       = DB::table('preops_area')->where('city_c', '0000000008')->where('ops_status', 1)->count();
            $Navotas       = DB::table('preops_area')->where('city_c', '0000000009')->where('ops_status', 1)->count();
            $Valenzuela    = DB::table('preops_area')->where('city_c', '0000000010')->where('ops_status', 1)->count();
            $Las_Pinas     = DB::table('preops_area')->where('city_c', '0000000011')->where('ops_status', 1)->count();
            $Makati        = DB::table('preops_area')->where('city_c', '0000000012')->where('ops_status', 1)->count();
            $Muntinlupa    = DB::table('preops_area')->where('city_c', '0000000013')->where('ops_status', 1)->count();
            $Paranaque     = DB::table('preops_area')->where('city_c', '0000000014')->where('ops_status', 1)->count();
            $Pasay         = DB::table('preops_area')->where('city_c', '0000000015')->where('ops_status', 1)->count();
            $Pateros       = DB::table('preops_area')->where('city_c', '0000000016')->where('ops_status', 1)->count();
            $Taguig        = DB::table('preops_area')->where('city_c', '0000000017')->where('ops_status', 1)->count();
        } else {
            $Manila        = 0;
            $Mandaluyong   = 0;
            $Marikina      = 0;
            $Pasig         = 0;
            $Quezon_City   = 0;
            $San_Juan      = 0;
            $Caloocan      = 0;
            $Malabon       = 0;
            $Navotas       = 0;
            $Valenzuela    = 0;
            $Las_Pinas     = 0;
            $Makati        = 0;
            $Muntinlupa    = 0;
            $Paranaque     = 0;
            $Pasay         = 0;
            $Pateros       = 0;
            $Taguig        = 0;
        }

        //Region CAR
        if (Auth::user()->regional_office_id == 16 || Auth::user()->regional_office_id == 18 || Auth::user()->regional_office_id == 19) {
            $Abra          = DB::table('preops_area')->where('province_c', '0000000001')->where('ops_status', 1)->count();
            $Benguet       = DB::table('preops_area')->where('province_c', '0000000013')->where('ops_status', 1)->count();
            $Ifugao        = DB::table('preops_area')->where('province_c', '0000000035')->where('ops_status', 1)->count();
            $Kalinga       = DB::table('preops_area')->where('province_c', '0000000040')->where('ops_status', 1)->count();
            $Mountain_Province = DB::table('preops_area')->where('province_c', '0000000051')->where('ops_status', 1)->count();
            $Apayao       = DB::table('preops_area')->where('province_c', '0000000007')->where('ops_status', 1)->count();
        } else {
            $Abra          = 0;
            $Benguet       = 0;
            $Ifugao        = 0;
            $Kalinga       = 0;
            $Mountain_Province = 0;
            $Apayao       = 0;
        }

        //Region ARMM
        if (Auth::user()->regional_office_id == 15 || Auth::user()->regional_office_id == 18 || Auth::user()->regional_office_id == 19) {
            $Basilan       = DB::table('preops_area')->where('province_c', 'BAS')->where('ops_status', 1)->count();
            $Lanao_del_Sur  = DB::table('preops_area')->where('province_c', '0000000044')->where('ops_status', 1)->count();
            $Maguindanao    = DB::table('preops_area')->where('province_c', '0000000046')->where('ops_status', 1)->count();
            $Sulu          = DB::table('preops_area')->where('province_c', '0000000077')->where('ops_status', 1)->count();
            $Tawi_Tawi     = DB::table('preops_area')->where('province_c', '0000000081')->where('ops_status', 1)->count();
        } else {
            $Basilan       = 0;
            $Lanao_del_Sur  = 0;
            $Maguindanao    = 0;
            $Sulu          = 0;
            $Tawi_Tawi     = 0;
        }

        //Region CARAGA
        if (Auth::user()->regional_office_id == 14 || Auth::user()->regional_office_id == 18 || Auth::user()->regional_office_id == 19) {
            $Agusan_del_Norte = DB::table('preops_area')->where('province_c', '0000000002')->where('ops_status', 1)->count();
            $Agusan_del_Sur   = DB::table('preops_area')->where('province_c', '0000000003')->where('ops_status', 1)->count();
            $Surigao_del_Norte = DB::table('preops_area')->where('province_c', '0000000078')->where('ops_status', 1)->count();
            $Surigao_del_Sur   = DB::table('preops_area')->where('province_c', '0000000079')->where('ops_status', 1)->count();
            $Dinagat_Islands   = DB::table('preops_area')->where('province_c', '0000000032')->where('ops_status', 1)->count();
        } else {
            $Agusan_del_Norte = 0;
            $Agusan_del_Sur   = 0;
            $Surigao_del_Norte = 0;
            $Surigao_del_Sur   = 0;
            $Dinagat_Islands   = 0;
        }
        //Region 4-b MIMAROPA
        if (Auth::user()->regional_office_id == 5 || Auth::user()->regional_office_id == 18 || Auth::user()->regional_office_id == 19) {
            $Marinduque    = DB::table('preops_area')->where('province_c', '0000000047')->where('ops_status', 1)->count();
            $Occidental_Mindoro    = DB::table('preops_area')->where('province_c', '0000000061')->where('ops_status', 1)->count();
            $Oriental_Mindoro     = DB::table('preops_area')->where('province_c', '0000000062')->where('ops_status', 1)->count();
            $Palawan       = DB::table('preops_area')->where('province_c', '0000000063')->where('ops_status', 1)->count();
            $Romblon       = DB::table('preops_area')->where('province_c', '0000000069')->where('ops_status', 1)->count();
        } else {
            $Marinduque    = 0;
            $Occidental_Mindoro    = 0;
            $Oriental_Mindoro     = 0;
            $Palawan       = 0;
            $Romblon       = 0;
        }

        return view('geo_mapping.geo_mapping', compact(
            'Ilocos_Norte',
            'Ilocos_Sur',
            'La_Union',
            'Pangasinan',
            'Batanes',
            'Cagayan',
            'Isabela',
            'Nueva_Vizcaya',
            'Quirino',
            'Bataan',
            'Bulacan',
            'Nueva_Ecija',
            'Pampanga',
            'Tarlac',
            'Zambales',
            'Aurora',
            'Batangas',
            'Cavite',
            'Laguna',
            'Quezon',
            'Rizal',
            'Albay',
            'Camarines_Norte',
            'Camarines_Sur',
            'Catanduanes',
            'Masbate',
            'Sorsogon',
            'Aklan',
            'Antique',
            'Capiz',
            'Iloilo',
            'Negros_Occidental',
            'Guimaras',
            'Bohol',
            'Cebu',
            'Negros_Oriental',
            'Siquijor',
            'Eastern_Samar',
            'Leyte',
            'Northern_Samar',
            'Samar',
            'Southern_Leyte',
            'Biliran',
            'Zamboanga_del_Norte',
            'Zamboanga_del_Sur',
            'Zamboanga_Sibugay',
            'Bukidnon',
            'Camiguin',
            'Lanao_del_Norte',
            'Misamis_Occidental',
            'Misamis_Oriental',
            'Davao_del_Norte',
            'Davao_del_Sur',
            'Davao_Oriental',
            'Compostela_Valley',
            'Davao_Occidental',
            'North_Cotabato',
            'South_Cotabato',
            'Sultan_Kudarat',
            'Sarangani',
            'Abra',
            'Benguet',
            'Ifugao',
            'Kalinga',
            'Mountain_Province',
            'Basilan',
            'Lanao_del_Sur',
            'Maguindanao',
            'Sulu',
            'Tawi_Tawi',
            'Agusan_del_Norte',
            'Agusan_del_Sur',
            'Dinagat_Islands',
            'Marinduque',
            'Occidental_Mindoro',
            'Oriental_Mindoro',
            'Palawan',
            'Romblon',
            'Surigao_del_Norte',
            'Surigao_del_Sur',
            'Apayao',

            'Manila',
            'Mandaluyong',
            'Marikina',
            'Pasig',
            'Quezon_City',
            'San_Juan',
            'Caloocan',
            'Malabon',
            'Navotas',
            'Valenzuela',
            'Las_Pinas',
            'Makati',
            'Muntinlupa',
            'Paranaque',
            'Pasay',
            'Pateros',
            'Taguig'

        ));
    }

    public function index2()
    {
        return view('geo_mapping.geo_mapping2');
    }


    public function testCase()
    {
        ShapefileAutoloader::register();
        echo "<pre>";
        try {
            // Open Shapefile
            $Shapefile = new ShapefileReader(public_path('css\shpX\MunCit.shp'));
            //print_r($Shapefile->fetchRecord()->getArray());

            // Read all the records
            while ($Geometry = $Shapefile->fetchRecord()) {
                // Skip the record if marked as "deleted"
                if ($Geometry->isDeleted()) {
                    continue;
                }
                // Print Geometry as an Array
                //print_r($Geometry->getArray());

                // Print Geometry as WKT
                //print_r($Geometry->getWKT());

                // Print Geometry as GeoJSON
                print_r($Geometry->getGeoJSON());

                // Print DBF data
                //print_r($Geometry->getDataArray());
            }
        } catch (ShapefileException $e) {
            // Print detailed error information
            echo "Error Type: " . $e->getErrorType()
                . "\nMessage: " . $e->getMessage()
                . "\nDetails: " . $e->getDetails();
        }
        echo "</pre>";
    }

    public function ops_details(Request $request)
    {
        $data = $request->all();
        $user_area = Auth::user()->regional_office_id;
        $datetime_now = Carbon::now();
        $city2 = '';
        $brgy2 = '';
        $Title_Loc = $data['area_ID'];
        $brgyXB = [];

        if (str_contains($data['area_ID'], 'c')) {
            $area_IDx = rtrim($data['area_ID'], "c");
            $the_province = DB::table('city')->where('city_c', $area_IDx)->pluck('province_c');
            $the_region = DB::table('province')->where('province_c', $the_province[0])->pluck('region_c');

            if ($the_region[0] == "0000000001") {
                $X_Region = 1;
            }
            if ($the_region[0] == "0000000002") {
                $X_Region = 2;
            }
            if ($the_region[0] == "0000000003") {
                $X_Region = 3;
            }
            if ($the_region[0] == "0000000004") {
                $X_Region = 4;
            }
            if ($the_region[0] == "0000000005") {
                $X_Region = 6;
            }
            if ($the_region[0] == "0000000006") {
                $X_Region = 7;
            }
            if ($the_region[0] == "0000000007") {
                $X_Region = 8;
            }
            if ($the_region[0] == "0000000008") {
                $X_Region = 9;
            }
            if ($the_region[0] == "0000000009") {
                $X_Region = 10;
            }
            if ($the_region[0] == "0000000010") {
                $X_Region = 11;
            }
            if ($the_region[0] == "0000000011") {
                $X_Region = 12;
            }
            if ($the_region[0] == "0000000012") {
                $X_Region = 13;
            }
            if ($the_region[0] == "0000000013") {
                $X_Region = 17;
            }
            if ($the_region[0] == "0000000014") {
                $X_Region = 16;
            }
            if ($the_region[0] == "0000000015") {
                $X_Region = 15;
            }
            if ($the_region[0] == "0000000016") {
                $X_Region = 14;
            }
            if ($the_region[0] == "0000000017") {
                $X_Region = 5;
            }
            if ($the_region[0] == "0000000018") {
                $X_Region = 19;
            }

            if ($user_area != 18 && $user_area != 19) {
                if ($X_Region != $user_area) {
                    return redirect('geo_mapping')->with('warning', 'This is not your Region');
                }
            }

            $ops_details_area = DB::table('preops_area')->where('city_c', $data['area_ID'])->orderBy('created_at', 'DESC')->get();
            $ops_numbers = DB::table('preops_area')->where('city_c', $data['area_ID'])->pluck('preops_number');

            $ops_details = DB::table('preops_header')->where('status', 1)->where('operation_datetime', '<=', $datetime_now)->where('validity', '>=', $datetime_now)->whereIn('preops_number', $ops_numbers)->get();
            $ops_count = count($ops_details);
            $ops_numbers2 = $ops_details->pluck('preops_number');
            $ops_details_area2 = DB::table('preops_area')->whereIn('preops_number', $ops_numbers2)->get();

            $the_teams = DB::table('preops_header')->where('status', 1)->whereIn('preops_number', $ops_numbers2)->pluck('preops_number');
            $ops_teams = DB::table('preops_team')->whereIn('preops_number', $the_teams)->get();


            $region = [];
            $regionB = [];
            $province = [];
            $provinceB = [];
            $city = [];
            $cityB = [];
            $brgy = [];
            $brgyB = [];

            $city2 = [];
            $city2B = [];
            $brgy2 = [];
            $brgy2B = [];

            //////////////////////////
            $ops_details2 = DB::table('preops_header')->where('operation_datetime', '>', $datetime_now)->whereIn('preops_number', $ops_numbers)->get();
            $ops_numbers3 = $ops_details2->pluck('preops_number');
            $ops_details_area3 = DB::table('preops_area')->whereIn('preops_number', $ops_numbers3)->get();

            $the_teams2 = DB::table('preops_header')->where('status', 1)->whereIn('preops_number', $ops_numbers3)->pluck('preops_number');
            $ops_teams2 = DB::table('preops_team')->whereIn('preops_number', $the_teams2)->get();

            if ($ops_details_area->isEmpty()) {
                $region = ['---'];
                $province = ['---'];
                $city = ['---'];
                $brgy = ['---'];
            } else {
                foreach ($ops_details as $key => $opd) {

                    $regionX = DB::table('region')->where('region_c', $ops_details_area2[$key]->region_c)->pluck('region_m');
                    array_push($region, $regionX[0]);
                    $provinceX = DB::table('province')->where('province_c', $ops_details_area2[$key]->province_c)->pluck('province_m');
                    array_push($province, $provinceX[0]);
                    $cityX = DB::table('city')->where('city_c', $ops_details_area2[$key]->city_c)->pluck('city_m');
                    array_push($city, $cityX[0]);
                    $brgyX = DB::table('barangay')->where('barangay_c', $ops_details_area2[$key]->barangay_c)->pluck('barangay_m');
                    if ($ops_details_area2[$key]->barangay_c) {
                        array_push($brgy, $brgyX[0]);
                    } else {
                        array_push($brgy, "---");
                    }

                    $cityX2 = $ops_details_area2[$key]->city_c;
                    array_push($city2, $cityX2);
                    $brgyX2 = $ops_details_area2[$key]->barangay_c;
                    array_push($brgy2, $brgyX2);
                }
                foreach ($ops_details2 as $key => $opd2) {

                    $regionXB = DB::table('region')->where('region_c', $ops_details_area3[$key]->region_c)->pluck('region_m');
                    array_push($regionB, $regionXB[0]);
                    $provinceXB = DB::table('province')->where('province_c', $ops_details_area3[$key]->province_c)->pluck('province_m');
                    array_push($provinceB, $provinceXB[0]);
                    $cityXB = DB::table('city')->where('city_c', $ops_details_area3[$key]->city_c)->pluck('city_m');
                    array_push($cityB, $cityXB[0]);
                    $brgyXB = DB::table('barangay')->where('barangay_c', $ops_details_area3[$key]->barangay_c)->pluck('barangay_m');
                    
                    if ($ops_details_area3[$key]->barangay_c) {
                        array_push($brgy, $brgyXB[0]);
                    } else {
                        array_push($brgy, "---");
                    }

                    $cityX2B = $ops_details_area3[$key]->city_c;
                    array_push($city2B, $cityX2B);
                    $brgyX2B = $ops_details_area3[$key]->barangay_c;
                    array_push($brgy2B, $brgyX2B);
                }
            }
        }

        if ($data['area_ID'] == 0) {
            $the_province = DB::table('city')->whereIn('city_c', ['MAL','MLA','SVBS'])->pluck('province_c');
            $the_region = DB::table('province')->where('province_c', $the_province[0])->pluck('region_c');

            if ($the_region[0] == "0000000001") {
                $X_Region = 1;
            }
            if ($the_region[0] == "0000000002") {
                $X_Region = 2;
            }
            if ($the_region[0] == "0000000003") {
                $X_Region = 3;
            }
            if ($the_region[0] == "0000000004") {
                $X_Region = 4;
            }
            if ($the_region[0] == "0000000005") {
                $X_Region = 6;
            }
            if ($the_region[0] == "0000000006") {
                $X_Region = 7;
            }
            if ($the_region[0] == "0000000007") {
                $X_Region = 8;
            }
            if ($the_region[0] == "0000000008") {
                $X_Region = 9;
            }
            if ($the_region[0] == "0000000009") {
                $X_Region = 10;
            }
            if ($the_region[0] == "0000000010") {
                $X_Region = 11;
            }
            if ($the_region[0] == "0000000011") {
                $X_Region = 12;
            }
            if ($the_region[0] == "0000000012") {
                $X_Region = 13;
            }
            if ($the_region[0] == "0000000013") {
                $X_Region = 17;
            }
            if ($the_region[0] == "0000000014") {
                $X_Region = 16;
            }
            if ($the_region[0] == "0000000015") {
                $X_Region = 15;
            }
            if ($the_region[0] == "0000000016") {
                $X_Region = 14;
            }
            if ($the_region[0] == "0000000017") {
                $X_Region = 5;
            }
            if ($the_region[0] == "0000000018") {
                $X_Region = 19;
            }

            if ($user_area != 18 && $user_area != 19) {
                if ($X_Region != $user_area) {
                    return redirect('geo_mapping')->with('warning', 'This is not your Region');
                }
            }

            $ops_details_area = DB::table('preops_area')->whereBetween('city_c', [133901, 133914])->orderBy('created_at', 'DESC')->get();
            $ops_numbers = DB::table('preops_area')->whereBetween('city_c', [133901, 133914])->pluck('preops_number');

            $ops_details = DB::table('preops_header')->where('status', 1)->where('operation_datetime', '<=', $datetime_now)->where('validity', '>=', $datetime_now)->whereIn('preops_number', $ops_numbers)->get();
            $ops_count = count($ops_details);
            $ops_numbers2 = $ops_details->pluck('preops_number');
            $ops_details_area2 = DB::table('preops_area')->whereIn('preops_number', $ops_numbers2)->get();

            $the_teams = DB::table('preops_header')->where('status', 1)->whereIn('preops_number', $ops_numbers2)->pluck('preops_number');
            $ops_teams = DB::table('preops_team')->whereIn('preops_number', $the_teams)->get();


            $region = [];
            $regionB = [];
            $province = [];
            $provinceB = [];
            $city = [];
            $cityB = [];
            $brgy = [];
            $brgyB = [];

            $city2 = [];
            $city2B = [];
            $brgy2 = [];
            $brgy2B = [];

            //////////////////////////
            $ops_details2 = DB::table('preops_header')->where('operation_datetime', '>', $datetime_now)->whereIn('preops_number', $ops_numbers)->get();
            $ops_numbers3 = $ops_details2->pluck('preops_number');
            $ops_details_area3 = DB::table('preops_area')->whereIn('preops_number', $ops_numbers3)->get();

            $the_teams2 = DB::table('preops_header')->where('status', 1)->whereIn('preops_number', $ops_numbers3)->pluck('preops_number');
            $ops_teams2 = DB::table('preops_team')->whereIn('preops_number', $the_teams2)->get();

            if ($ops_details_area->isEmpty()) {
                $region = ['---'];
                $province = ['---'];
                $city = ['---'];
                $brgy = ['---'];
            } else {
                foreach ($ops_details as $key => $opd) {

                    $regionX = DB::table('region')->where('region_c', $ops_details_area2[$key]->region_c)->pluck('region_m');
                    array_push($region, $regionX[0]);
                    $provinceX = DB::table('province')->where('province_c', $ops_details_area2[$key]->province_c)->pluck('province_m');
                    array_push($province, $provinceX[0]);
                    $cityX = DB::table('city')->where('city_c', $ops_details_area2[$key]->city_c)->pluck('city_m');
                    array_push($city, $cityX[0]);
                    $brgyX = DB::table('barangay')->where('barangay_c', $ops_details_area2[$key]->barangay_c)->pluck('barangay_m');
                    if ($ops_details_area2[$key]->barangay_c) {
                        array_push($brgy, $brgyX[0]);
                    } else {
                        array_push($brgy, "---");
                    }

                    $cityX2 = $ops_details_area2[$key]->city_c;
                    array_push($city2, $cityX2);
                    $brgyX2 = $ops_details_area2[$key]->barangay_c;
                    array_push($brgy2, $brgyX2);
                }
                foreach ($ops_details2 as $key => $opd2) {

                    $regionXB = DB::table('region')->where('region_c', $ops_details_area3[$key]->region_c)->pluck('region_m');
                    array_push($regionB, $regionXB[0]);
                    $provinceXB = DB::table('province')->where('province_c', $ops_details_area3[$key]->province_c)->pluck('province_m');
                    array_push($provinceB, $provinceXB[0]);
                    $cityXB = DB::table('city')->where('city_c', $ops_details_area3[$key]->city_c)->pluck('city_m');
                    array_push($cityB, $cityXB[0]);
                    $brgyXB = DB::table('barangay')->where('barangay_c', $ops_details_area3[$key]->barangay_c)->pluck('barangay_m');
                    
                    if ($ops_details_area3[$key]->barangay_c) {
                        array_push($brgy, $brgyXB[0]);
                    } else {
                        array_push($brgy, "---");
                    }

                    $cityX2B = $ops_details_area3[$key]->city_c;
                    array_push($city2B, $cityX2B);
                    $brgyX2B = $ops_details_area3[$key]->barangay_c;
                    array_push($brgy2B, $brgyX2B);
                }
            }
        }

        if ($data['area_ID'] < 137400 && $data['area_ID'] != 0) {
            $the_region = DB::table('province')->where('province_c', $data['area_ID'])->pluck('region_c');

            if ($the_region[0] == "0000000001") {
                $X_Region = 1;
            }
            if ($the_region[0] == "0000000002") {
                $X_Region = 2;
            }
            if ($the_region[0] == "0000000003") {
                $X_Region = 3;
            }
            if ($the_region[0] == "0000000004") {
                $X_Region = 4;
            }
            if ($the_region[0] == "0000000005") {
                $X_Region = 6;
            }
            if ($the_region[0] == "0000000006") {
                $X_Region = 7;
            }
            if ($the_region[0] == "0000000007") {
                $X_Region = 8;
            }
            if ($the_region[0] == "0000000008") {
                $X_Region = 9;
            }
            if ($the_region[0] == "0000000009") {
                $X_Region = 10;
            }
            if ($the_region[0] == "0000000010") {
                $X_Region = 11;
            }
            if ($the_region[0] == "0000000011") {
                $X_Region = 12;
            }
            if ($the_region[0] == "0000000012") {
                $X_Region = 13;
            }
            if ($the_region[0] == "0000000013") {
                $X_Region = 17;
            }
            if ($the_region[0] == "0000000014") {
                $X_Region = 16;
            }
            if ($the_region[0] == "0000000015") {
                $X_Region = 15;
            }
            if ($the_region[0] == "0000000016") {
                $X_Region = 14;
            }
            if ($the_region[0] == "0000000017") {
                $X_Region = 5;
            }
            if ($the_region[0] == "0000000018") {
                $X_Region = 19;
            }
           
            //dd($data['area_ID'],$the_region,$X_Region,$user_area);
            if ($user_area != 18 && $user_area != 19) {
                if ($X_Region != $user_area) {
                    return redirect('geo_mapping')->with('warning', 'This is not your Region');
                }
            }

            $ops_details_area = DB::table('preops_area')->where('province_c', $data['area_ID'])->orderBy('created_at', 'DESC')->get();
            $ops_numbers = DB::table('preops_area')->where('province_c', $data['area_ID'])->pluck('preops_number');

            $ops_details = DB::table('preops_header')->where('status', 1)->where('operation_datetime', '<=', $datetime_now)->where('validity', '>=', $datetime_now)->whereIn('preops_number', $ops_numbers)->get();
            $ops_count = count($ops_details);

            $ops_numbers2 = $ops_details->pluck('preops_number');
            $ops_details_area2 = DB::table('preops_area')->whereIn('preops_number', $ops_numbers2)->get();

            $the_teams = DB::table('preops_header')->where('status', 1)->whereIn('preops_number', $ops_numbers2)->pluck('preops_number');
            $ops_teams = DB::table('preops_team')->whereIn('preops_number', $the_teams)->get();


            $region = [];
            $regionB = [];
            $province = [];
            $provinceB = [];
            $city = [];
            $cityB = [];
            $brgy = [];
            $brgyB = [];

            $city2 = [];
            $city2B = [];
            $brgy2 = [];
            $brgy2B = [];
            $brgyXB = [];

            //////////////////////////
            $ops_details2 = DB::table('preops_header')->where('operation_datetime', '>', $datetime_now)->whereIn('preops_number', $ops_numbers)->get();
            $ops_numbers3 = $ops_details2->pluck('preops_number');
            $ops_details_area3 = DB::table('preops_area')->whereIn('preops_number', $ops_numbers3)->get();

            $the_teams2 = DB::table('preops_header')->where('status', 1)->whereIn('preops_number', $ops_numbers3)->pluck('preops_number');
            $ops_teams2 = DB::table('preops_team')->whereIn('preops_number', $the_teams2)->get();
            //dd($ops_details_area2);

            if ($ops_details_area->isEmpty()) {
                $region = ['---'];
                $province = ['---'];
                $city = ['---'];
                $brgy = ['---'];
            } else {
                foreach ($ops_details as $key => $opd) {
                    
                    $regionX = DB::table('region')->where('region_c', $ops_details_area2[$key]->region_c)->pluck('region_m');
                    array_push($region, $regionX[0]);
                    $provinceX = DB::table('province')->where('province_c', $ops_details_area2[$key]->province_c)->pluck('province_m');
                    array_push($province, $provinceX[0]);
                    $cityX = DB::table('city')->where('city_c', $ops_details_area2[$key]->city_c)->pluck('city_m');
                    array_push($city, $cityX[0]);
                    $brgyX = DB::table('barangay')->where('barangay_c', $ops_details_area2[$key]->barangay_c)->pluck('barangay_m');
                    if ($ops_details_area2[$key]->barangay_c) {
                        array_push($brgy, $brgyX[0]);
                    } else {
                        array_push($brgy, "---");
                    }
                    
                    $cityX2 = $ops_details_area2[$key]->city_c;
                    array_push($city2, $cityX2);
                    $brgyX2 = $ops_details_area2[$key]->barangay_c;
                    array_push($brgy2, $brgyX2);
                }
                foreach ($ops_details2 as $key => $opd2) {

                    $regionXB = DB::table('region')->where('region_c', $ops_details_area3[$key]->region_c)->pluck('region_m');
                    array_push($regionB, $regionXB[0]);
                    $provinceXB = DB::table('province')->where('province_c', $ops_details_area3[$key]->province_c)->pluck('province_m');
                    array_push($provinceB, $provinceXB[0]);
                    $cityXB = DB::table('city')->where('city_c', $ops_details_area3[$key]->city_c)->pluck('city_m');
                    array_push($cityB, $cityXB[0]);
                    $brgyXB = DB::table('barangay')->where('barangay_c', $ops_details_area3[$key]->barangay_c)->pluck('barangay_m');
                    
                    if ($ops_details_area3[$key]->barangay_c) {
                        array_push($brgy, $brgyXB[0]);
                    } else {
                        array_push($brgy, "---");
                    }

                    $cityX2B = $ops_details_area3[$key]->city_c;
                    array_push($city2B, $cityX2B);
                    $brgyX2B = $ops_details_area3[$key]->barangay_c;
                    array_push($brgy2B, $brgyX2B);
                }
            }
        }
        $area_IDx = $data['area_ID'];

        return view('geo_mapping/geo_ops_details', compact(
            'ops_details',
            'ops_details_area',
            'ops_count',
            'area_IDx',
            'ops_teams',
            'region',
            'province',
            'city',
            'brgy',
            'city2',
            'brgy2',
            'Title_Loc',
            'ops_details2',
            'regionB',
            'provinceB',
            'cityB',
            'brgyB',
            'city2B',
            'brgy2B',
            'ops_teams2',
            'ops_details_area3',
            'brgyXB'
        ));
    }

    public function ops_update_warning(Request $request)
    {
        $data = $request->all();

        if ($data['opd_action'] == 1) {
            DB::table('preops_header')->where('id', $data['opd_ID'])->update(
                array(
                    'warning_issuance'  =>  1,
                )
            );
        }

        if ($data['opd_action'] == 0) {
            DB::table('preops_header')->where('id', $data['opd_ID'])->update(
                array(
                    'warning_issuance'  =>  0,
                )
            );
        }

        return redirect()->back();
    }
}
