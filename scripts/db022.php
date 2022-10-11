use Illuminate\Support\Facades\DB;
require_once __DIR__.'/scripts/progress_printer.php';


function migrateDb(){
    DB::connection('old_db')->table('db022')->orderBy('scse_c10')->chunk(100, function($case_lists) {
        foreach($case_lists as $key => $case_list) {
            show_status($key + 1,count($case_lists));
         
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
