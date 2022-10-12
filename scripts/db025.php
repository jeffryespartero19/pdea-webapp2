use Illuminate\Support\Facades\DB;
require_once __DIR__.'/scripts/progress_printer.php';


function migrateDb(){
    DB::connection('old_db')->table('db025')->orderBy('cstat_c5')->chunk(100, function($civil_statuses) {
        foreach($civil_statuses as $key => $civil_status) {
            show_status($key + 1,count($civil_statuses));

            if(DB::table('civil_status')->where('name',$civil_status->cdesc_c40)->exists()) continue;

            $migrate = DB::table('civil_status')->insert([
                'name' => $civil_status->cdesc_c40,
                'civil_status_code' => $civil_status->cstat_c5,
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
