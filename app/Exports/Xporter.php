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

        if($area_ID>137400){
            $ops_details_area=DB::table('preops_area')->where('city_c',$area_ID)->orderBy('created_at','DESC')->get();
            $ops_numbers=DB::table('preops_area')->where('city_c',$area_ID)->pluck('preops_number');

            $ops_details=DB::table('preops_header')->where('status',1)->whereIn('preops_number',$ops_numbers)->get();
            $ops_count=count($ops_details);

            $the_teams=DB::table('preops_header')->where('status',1)->whereIn('preops_number',$ops_numbers)->pluck('operating_unit_id');
            $ops_teams=DB::table('preops_team')->whereIn('id',$the_teams)->get();

            if($ops_details_area->isEmpty()){
                $region=['---'];
                $province=['---'];
                $city=['---'];
                $brgy=['---'];
            }else{
                $region=DB::table('region')->where('region_c',$ops_details_area[0]->region_c)->pluck('region_m');
                $province=DB::table('province')->where('province_c',$ops_details_area[0]->province_c)->pluck('province_m');
                $city=DB::table('city')->where('city_c',$area_ID)->pluck('city_m');
                $brgy=DB::table('barangay')->where('barangay_c',$ops_details_area[0]->barangay_c)->pluck('barangay_m');
            }

            
        }

        if($area_ID==1){
            $ops_details_area=DB::table('preops_area')->whereBetween('city_c',[133901,133914])->orderBy('created_at','DESC')->get();
            $ops_numbers=DB::table('preops_area')->whereBetween('city_c',[133901,133914])->pluck('preops_number');

            $ops_details=DB::table('preops_header')->where('status',1)->whereIn('preops_number',$ops_numbers)->get();
            $ops_count=count($ops_details);

            $the_teams=DB::table('preops_header')->where('status',1)->whereIn('preops_number',$ops_numbers)->pluck('operating_unit_id');
            $ops_teams=DB::table('preops_team')->whereIn('id',$the_teams)->get();

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
            }
        }

        if($area_ID<137400 && $area_ID!=1){
            $ops_details_area=DB::table('preops_area')->where('province_c',$area_ID)->orderBy('created_at','DESC')->get();
            $ops_numbers=DB::table('preops_area')->where('province_c',$area_ID)->pluck('preops_number');

            $ops_details=DB::table('preops_header')->where('status',1)->whereIn('preops_number',$ops_numbers)->get();
            $ops_count=count($ops_details);

            $the_teams=DB::table('preops_header')->where('status',1)->whereIn('preops_number',$ops_numbers)->pluck('operating_unit_id');
            $ops_teams=DB::table('preops_team')->whereIn('id',$the_teams)->get();

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
            }
        }

        
            return view('xports.ops_data_tableX',compact('ops_details','ops_details_area','ops_count','ops_teams','region','province','city','brgy') );


    }
}