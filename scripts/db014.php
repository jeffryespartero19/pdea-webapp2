use Illuminate\Support\Facades\DB;
require_once __DIR__.'/scripts/progress_printer.php';


function migrateDb(){
    DB::connection('old_db')->table('db014')->orderBy('aono_c10')->chunk(100, function($spot_report_teams) {
        foreach($spot_report_teams as $key => $spot_report_team) {
            show_status($key + 1,count($spot_report_teams));
            
            $migrate = DB::table('spot_report_team')->insert([
                'spot_report_number' => $spot_report_team->spotno_c15,
                'officer_name' => $spot_report_team->offno_c40,
                'officer_position' => $spot_report_team->post_c1,
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
