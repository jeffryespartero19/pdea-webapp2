<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB; use Auth;
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
        $datetime_now=Carbon::now();
        $on_going_ops=DB::table('preops_header')->where('status',1)->whereDate('operation_datetime','<=',$datetime_now)->whereDate('validity','>=',$datetime_now)->pluck('preops_number');

        DB::table('preops_area')->whereIn('preops_number',$on_going_ops)->update(
            array(
                'ops_status'  =>  1,
            )
        );
     //Provinces

        //Region 1
        if(Auth::user()->region_c==1 || Auth::user()->region_c==0){
            $Ilocos_Norte  =DB::table('preops_area')->where('province_c',128)->where('ops_status',1)->count();
            $Ilocos_Sur    =DB::table('preops_area')->where('province_c',129)->where('ops_status',1)->count();
            $La_Union      =DB::table('preops_area')->where('province_c',133)->where('ops_status',1)->count();
            $Pangasinan    =DB::table('preops_area')->where('province_c',155)->where('ops_status',1)->count();
        }else{
            $Ilocos_Norte  =0;
            $Ilocos_Sur    =0;
            $La_Union      =0;
            $Pangasinan    =0;
        }

        //Region 2
        if(Auth::user()->region_c==2 || Auth::user()->region_c==0){
            $Batanes       =DB::table('preops_area')->where('province_c',209)->where('ops_status',1)->count();
            $Cagayan       =DB::table('preops_area')->where('province_c',215)->where('ops_status',1)->count();
            $Isabela       =DB::table('preops_area')->where('province_c',231)->where('ops_status',1)->count();
            $Nueva_Vizcaya =DB::table('preops_area')->where('province_c',250)->where('ops_status',1)->count();
            $Quirino       =DB::table('preops_area')->where('province_c',128)->where('ops_status',1)->count();
        }else{
            $Batanes       =0;
            $Cagayan       =0;
            $Isabela       =0;
            $Nueva_Vizcaya =0;
            $Quirino       =0;
        }

        //Region 3
        if(Auth::user()->region_c==3 || Auth::user()->region_c==0){
            $Bataan        =DB::table('preops_area')->where('province_c',257)->where('ops_status',1)->count();
            $Bulacan       =DB::table('preops_area')->where('province_c',314)->where('ops_status',1)->count();
            $Nueva_Ecija   =DB::table('preops_area')->where('province_c',349)->where('ops_status',1)->count();
            $Pampanga      =DB::table('preops_area')->where('province_c',354)->where('ops_status',1)->count();
            $Tarlac        =DB::table('preops_area')->where('province_c',369)->where('ops_status',1)->count();
            $Zambales      =DB::table('preops_area')->where('province_c',371)->where('ops_status',1)->count();
            $Aurora        =DB::table('preops_area')->where('province_c',377)->where('ops_status',1)->count();
        }else{
            $Bataan        =0;
            $Bulacan       =0;
            $Nueva_Ecija   =0;
            $Pampanga      =0;
            $Tarlac        =0;
            $Zambales      =0;
            $Aurora        =0;
        }

        //Region 4-a
        if(Auth::user()->region_c==4 || Auth::user()->region_c==0){
            $Batangas      =DB::table('preops_area')->where('province_c',410)->where('ops_status',1)->count();
            $Cavite        =DB::table('preops_area')->where('province_c',421)->where('ops_status',1)->count();
            $Laguna        =DB::table('preops_area')->where('province_c',434)->where('ops_status',1)->count();
            $Quezon        =DB::table('preops_area')->where('province_c',456)->where('ops_status',1)->count();
            $Rizal         =DB::table('preops_area')->where('province_c',458)->where('ops_status',1)->count();
        }else{
            $Batangas      =0;
            $Cavite        =0;
            $Laguna        =0;
            $Quezon        =0;
            $Rizal         =0;
        }

        //Region 5
        if(Auth::user()->region_c==5 || Auth::user()->region_c==0){
            $Albay         =DB::table('preops_area')->where('province_c',505)->where('ops_status',1)->count();
            $Camarines_Norte  =DB::table('preops_area')->where('province_c',516)->where('ops_status',1)->count();
            $Camarines_Sur    =DB::table('preops_area')->where('province_c',517)->where('ops_status',1)->count();
            $Catanduanes   =DB::table('preops_area')->where('province_c',520)->where('ops_status',1)->count();
            $Masbate       =DB::table('preops_area')->where('province_c',541)->where('ops_status',1)->count();
            $Sorsogon      =DB::table('preops_area')->where('province_c',562)->where('ops_status',1)->count();
        }else{
            $Albay            =0;
            $Camarines_Norte  =0;
            $Camarines_Sur    =0;
            $Catanduanes      =0;
            $Masbate          =0;
            $Sorsogon         =0;
        }

        //Region 6
        if(Auth::user()->region_c==6 || Auth::user()->region_c==0){
            $Aklan         =DB::table('preops_area')->where('province_c',604)->where('ops_status',1)->count();
            $Antique       =DB::table('preops_area')->where('province_c',606)->where('ops_status',1)->count();
            $Capiz         =DB::table('preops_area')->where('province_c',619)->where('ops_status',1)->count();
            $Iloilo        =DB::table('preops_area')->where('province_c',630)->where('ops_status',1)->count();
            $Negros_Occidental  =DB::table('preops_area')->where('province_c',645)->where('ops_status',1)->count();
            $Guimaras      =DB::table('preops_area')->where('province_c',679)->where('ops_status',1)->count();
        }else{
            $Aklan         =0;
            $Antique       =0;
            $Capiz         =0;
            $Iloilo        =0;
            $Negros_Occidental  =0;
            $Guimaras      =0;

        }

        //Region 7
        if(Auth::user()->region_c==7 || Auth::user()->region_c==0){
            $Bohol         =DB::table('preops_area')->where('province_c',712)->where('ops_status',1)->count();
            $Cebu          =DB::table('preops_area')->where('province_c',722)->where('ops_status',1)->count();
            $Negros_Oriental  =DB::table('preops_area')->where('province_c',746)->where('ops_status',1)->count();
            $Siquijor      =DB::table('preops_area')->where('province_c',761)->where('ops_status',1)->count();
        }else{
            $Bohol         =0;
            $Cebu          =0;
            $Negros_Oriental  =0;
            $Siquijor      =0;
        }

        //Region 8
        if(Auth::user()->region_c==8 || Auth::user()->region_c==0){
            $Eastern_Samar =DB::table('preops_area')->where('province_c',826)->where('ops_status',1)->count();
            $Leyte         =DB::table('preops_area')->where('province_c',837)->where('ops_status',1)->count();
            $Northern_Samar=DB::table('preops_area')->where('province_c',848)->where('ops_status',1)->count();
            $Samar         =DB::table('preops_area')->where('province_c',860)->where('ops_status',1)->count();
            $Southern_Leyte =DB::table('preops_area')->where('province_c',864)->where('ops_status',1)->count();
            $Biliran       =DB::table('preops_area')->where('province_c',878)->where('ops_status',1)->count();
        }else{
            $Eastern_Samar =0;
            $Leyte         =0;
            $Northern_Samar=0;
            $Samar         =0;
            $Southern_Leyte =0;
            $Biliran       =0;
        }

        //Region 9
        if(Auth::user()->region_c==9 || Auth::user()->region_c==0){
            $Zamboanga_del_Norte =DB::table('preops_area')->where('province_c',972)->where('ops_status',1)->count();
            $Zamboanga_del_Sur =DB::table('preops_area')->where('province_c',973)->where('ops_status',1)->count();
            $Zamboanga_Sibugay =DB::table('preops_area')->where('province_c',983)->where('ops_status',1)->count();

        }else{
             
            $Zamboanga_del_Norte =0;
            $Zamboanga_del_Sur =0;
            $Zamboanga_Sibugay =0;
        }

        //Region 10
        if(Auth::user()->region_c==10 || Auth::user()->region_c==0){
            $Bukidnon      =DB::table('preops_area')->where('province_c',1013)->where('ops_status',1)->count();
            $Camiguin      =DB::table('preops_area')->where('province_c',1018)->where('ops_status',1)->count();
            $Lanao_del_Norte =DB::table('preops_area')->where('province_c',1035)->where('ops_status',1)->count();
            $Misamis_Occidental =DB::table('preops_area')->where('province_c',1042)->where('ops_status',1)->count();
            $Misamis_Oriental  =DB::table('preops_area')->where('province_c',1043)->where('ops_status',1)->count();
        }else{
            $Bukidnon      =0;
            $Camiguin      =0;
            $Lanao_del_Norte =0;
            $Misamis_Occidental =0;
            $Misamis_Oriental  =0;
        }

        //Region 11
        if(Auth::user()->region_c==11 || Auth::user()->region_c==0){
            $Davao_del_Norte   =DB::table('preops_area')->where('province_c',1123)->where('ops_status',1)->count();
            $Davao_del_Sur     =DB::table('preops_area')->where('province_c',1124)->where('ops_status',1)->count();
            $Davao_Oriental    =DB::table('preops_area')->where('province_c',1125)->where('ops_status',1)->count();
            $Compostela_Valley  =DB::table('preops_area')->where('province_c',1182)->where('ops_status',1)->count();
            $Davao_Occidental   =DB::table('preops_area')->where('province_c',1186)->where('ops_status',1)->count();
        }else{
            $Davao_del_Norte   =0;
            $Davao_del_Sur     =0;
            $Davao_Oriental    =0;
            $Compostela_Valley  =0;
            $Davao_Occidental   =0;
        }

        //Region 12
        if(Auth::user()->region_c==12 || Auth::user()->region_c==0){
            $North_Cotabato  =DB::table('preops_area')->where('province_c',1247)->where('ops_status',1)->count();
            $South_Cotabato  =DB::table('preops_area')->where('province_c',1263)->where('ops_status',1)->count();
            $Sultan_Kudarat  =DB::table('preops_area')->where('province_c',1265)->where('ops_status',1)->count();
            $Sarangani       =DB::table('preops_area')->where('province_c',1280)->where('ops_status',1)->count();

        }else{
            $North_Cotabato  =0;
            $South_Cotabato  =0;
            $Sultan_Kudarat  =0;
            $Sarangani       =0;
        }

        //NCR
        if(Auth::user()->region_c==13 || Auth::user()->region_c==0){
            $Manila        =DB::table('preops_area')->where('city_c',133902)->where('ops_status',1)->count();
            $Mandaluyong   =DB::table('preops_area')->where('city_c',137401)->where('ops_status',1)->count();
            $Marikina      =DB::table('preops_area')->where('city_c',137402)->where('ops_status',1)->count();
            $Pasig         =DB::table('preops_area')->where('city_c',137403)->where('ops_status',1)->count();
            $Quezon_City   =DB::table('preops_area')->where('city_c',137404)->where('ops_status',1)->count();
            $San_Juan      =DB::table('preops_area')->where('city_c',137405)->where('ops_status',1)->count();
            $Caloocan      =DB::table('preops_area')->where('city_c',137501)->where('ops_status',1)->count();
            $Malabon       =DB::table('preops_area')->where('city_c',137502)->where('ops_status',1)->count();
            $Navotas       =DB::table('preops_area')->where('city_c',137503)->where('ops_status',1)->count();
            $Valenzuela    =DB::table('preops_area')->where('city_c',137504)->where('ops_status',1)->count();
            $Las_Pinas     =DB::table('preops_area')->where('city_c',137601)->where('ops_status',1)->count();
            $Makati        =DB::table('preops_area')->where('city_c',137602)->where('ops_status',1)->count();
            $Muntinlupa    =DB::table('preops_area')->where('city_c',137603)->where('ops_status',1)->count();
            $Paranaque     =DB::table('preops_area')->where('city_c',137604)->where('ops_status',1)->count();
            $Pasay         =DB::table('preops_area')->where('city_c',137605)->where('ops_status',1)->count();
            $Pateros       =DB::table('preops_area')->where('city_c',137606)->where('ops_status',1)->count();
            $Taguig        =DB::table('preops_area')->where('city_c',137607)->where('ops_status',1)->count();
        }else{
            $Manila        =0;
            $Mandaluyong   =0;
            $Marikina      =0;
            $Pasig         =0;
            $Quezon_City   =0;
            $San_Juan      =0;
            $Caloocan      =0;
            $Malabon       =0;
            $Navotas       =0;
            $Valenzuela    =0;
            $Las_Pinas     =0;
            $Makati        =0;
            $Muntinlupa    =0;
            $Paranaque     =0;
            $Pasay         =0;
            $Pateros       =0;
            $Taguig        =0;
        }

        //Region CAR
        if(Auth::user()->region_c==14 || Auth::user()->region_c==0){
            $Abra          =DB::table('preops_area')->where('province_c',1401)->where('ops_status',1)->count();
            $Benguet       =DB::table('preops_area')->where('province_c',1411)->where('ops_status',1)->count();
            $Ifugao        =DB::table('preops_area')->where('province_c',1427)->where('ops_status',1)->count();
            $Kalinga       =DB::table('preops_area')->where('province_c',1432)->where('ops_status',1)->count();
            $Mountain_Province =DB::table('preops_area')->where('province_c',1444)->where('ops_status',1)->count();
            $Apayao       =DB::table('preops_area')->where('province_c',1481)->where('ops_status',1)->count();
        }else{
            $Abra          =0;
            $Benguet       =0;
            $Ifugao        =0;
            $Kalinga       =0;
            $Mountain_Province =0;
            $Apayao       =0;
        }

        //Region ARMM
        if(Auth::user()->region_c==15 || Auth::user()->region_c==0){
            $Basilan       =DB::table('preops_area')->where('province_c',1507)->where('ops_status',1)->count();
            $Lanao_del_Sur  =DB::table('preops_area')->where('province_c',1536)->where('ops_status',1)->count();
            $Maguindanao    =DB::table('preops_area')->where('province_c',1538)->where('ops_status',1)->count();
            $Sulu          =DB::table('preops_area')->where('province_c',1566)->where('ops_status',1)->count();
            $Tawi_Tawi     =DB::table('preops_area')->where('province_c',1570)->where('ops_status',1)->count();
        }else{
            $Basilan       =0;
            $Lanao_del_Sur  =0;
            $Maguindanao    =0;
            $Sulu          =0;
            $Tawi_Tawi     =0;
        }

        //Region CARAGA
        if(Auth::user()->region_c==16 || Auth::user()->region_c==0){
            $Agusan_del_Norte =DB::table('preops_area')->where('province_c',1602)->where('ops_status',1)->count();
            $Agusan_del_Sur   =DB::table('preops_area')->where('province_c',1603)->where('ops_status',1)->count();
            $Surigao_del_Norte =DB::table('preops_area')->where('province_c',1667)->where('ops_status',1)->count();
            $Surigao_del_Sur   =DB::table('preops_area')->where('province_c',1668)->where('ops_status',1)->count();
            $Dinagat_Islands   =DB::table('preops_area')->where('province_c',1685)->where('ops_status',1)->count();
        }else{
            $Agusan_del_Norte =0;
            $Agusan_del_Sur   =0;
            $Surigao_del_Norte =0;
            $Surigao_del_Sur   =0;
            $Dinagat_Islands   =0;
        }
         //Region 4-b MIMAROPA
         if(Auth::user()->region_c==17 || Auth::user()->region_c==0){
            $Marinduque    =DB::table('preops_area')->where('province_c',1740)->where('ops_status',1)->count();
            $Occidental_Mindoro    =DB::table('preops_area')->where('province_c',1751)->where('ops_status',1)->count();
            $Oriental_Mindoro     =DB::table('preops_area')->where('province_c',1752)->where('ops_status',1)->count();
            $Palawan       =DB::table('preops_area')->where('province_c',1753)->where('ops_status',1)->count();
            $Romblon       =DB::table('preops_area')->where('province_c',1759)->where('ops_status',1)->count();
         }else{
            $Marinduque    =0;
            $Occidental_Mindoro    =0;
            $Oriental_Mindoro     =0;
            $Palawan       =0;
            $Romblon       =0;
         }
        
        return view('geo_mapping.geo_mapping',compact('Ilocos_Norte','Ilocos_Sur','La_Union','Pangasinan','Batanes','Cagayan','Isabela',
                    'Nueva_Vizcaya','Quirino','Bataan','Bulacan','Nueva_Ecija','Pampanga','Tarlac','Zambales',
                    'Aurora','Batangas','Cavite','Laguna','Quezon','Rizal','Albay','Camarines_Norte','Camarines_Sur','Catanduanes','Masbate','Sorsogon',
                    'Aklan','Antique','Capiz','Iloilo','Negros_Occidental','Guimaras','Bohol','Cebu','Negros_Oriental','Siquijor','Eastern_Samar','Leyte',
                    'Northern_Samar','Samar','Southern_Leyte','Biliran','Zamboanga_del_Norte','Zamboanga_del_Sur','Zamboanga_Sibugay','Bukidnon',
                    'Camiguin','Lanao_del_Norte','Misamis_Occidental','Misamis_Oriental','Davao_del_Norte','Davao_del_Sur','Davao_Oriental',
                    'Compostela_Valley','Davao_Occidental','North_Cotabato','South_Cotabato','Sultan_Kudarat','Sarangani','Abra','Benguet',
                    'Ifugao','Kalinga','Mountain_Province','Basilan','Lanao_del_Sur','Maguindanao','Sulu','Tawi_Tawi','Agusan_del_Norte','Agusan_del_Sur',
                    'Dinagat_Islands','Marinduque','Occidental_Mindoro','Oriental_Mindoro','Palawan','Romblon','Surigao_del_Norte','Surigao_del_Sur',
                    'Apayao',

                    'Manila','Mandaluyong','Marikina','Pasig','Quezon_City','San_Juan','Caloocan','Malabon','Navotas','Valenzuela','Las_Pinas',
                    'Makati','Muntinlupa','Paranaque','Pasay','Pateros','Taguig'
    
                    ) );
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
        $user_area=Auth::user()->region_c;
        $datetime_now=Carbon::now();

        if($data['area_ID']>137400){
            $the_province=DB::table('city')->where('city_c',$data['area_ID'])->pluck('province_c');
            $the_region=DB::table('province')->where('province_c',$the_province[0])->pluck('region_c');
            
            if($user_area !=0){
                if($the_region[0] != $user_area){
                    return redirect('geo_mapping')->with('warning', 'This is not your Region');
                }
            }

            $ops_details_area=DB::table('preops_area')->where('city_c',$data['area_ID'])->orderBy('created_at','DESC')->get();
            $ops_numbers=DB::table('preops_area')->where('city_c',$data['area_ID'])->pluck('preops_number');

            $ops_details=DB::table('preops_header')->where('status',1)->whereDate('operation_datetime','<=',$datetime_now)->whereDate('validity','>=',$datetime_now)->whereIn('preops_number',$ops_numbers)->get();
            $ops_count=count($ops_details);

            $the_teams=DB::table('preops_header')->where('status',1)->whereIn('preops_number',$ops_numbers)->pluck('preops_number');
            $ops_teams=DB::table('preops_team')->whereIn('preops_number',$the_teams)->get();

            if($ops_details_area->isEmpty()){
                $region=['---'];
                $province=['---'];
                $city=['---'];
                $brgy=['---'];
            }else{
                $region=DB::table('region')->where('region_c',$ops_details_area[0]->region_c)->pluck('region_m');
                $province=DB::table('province')->where('province_c',$ops_details_area[0]->province_c)->pluck('province_m');
                $city=DB::table('city')->where('city_c',$data['area_ID'])->pluck('city_m');
                $brgy=DB::table('barangay')->where('barangay_c',$ops_details_area[0]->barangay_c)->pluck('barangay_m');

                $city2=$ops_details_area[0]->city_c;
                $brgy2=$ops_details_area[0]->barangay_c;
            }
        }

        if($data['area_ID']==1){
            $the_province=DB::table('city')->where('city_c',133901)->pluck('province_c');
            $the_region=DB::table('province')->where('province_c',$the_province[0])->pluck('region_c');

            if($user_area !=0){
                if($the_region[0] != $user_area){
                    return redirect('geo_mapping')->with('warning', 'This is not your Region');
                }
            }

            $ops_details_area=DB::table('preops_area')->whereBetween('city_c',[133901,133914])->orderBy('created_at','DESC')->get();
            $ops_numbers=DB::table('preops_area')->whereBetween('city_c',[133901,133914])->pluck('preops_number');

            $ops_details=DB::table('preops_header')->where('status',1)->whereDate('operation_datetime','<=',$datetime_now)->whereDate('validity','>=',$datetime_now)->whereIn('preops_number',$ops_numbers)->get();
            $ops_count=count($ops_details);

            $the_teams=DB::table('preops_header')->where('status',1)->whereIn('preops_number',$ops_numbers)->pluck('preops_number');
            $ops_teams=DB::table('preops_team')->whereIn('preops_number',$the_teams)->get();

            if($ops_details_area->isEmpty()){
                $region=['---'];
                $province=['---'];
                $city=['---'];
                $brgy=['---'];
            }else{
                $region=DB::table('region')->where('region_c',$ops_details_area[0]->region_c)->pluck('region_m');
                $province=DB::table('province')->where('province_c',$ops_details_area[0]->province_c)->pluck('province_m');
                $city=DB::table('city')->where('city_c',$ops_details_area[0]->city_c)->pluck('city_m');
                $brgy=DB::table('barangay')->where('barangay_c',$ops_details_area[0]->barangay_c)->pluck('barangay_m');

                $city2=$ops_details_area[0]->city_c;
                $brgy2=$ops_details_area[0]->barangay_c;
            }
        }

        if($data['area_ID']<137400 && $data['area_ID']!=1){
            $the_region=DB::table('province')->where('province_c',$data['area_ID'])->pluck('region_c');
            
            if($user_area !=0){
                if($the_region[0] != $user_area){
                    return redirect('geo_mapping')->with('warning', 'This is not your Region');
                }
            }

            $ops_details_area=DB::table('preops_area')->where('province_c',$data['area_ID'])->orderBy('created_at','DESC')->get();
            $ops_numbers=DB::table('preops_area')->where('province_c',$data['area_ID'])->pluck('preops_number');

            $ops_details=DB::table('preops_header')->where('status',1)->whereDate('operation_datetime','<=',$datetime_now)->whereDate('validity','>=',$datetime_now)->whereIn('preops_number',$ops_numbers)->get();
            $ops_count=count($ops_details);

            $the_teams=DB::table('preops_header')->where('status',1)->whereIn('preops_number',$ops_numbers)->pluck('preops_number');
            $ops_teams=DB::table('preops_team')->whereIn('preops_number',$the_teams)->get();
            
            if($ops_details_area->isEmpty()){
                $region=['---'];
                $province=['---']; 
                $city=['---'];
                $brgy=['---'];
            }else{
                $region=DB::table('region')->where('region_c',$ops_details_area[0]->region_c)->pluck('region_m');
                $province=DB::table('province')->where('province_c',$ops_details_area[0]->province_c)->pluck('province_m');
                $city=DB::table('city')->where('city_c',$ops_details_area[0]->city_c)->pluck('city_m');
                $brgy=DB::table('barangay')->where('barangay_c',$ops_details_area[0]->barangay_c)->pluck('barangay_m');

                $city2=$ops_details_area[0]->city_c;
                $brgy2=$ops_details_area[0]->barangay_c;

               //dd($city,$brgy);
            }
            
        }
        $area_IDx=$data['area_ID'];


        return view('geo_mapping/geo_ops_details',compact('ops_details','ops_details_area','ops_count','area_IDx','ops_teams','region','province','city','brgy','city2','brgy2') );
    }

    public function ops_update_warning(Request $request)
    {
        $data = $request->all();

        if($data['opd_action']==1){
            DB::table('preops_header')->where('id',$data['opd_ID'])->update(
                array(
                    'warning_issuance'  =>  1,
                )
            );
        }

        if($data['opd_action']==0){
            DB::table('preops_header')->where('id',$data['opd_ID'])->update(
                array(
                    'warning_issuance'  =>  0,
                )
            );
        }

        return redirect()->back();

    }
}
