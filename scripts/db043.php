use Illuminate\Support\Facades\DB;
require_once __DIR__.'/scripts/progress_printer.php';


function migrateDb(){
    DB::connection('old_db')->table('db043')->orderBy('tod_c10')->chunk(100, function($drug_types) {
        foreach($drug_types as $key => $drug_type) {
            show_status($key + 1,count($drug_types));

            if(DB::table('drug_type')->where('name',$drug_type->tod_c10)->exists()) continue;

            $migrate = DB::table('drug_type')->insert([
                'name' => $drug_type->tod_c10,
                'description' => $drug_type->todes_c40,
                // default only for migration
                'sub_category' => '',
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
