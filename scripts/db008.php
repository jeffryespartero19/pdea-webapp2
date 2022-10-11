
use Illuminate\Support\Facades\DB;
require_once __DIR__.'/scripts/progress_printer.php';


function migrateDb(){
    DB::connection('old_db')->table('db008')->orderBy('ccod_c10')->chunk(100, function($barangays) {
        foreach($barangays as $key => $barangay) {
            show_status($key + 1,count($barangays));

            if(DB::table('barangay')->where('barangay_c',$barangay->bcod_c10)->exists()) continue;

            $barangay = DB::table('barangay')->insert([
                'barangay_c' => $barangay->bcod_c10,
                'barangay_m' => $barangay->bdesc_c40,
                'city_c' => $barangay->ccod_c10,
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