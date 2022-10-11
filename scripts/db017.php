
use Illuminate\Support\Facades\DB;
require_once __DIR__.'/scripts/progress_printer.php';


function migrateDb(){
    DB::connection('old_db')->table('db017')->orderBy('ecod_c10')->chunk(100, function($evidences) {
        foreach($evidences as $key => $evidence) {
            show_status($key + 1,count($evidences));

            if(DB::table('evidence')->where('name',$evidence->ecod_c10)->exists()) continue;

            $unit_measurement = DB::table('unit_measurement')->where('name',$evidence->um_c10)->first();
            $evidence_type = DB::table('evidence_type')->where('name',$evidence->etyp_c5)->first();
            
            $evidence_ = DB::table('evidence')->insert([
                'name' => $evidence->ecod_c10,
                'description' => $evidence->edsc_c40,
                'unit_measurement_id' => $unit_measurement->id,
                'evidence_type_id' => $evidence_type->id,
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