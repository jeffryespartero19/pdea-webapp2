<?php
  
namespace App\Exports;

use Illuminate\Http\Request;
use DB; use Auth; use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

use App\Region; use App\Province; use App\Cities;
use App\Keywords_List; use App\Agency; use App\Office; use App\Attendance;
  
use App\PoliSys;use App\CJS; use App\CJE;use App\CPO; use App\CPPNP; use App\MIS;
use Carbon\Carbon;

class Xporter implements FromView
{
    private $filter1b;


    public function __construct($filter1b)
    {
         $this->filter1b = $filter1b;

    }

    

    public function registerEvents(): array
    {
        
            return [
                AfterSheet::class    => function(AfterSheet $event) {
                    $cellRange = '1:10000'; 
                    $event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setWrapText(true);
                   
                },
            ];
        
   

    }

    public function view(): View
    {
        ///Data_Geomapping
        $area_ID=$this->filter1b;

        $user_area=Auth::user()->regional_office_id;
        $datetime_now=Carbon::now();
        $city2='';
        $brgy2='';
        $Title_Loc=$area_ID;

        if($area_ID>137400){
            $the_province=DB::table('city')->where('city_c',$area_ID)->pluck('province_c');
            $the_region=DB::table('province')->where('province_c',$the_province[0])->pluck('region_c');
            
            if($the_region[0]=="0000000001"){
                $X_Region=1;
            }
            if($the_region[0]=="0000000002"){
                $X_Region=2;
            }
            if($the_region[0]=="0000000003"){
                $X_Region=3;
            }
            if($the_region[0]=="0000000004"){
                $X_Region=4;
            }
            if($the_region[0]=="0000000005"){
                $X_Region=6;
            }
            if($the_region[0]=="0000000006"){
                $X_Region=7;
            }
            if($the_region[0]=="0000000007"){
                $X_Region=8;
            }
            if($the_region[0]=="0000000008"){
                $X_Region=9;
            }
            if($the_region[0]=="0000000009"){
                $X_Region=10;
            }
            if($the_region[0]=="0000000010"){
                $X_Region=11;
            }
            if($the_region[0]=="0000000011"){
                $X_Region=12;
            }
            if($the_region[0]=="0000000012"){
                $X_Region=13;
            }
            if($the_region[0]=="0000000013"){
                $X_Region=17;
            }
            if($the_region[0]=="0000000014"){
                $X_Region=16;
            }
            if($the_region[0]=="0000000015"){
                $X_Region=15;
            }
            if($the_region[0]=="0000000016"){
                $X_Region=14;
            }
            if($the_region[0]=="0000000017"){
                $X_Region=5;
            }
            if($the_region[0]=="0000000018"){
                $X_Region=19;
            }
            
            if($user_area !=18 && $user_area !=19){
                if($X_Region != $user_area){
                    return redirect('geo_mapping')->with('warning', 'This is not your Region');
                }
            }

            $ops_details_area=DB::table('preops_area')->where('city_c',$area_ID)->orderBy('created_at','DESC')->get();
            $ops_numbers=DB::table('preops_area')->where('city_c',$area_ID)->pluck('preops_number');

            $ops_details=DB::table('preops_header')->where('status',1)->where('operation_datetime','<=',$datetime_now)->where('validity','>=',$datetime_now)->whereIn('preops_number',$ops_numbers)->get();
            $ops_count=count($ops_details);
            $ops_numbers2=$ops_details->pluck('preops_number');
            $ops_details_area2=DB::table('preops_area')->whereIn('preops_number',$ops_numbers2)->get();

            $the_teams=DB::table('preops_header')->where('status',1)->whereIn('preops_number',$ops_numbers2)->pluck('preops_number');
            $ops_teams=DB::table('preops_team')->whereIn('preops_number',$the_teams)->get();

            
            $region=[]; $regionB=[];
            $province=[];  $provinceB=[]; 
            $city=[]; $cityB=[];
            $brgy=[]; $brgyB=[];

            $city2=[]; $city2B=[];
            $brgy2=[]; $brgy2B=[];

            //////////////////////////
            $ops_details2=DB::table('preops_header')->where('operation_datetime','>',$datetime_now)->whereIn('preops_number',$ops_numbers)->get();
            $ops_numbers3=$ops_details2->pluck('preops_number');
            $ops_details_area3=DB::table('preops_area')->whereIn('preops_number',$ops_numbers3)->get();

            $the_teams2=DB::table('preops_header')->where('status',1)->whereIn('preops_number',$ops_numbers3)->pluck('preops_number');
            $ops_teams2=DB::table('preops_team')->whereIn('preops_number',$the_teams2)->get();

            if($ops_details_area->isEmpty()){
                $region=['---'];
                $province=['---'];
                $city=['---'];
                $brgy=['---'];
            }else{
                foreach($ops_details as $key => $opd){

                    $regionX=DB::table('region')->where('region_c',$ops_details_area2[$key]->region_c)->pluck('region_m');
                    array_push($region, $regionX[0]);
                    $provinceX=DB::table('province')->where('province_c',$ops_details_area2[$key]->province_c)->pluck('province_m');
                    array_push($province, $provinceX[0]);
                    $cityX=DB::table('city')->where('city_c',$ops_details_area2[$key]->city_c)->pluck('city_m');
                    array_push($city, $cityX[0]);
                    $brgyX=DB::table('barangay')->where('barangay_c',$ops_details_area2[$key]->barangay_c)->pluck('barangay_m');
                    if($ops_details_area2[$key]->barangay_c){
                        array_push($brgy, $brgyX[0]);
                    }else{
                        array_push($brgy, "---");
                    }
    
                    $cityX2=$ops_details_area2[$key]->city_c;
                    array_push($city2, $cityX2);
                    $brgyX2=$ops_details_area2[$key]->barangay_c;
                    array_push($brgy2, $brgyX2);
                }
                foreach($ops_details2 as $key => $opd2){

                    $regionXB=DB::table('region')->where('region_c',$ops_details_area3[$key]->region_c)->pluck('region_m');
                    array_push($regionB, $regionXB[0]);
                    $provinceXB=DB::table('province')->where('province_c',$ops_details_area3[$key]->province_c)->pluck('province_m');
                    array_push($provinceB, $provinceXB[0]);
                    $cityXB=DB::table('city')->where('city_c',$ops_details_area3[$key]->city_c)->pluck('city_m');
                    array_push($cityB, $cityXB[0]);
                    $brgyXB=DB::table('barangay')->where('barangay_c',$ops_details_area3[$key]->barangay_c)->pluck('barangay_m');
                    if($ops_details_area3[$key]->barangay_c){
                        array_push($brgy, $brgyXB[0]);
                    }else{
                        array_push($brgy, "---");
                    }
    
                    $cityX2B=$ops_details_area3[$key]->city_c;
                    array_push($city2B, $cityX2B);
                    $brgyX2B=$ops_details_area3[$key]->barangay_c;
                    array_push($brgy2B, $brgyX2B);
                }
                
            }
        }

        if($area_ID==1){
            $the_province=DB::table('city')->where('city_c',133901)->pluck('province_c');
            $the_region=DB::table('province')->where('province_c',$the_province[0])->pluck('region_c');

            if($the_region[0]=="0000000001"){
                $X_Region=1;
            }
            if($the_region[0]=="0000000002"){
                $X_Region=2;
            }
            if($the_region[0]=="0000000003"){
                $X_Region=3;
            }
            if($the_region[0]=="0000000004"){
                $X_Region=4;
            }
            if($the_region[0]=="0000000005"){
                $X_Region=6;
            }
            if($the_region[0]=="0000000006"){
                $X_Region=7;
            }
            if($the_region[0]=="0000000007"){
                $X_Region=8;
            }
            if($the_region[0]=="0000000008"){
                $X_Region=9;
            }
            if($the_region[0]=="0000000009"){
                $X_Region=10;
            }
            if($the_region[0]=="0000000010"){
                $X_Region=11;
            }
            if($the_region[0]=="0000000011"){
                $X_Region=12;
            }
            if($the_region[0]=="0000000012"){
                $X_Region=13;
            }
            if($the_region[0]=="0000000013"){
                $X_Region=17;
            }
            if($the_region[0]=="0000000014"){
                $X_Region=16;
            }
            if($the_region[0]=="0000000015"){
                $X_Region=15;
            }
            if($the_region[0]=="0000000016"){
                $X_Region=14;
            }
            if($the_region[0]=="0000000017"){
                $X_Region=5;
            }
            if($the_region[0]=="0000000018"){
                $X_Region=19;
            }
            
            if($user_area !=18 && $user_area !=19){
                if($X_Region != $user_area){
                    return redirect('geo_mapping')->with('warning', 'This is not your Region');
                }
            }

            $ops_details_area=DB::table('preops_area')->whereBetween('city_c',[133901,133914])->orderBy('created_at','DESC')->get();
            $ops_numbers=DB::table('preops_area')->whereBetween('city_c',[133901,133914])->pluck('preops_number');

            $ops_details=DB::table('preops_header')->where('status',1)->where('operation_datetime','<=',$datetime_now)->where('validity','>=',$datetime_now)->whereIn('preops_number',$ops_numbers)->get();
            $ops_count=count($ops_details);
            $ops_numbers2=$ops_details->pluck('preops_number');
            $ops_details_area2=DB::table('preops_area')->whereIn('preops_number',$ops_numbers2)->get();

            $the_teams=DB::table('preops_header')->where('status',1)->whereIn('preops_number',$ops_numbers2)->pluck('preops_number');
            $ops_teams=DB::table('preops_team')->whereIn('preops_number',$the_teams)->get();

            
            $region=[]; $regionB=[];
            $province=[];  $provinceB=[]; 
            $city=[]; $cityB=[];
            $brgy=[]; $brgyB=[];

            $city2=[]; $city2B=[];
            $brgy2=[]; $brgy2B=[];

            //////////////////////////
            $ops_details2=DB::table('preops_header')->where('operation_datetime','>',$datetime_now)->whereIn('preops_number',$ops_numbers)->get();
            $ops_numbers3=$ops_details2->pluck('preops_number');
            $ops_details_area3=DB::table('preops_area')->whereIn('preops_number',$ops_numbers3)->get();

            $the_teams2=DB::table('preops_header')->where('status',1)->whereIn('preops_number',$ops_numbers3)->pluck('preops_number');
            $ops_teams2=DB::table('preops_team')->whereIn('preops_number',$the_teams2)->get();

            if($ops_details_area->isEmpty()){
                $region=['---'];
                $province=['---'];
                $city=['---'];
                $brgy=['---'];
            }else{
                foreach($ops_details as $key => $opd){

                    $regionX=DB::table('region')->where('region_c',$ops_details_area2[$key]->region_c)->pluck('region_m');
                    array_push($region, $regionX[0]);
                    $provinceX=DB::table('province')->where('province_c',$ops_details_area2[$key]->province_c)->pluck('province_m');
                    array_push($province, $provinceX[0]);
                    $cityX=DB::table('city')->where('city_c',$ops_details_area2[$key]->city_c)->pluck('city_m');
                    array_push($city, $cityX[0]);
                    $brgyX=DB::table('barangay')->where('barangay_c',$ops_details_area2[$key]->barangay_c)->pluck('barangay_m');
                    if($ops_details_area2[$key]->barangay_c){
                        array_push($brgy, $brgyX[0]);
                    }else{
                        array_push($brgy, "---");
                    }
    
                    $cityX2=$ops_details_area2[$key]->city_c;
                    array_push($city2, $cityX2);
                    $brgyX2=$ops_details_area2[$key]->barangay_c;
                    array_push($brgy2, $brgyX2);
                }
                foreach($ops_details2 as $key => $opd2){

                    $regionXB=DB::table('region')->where('region_c',$ops_details_area3[$key]->region_c)->pluck('region_m');
                    array_push($regionB, $regionXB[0]);
                    $provinceXB=DB::table('province')->where('province_c',$ops_details_area3[$key]->province_c)->pluck('province_m');
                    array_push($provinceB, $provinceXB[0]);
                    $cityXB=DB::table('city')->where('city_c',$ops_details_area3[$key]->city_c)->pluck('city_m');
                    array_push($cityB, $cityXB[0]);
                    $brgyXB=DB::table('barangay')->where('barangay_c',$ops_details_area3[$key]->barangay_c)->pluck('barangay_m');
                    if($ops_details_area3[$key]->barangay_c){
                        array_push($brgy, $brgyXB[0]);
                    }else{
                        array_push($brgy, "---");
                    }
    
                    $cityX2B=$ops_details_area3[$key]->city_c;
                    array_push($city2B, $cityX2B);
                    $brgyX2B=$ops_details_area3[$key]->barangay_c;
                    array_push($brgy2B, $brgyX2B);
                }
            }
        }

        if($area_ID<137400 && $area_ID!=1){
            $the_region=DB::table('province')->where('province_c',$area_ID)->pluck('region_c');
            
            if($the_region[0]=="0000000001"){
                $X_Region=1;
            }
            if($the_region[0]=="0000000002"){
                $X_Region=2;
            }
            if($the_region[0]=="0000000003"){
                $X_Region=3;
            }
            if($the_region[0]=="0000000004"){
                $X_Region=4;
            }
            if($the_region[0]=="0000000005"){
                $X_Region=6;
            }
            if($the_region[0]=="0000000006"){
                $X_Region=7;
            }
            if($the_region[0]=="0000000007"){
                $X_Region=8;
            }
            if($the_region[0]=="0000000008"){
                $X_Region=9;
            }
            if($the_region[0]=="0000000009"){
                $X_Region=10;
            }
            if($the_region[0]=="0000000010"){
                $X_Region=11;
            }
            if($the_region[0]=="0000000011"){
                $X_Region=12;
            }
            if($the_region[0]=="0000000012"){
                $X_Region=13;
            }
            if($the_region[0]=="0000000013"){
                $X_Region=17;
            }
            if($the_region[0]=="0000000014"){
                $X_Region=16;
            }
            if($the_region[0]=="0000000015"){
                $X_Region=15;
            }
            if($the_region[0]=="0000000016"){
                $X_Region=14;
            }
            if($the_region[0]=="0000000017"){
                $X_Region=5;
            }
            if($the_region[0]=="0000000018"){
                $X_Region=19;
            }
            
            if($user_area !=18 && $user_area !=19){
                if($X_Region != $user_area){
                    return redirect('geo_mapping')->with('warning', 'This is not your Region');
                }
            }

            $ops_details_area=DB::table('preops_area')->where('province_c',$area_ID)->orderBy('created_at','DESC')->get();
            $ops_numbers=DB::table('preops_area')->where('province_c',$area_ID)->pluck('preops_number');

            $ops_details=DB::table('preops_header')->where('status',1)->where('operation_datetime','<=',$datetime_now)->where('validity','>=',$datetime_now)->whereIn('preops_number',$ops_numbers)->get();
            $ops_count=count($ops_details);

            $ops_numbers2=$ops_details->pluck('preops_number');
            $ops_details_area2=DB::table('preops_area')->whereIn('preops_number',$ops_numbers2)->get();

            $the_teams=DB::table('preops_header')->where('status',1)->whereIn('preops_number',$ops_numbers2)->pluck('preops_number');
            $ops_teams=DB::table('preops_team')->whereIn('preops_number',$the_teams)->get();

            
            $region=[]; $regionB=[];
            $province=[];  $provinceB=[]; 
            $city=[]; $cityB=[];
            $brgy=[]; $brgyB=[];

            $city2=[]; $city2B=[];
            $brgy2=[]; $brgy2B=[];

            //////////////////////////
            $ops_details2=DB::table('preops_header')->where('operation_datetime','>',$datetime_now)->whereIn('preops_number',$ops_numbers)->get();
            $ops_numbers3=$ops_details2->pluck('preops_number');
            $ops_details_area3=DB::table('preops_area')->whereIn('preops_number',$ops_numbers3)->get();

            $the_teams2=DB::table('preops_header')->where('status',1)->whereIn('preops_number',$ops_numbers3)->pluck('preops_number');
            $ops_teams2=DB::table('preops_team')->whereIn('preops_number',$the_teams2)->get();
            //dd($ops_details_area2);

            if($ops_details_area->isEmpty()){
                $region=['---'];
                $province=['---']; 
                $city=['---'];
                $brgy=['---'];
            }else{
                foreach($ops_details as $key => $opd){

                    $regionX=DB::table('region')->where('region_c',$ops_details_area2[$key]->region_c)->pluck('region_m');
                    array_push($region, $regionX[0]);
                    $provinceX=DB::table('province')->where('province_c',$ops_details_area2[$key]->province_c)->pluck('province_m');
                    array_push($province, $provinceX[0]);
                    $cityX=DB::table('city')->where('city_c',$ops_details_area2[$key]->city_c)->pluck('city_m');
                    array_push($city, $cityX[0]);
                    $brgyX=DB::table('barangay')->where('barangay_c',$ops_details_area2[$key]->barangay_c)->pluck('barangay_m');
                    if($ops_details_area2[$key]->barangay_c){
                        array_push($brgy, $brgyX[0]);
                    }else{
                        array_push($brgy, "---");
                    }
    
                    $cityX2=$ops_details_area2[$key]->city_c;
                    array_push($city2, $cityX2);
                    $brgyX2=$ops_details_area2[$key]->barangay_c;
                    array_push($brgy2, $brgyX2);
                }
                foreach($ops_details2 as $key => $opd2){

                    $regionXB=DB::table('region')->where('region_c',$ops_details_area3[$key]->region_c)->pluck('region_m');
                    array_push($regionB, $regionXB[0]);
                    $provinceXB=DB::table('province')->where('province_c',$ops_details_area3[$key]->province_c)->pluck('province_m');
                    array_push($provinceB, $provinceXB[0]);
                    $cityXB=DB::table('city')->where('city_c',$ops_details_area3[$key]->city_c)->pluck('city_m');
                    array_push($cityB, $cityXB[0]);
                    $brgyXB=DB::table('barangay')->where('barangay_c',$ops_details_area3[$key]->barangay_c)->pluck('barangay_m');
                    if($ops_details_area3[$key]->barangay_c){
                        array_push($brgy, $brgyXB[0]);
                    }else{
                        array_push($brgy, "---");
                    }
    
                    $cityX2B=$ops_details_area3[$key]->city_c;
                    array_push($city2B, $cityX2B);
                    $brgyX2B=$ops_details_area3[$key]->barangay_c;
                    array_push($brgy2B, $brgyX2B);
                }
               
            }
            
        }
        $area_IDx=$area_ID;


        return view('xports.ops_data_tableX',compact('ops_details','ops_details_area','ops_count','area_IDx','ops_teams','ops_teams2',
                    'region','province','city','brgy','city2','brgy2','Title_Loc','ops_details2','regionB','provinceB','cityB','brgyB','city2B','brgy2B') );


    }
}