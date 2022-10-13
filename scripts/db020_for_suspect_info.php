
use Illuminate\Support\Facades\DB;
require_once __DIR__.'/scripts/progress_printer.php';


function migrateDb(){
    DB::connection('old_db')->table('db020')->orderBy('spotno_c15')->chunk(100, function($spot_report_suspects) {
        foreach($spot_report_suspects as $key => $spot_report_suspect) {
            show_status($key + 1,count($spot_report_suspects));
            
            if($spot_report_suspect->grp_c40 || $spot_report_suspect->class_c2 || $spot_report_suspect->grpaf_c1) {
                $suspect_info = DB::table('suspect_information')->where('suspect_information_code',$spot_report_suspect->sus_c10)->update([
                    'drug_group' => $spot_report_suspect->grp_c40 ?? null,
                    'suspect_classification_id' => $spot_report_suspect->class_c2 ?? null,
                    'group_affiliation_id' => $spot_report_suspect->grpaf_c1 ?? null,
                ]);
            }
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
