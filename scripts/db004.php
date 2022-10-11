

use Illuminate\Support\Facades\DB;
require_once __DIR__.'/scripts/progress_printer.php';


function migrateDb(){
    DB::connection('old_db')->table('db004')->orderBy('wno_c10')->chunk(100, function($warrant_details) {
        foreach($warrant_details as $key => $warrant_detail) {
            show_status($key + 1,count($warrant_details));

            $query_find = DB::table('spot_report_header')->where('spot_report_number',$warrant_detail->spotno_c15);

            $spot_report_header = $query_find->first();

            if($spot_report_header) {
                $query_find->update([
                    'spot_report_number' => $warrant_detail->spotno_c15,
                    'warrant_number' => $warrant_detail->warno_c10,
                    'judge_name' => $warrant_detail->jdg_c20,
                ]);
            }
            else 
                $spot_report_header = DB::table('spot_report_header')->insert([
                    'spot_report_number' => $warrant_detail->spotno_c15,
                    'warrant_number' => $warrant_detail->warno_c10,
                    'judge_name' => $warrant_detail->jdg_c20,
                    
                    // default only for migration
                    'region_c' => '00000000M',
                    'preops_number' => '',
                    'province_c' => '001',
                    'operation_type_id' => 1,
                    'operating_unit_id' => 1,
                ]);
        }
    });
}


try {
    DB::beginTransaction();
        migrateDb();
    DB::commit();
} catch (\Throwable $th) {
    DB::rollBack();
    dd($th);
}