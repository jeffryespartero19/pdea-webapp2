
use Illuminate\Support\Facades\DB;
require_once __DIR__.'/scripts/progress_printer.php';


function migrateDb(){
    DB::connection('old_db')->table('db017')->orderBy('ecod_c10')->chunk(100, function($evidences) {
        foreach($evidences as $key => $evidence) {
            show_status($key + 1,count($evidences));
            
            $unit_measurement = DB::table('unit_measurement')->where('name',$evidence->um_c10)->first();
            
            if($unit_measurement == null) {
                $unit_measurement = DB::table('unit_measurement')->insert([
                    'name' => $evidence->um_c10,
                ]);
            }
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