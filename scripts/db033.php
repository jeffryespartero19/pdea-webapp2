use Illuminate\Support\Facades\DB;
require_once __DIR__.'/scripts/progress_printer.php';


function migrateDb(){
    DB::connection('old_db')->table('db033')->orderBy('jf_c10')->chunk(100, function($jails) {
        foreach($jails as $key => $jail_facility) {
            show_status($key + 1,count($jails));

            if(DB::table('jail_facility')->where('name',$jail_facility->jfdsc_c40)->exists()) continue;

            $migrate = DB::table('jail_facility')->insert([
                'jail_facility_code' => $jail_facility->jf_c10,
                'name' => $jail_facility->jfdsc_c40,

                // default only for migration
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
