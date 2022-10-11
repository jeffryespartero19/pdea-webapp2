
use Illuminate\Support\Facades\DB;
require_once __DIR__.'/scripts/progress_printer.php';


function migrateDb(){
    DB::connection('old_db')->table('db009')->orderBy('ccod_c10')->chunk(100, function($citys) {
        foreach($citys as $key => $city) {
            show_status($key + 1,count($citys));

            if(DB::table('city')->where('city_c',$city->ccod_c10)->exists()) continue;

            $city = DB::table('city')->insert([
                'city_c' => $city->ccod_c10,
                'city_m' => $city->cdesc_c40,
                'province_c' => $city->pcod_c10,
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