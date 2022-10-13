
use Illuminate\Support\Facades\DB;
require_once __DIR__.'/scripts/progress_printer.php';


function migrateDb(){
    DB::connection('old_db')->table('db019')->orderBy('ldsc_c40')->chunk(100, function($laboratory_facilities) {
        foreach($laboratory_facilities as $key => $laboratory_facility) {
            show_status($key + 1,count($laboratory_facilities));

            if(DB::table('laboratory_facility')->where('name',$laboratory_facility->ldsc_c40)->exists()) continue;

            $migrate = DB::table('laboratory_facility')->insert([
                'name' => $laboratory_facility->ldsc_c40,
                'laboratory_facility_code' => $laboratory_facility->labfac,
                // default only for migration
                'created_at' => date('Y-m-d'),
                'region_c' => '000000',
                'province_c' => '000000',
                'city_c' => '000000',
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