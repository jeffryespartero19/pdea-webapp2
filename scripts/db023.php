use Illuminate\Support\Facades\DB;
require_once __DIR__.'/scripts/progress_printer.php';


function migrateDb(){
    DB::connection('old_db')->table('db023')->orderBy('case_c5')->chunk(100, function($case_lists) {
        foreach($case_lists as $key => $case_list) {
            show_status($key + 1,count($case_lists));
            
            $migrate = DB::table('case_list')->insert([
                'description' => $case_list->csdes_c40,
                'case_code' => $case_list->case_c5,
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
