
use Illuminate\Support\Facades\DB;
require_once __DIR__.'/scripts/progress_printer.php';


function migrateDb(){
    DB::connection('old_db')->table('db010')->orderBy('rcod_c10')->chunk(100, function($provinces) {
        foreach($provinces as $key => $province) {
            show_status($key + 1,count($provinces));

            if(DB::table('province')->where('province_c',$province->pcod_c10)->exists()) continue;

            $province = DB::table('province')->insert([
                'province_c' => $province->pcod_c10,
                'province_m' => $province->pdesc_c40,
                'region_c' => $province->rcod_c10,
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