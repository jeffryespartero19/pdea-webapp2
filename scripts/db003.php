
use Illuminate\Support\Facades\DB;
require_once __DIR__.'/scripts/progress_printer.php';


function migrateDb(){
    DB::connection('old_db')->table('db003')->orderBy('cs_c1')->chunk(100, function($spot_headers) {
        foreach($spot_headers as $key => $spot_header) {
            show_status($key + 1,count($spot_headers));

            $spot_report_header = DB::table('spot_report_header')->insert([
                'spot_report_number' => $spot_header->spotno_c15,
                'preops_number' => $spot_header->preops_c10 ?? '',
                'region_c' => $spot_header->rcod_c10,
                // default only for migration
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
?>