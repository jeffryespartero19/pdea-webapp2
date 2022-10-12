use Illuminate\Support\Facades\DB;
require_once __DIR__.'/scripts/progress_printer.php';


function migrateDb(){
    DB::connection('old_db')->table('db032')->orderBy('optyp_c5')->chunk(100, function($operation_types) {
        foreach($operation_types as $key => $operation_type) {
            show_status($key + 1,count($operation_types));

            if(DB::table('operation_type')->where('name',$operation_type->opdsc_c40)->exists()) continue;

            $migrate = DB::table('operation_type')->insert([
                'operation_type_code' => $operation_type->optyp_c5,
                'name' => $operation_type->opdsc_c40,

                // default only for migration
                'operation_classification_id' => 1,
                'operation_category_id' => 1
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
