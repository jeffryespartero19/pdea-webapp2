
use Illuminate\Support\Facades\DB;
require_once __DIR__.'/scripts/progress_printer.php';


function migrateDb(){
    DB::connection('old_db')->table('db011')->orderBy('rcod_c10')->chunk(100, function($regions) {
        foreach($regions as $key => $region) {
            show_status($key + 1,count($regions));

            if(DB::table('region')->where('region_c',$region->rcod_c10)->exists()) continue;

            $region = DB::table('region')->insert([
                'region_c' => $region->rcod_c10,
                'region_m' => $region->rdesc_c40,
                'abbreviation' => $region->repd_c40,
                'status' => $region->ord_n2 ?? 0,
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