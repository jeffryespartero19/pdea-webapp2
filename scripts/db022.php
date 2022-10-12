use Illuminate\Support\Facades\DB;
require_once __DIR__.'/scripts/progress_printer.php';


function migrateDb(){
    DB::connection('old_db')->table('db022')->orderBy('scse_c10')->chunk(100, function($spot_report_cases) {
        foreach($spot_report_cases as $key => $spot_report_case) {
            show_status($key + 1,count($spot_report_cases));
         
            $case_list =DB::table('case_list')->where('case_code',$spot_report_case->case_c5)->first();
            $first_spot_report_header = DB::table('spot_report_header')->first();

            $migrate = DB::table('spot_report_case')->insert([
                'suspect_number' => $spot_report_case->sdet_c10,
                'case_id' => $case_list ? $case_list->id : null,
                // default only for migration
                'created_at' => date('Y-m-d'),
                'spot_report_number' => $first_spot_report_header->spot_report_number,
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
