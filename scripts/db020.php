
use Illuminate\Support\Facades\DB;
require_once __DIR__.'/scripts/progress_printer.php';


function migrateDb(){
    DB::connection('old_db')->table('db020')->orderBy('spotno_c15')->chunk(100, function($spot_report_suspects) {
        foreach($spot_report_suspects as $key => $spot_report_suspect) {
            show_status($key + 1,count($spot_report_suspects));

            $drug_type = DB::table('drug_type')->where('name',$spot_report_suspect->tod_c10)->first();

            $suspect_info = DB::table('suspect_information')->where('suspect_information_code',$spot_report_suspect->sus_c10)->update([
                'drug_group' => $spot_report_suspect->grp_c40,
                'suspect_classification_id' => $spot_report_suspect->class_c2,
                'group_affiliation_id' => $spot_report_suspect->grpaf_c1,
            ]);


            $migrate = DB::table('spot_report_suspect')->insert([
                'spot_report_number' => $spot_report_suspect->spotno_c15,
                'suspect_number' => $spot_report_suspect->sus_c10,
                'suspect_classification_id' => $spot_report_suspect->class_c2,
                'drug_test_result' => $spot_report_suspect->dtr_c1,
                'drug_type_id' => $spot_report_suspect->tod_c10 ? $drug_type->id : null,
                'remarks' => substr($spot_report_suspect->rem_m,0,250),
                'identifier_id' => $spot_report_suspect->cls_c1,
                'gender' => $suspect_info->gender ?? 'NA',
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
