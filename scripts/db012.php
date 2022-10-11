
use Illuminate\Support\Facades\DB;
require_once __DIR__.'/scripts/progress_printer.php';

function generateRandomString($length = 10) {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}

function migrateDb(){
    DB::connection('old_db')->table('db012')->orderBy('rcod_c10')->chunk(100, function($operating_units) {
        foreach($operating_units as $key => $operating_unit) {
            show_status($key + 1,count($operating_units));

            $duplicate_check = DB::table('operating_unit')->where('name',$operating_unit->opum_c10)->orwhere('description',$operating_unit->opdsc_c40)->exists();

            $operating_unit = DB::table('operating_unit')->insert([
                'name' => $duplicate_check ? $operating_unit->opum_c10.'_dup'.generateRandomString() : $operating_unit->opum_c10,
                'operating_unit_code' => $operating_unit->opu_c10,
                'description' => $duplicate_check ? $operating_unit->opdsc_c40.'_dup'.generateRandomString() : $operating_unit->opdsc_c40,
                'region_c' => $operating_unit->rcod_c10,
                // default only for migration
                'province_c' => '00000',
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