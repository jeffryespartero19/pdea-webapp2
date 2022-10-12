use Illuminate\Support\Facades\DB;
require_once __DIR__.'/scripts/progress_printer.php';


function migrateDb(){
    DB::connection('old_db')->table('db045')->orderBy('resneg_c10')->chunk(100, function($negative_reasons) {
        foreach($negative_reasons as $key => $negative_reason) {
            show_status($key + 1,count($negative_reasons));

            $migrate = DB::table('negative_reason')->insert([
                'name' => $negative_reason->resneg_c10,
                'description' => $negative_reason->resdsc_c60,
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
