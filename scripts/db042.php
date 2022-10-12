
use Illuminate\Support\Facades\DB;
require_once __DIR__.'/scripts/progress_printer.php';


function migrateDb(){
    DB::connection('old_db')->table('db042')->orderBy('reptyp_c1')->chunk(100, function($spot_reports) {
        foreach($spot_reports as $key => $spot_report) {
            show_status($key + 1,count($spot_reports));

            $migrate = DB::table('spot_report_header')->insert([
                'report_header' => $spot_report->rephead_c100,
                'summary' => $spot_report->repdet_m,
                'spot_report_number' => $spot_report->spotno_c15,

                // default only for migration
                'province_c' => '001',
                'region_c' => '001',
                'preops_number' => '001',
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
