
use Illuminate\Support\Facades\DB;
require_once __DIR__.'/scripts/progress_printer.php';


function migrateDb(){
    DB::connection('old_db')->table('db020')->orderBy('spotno_c15')->chunk(100, function($spot_report_suspects) {
        foreach($spot_report_suspects as $key => $evidence_typ) {
            show_status($key + 1,count($spot_report_suspects));

            $migrate = DB::table('spot_report_suspect')->insert([
                'spot_report_number' => ,
                'suspect_number' => ,
                'identifier_id' => ,
                'spot_report_number' => ,
                'spot_report_number' => ,
                'spot_report_number' => ,
                'spot_report_number' => ,
                'spot_report_number' => ,
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
