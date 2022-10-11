
use Illuminate\Support\Facades\DB;
require_once __DIR__.'/scripts/progress_printer.php';

function generateRandomString($length = 10) {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}

function migrateDb(){
    DB::connection('old_db')->table('db016')->orderBy('ev_c5')->chunk(100, function($spot_report_evidences) {
        foreach($spot_report_evidences as $key => $spot_report_evidence) {
            show_status($key + 1,count($spot_report_evidences));

            $laboratory_facility = DB::table('laboratory_facility')->where('laboratory_facility_code',$spot_report_evidence->labfac_c10)->first();
            $packaging =DB::table('packaging')->where('packing_type_code',$spot_report_evidence->pactyp_c5)->first();

            $spot_report_evidence = DB::table('spot_report_evidence')->insert([
                "spot_report_number" => $spot_report_evidence->spotno_c15,
                "suspect_number" => $spot_report_evidence->sus_c10,
                "quantity" => $spot_report_evidence->qty_n,
                "evidence" => $spot_report_evidence->ecod_c10,
                "lab_test_result" => $spot_report_evidence->erslt_c1,
                "chemist_report_number" => $spot_report_evidence->chrep_c40,
                "markings" => $spot_report_evidence->mark_c40,
                "packaging_id" => $spot_report_evidence->pactyp_c5 ? $packaging->id : null,
                "laboratory_facility_id" => $spot_report_evidence->labfac_c10 ? $laboratory_facility->id : 0 ,
                // default only for migration
                'created_at' => date('Y-m-d'),
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
?>