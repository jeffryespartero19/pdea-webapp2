use Illuminate\Support\Facades\DB;
require_once __DIR__.'/scripts/progress_printer.php';


function migrateDb(){
    DB::connection('old_db')->table('db036')->orderBy('preops_c10')->chunk(100, function($areas) {
        foreach($areas as $key => $area) {
            show_status($key + 1,count($areas));


            $migrate = DB::table('preops_area')->insert([
                'preops_number' => $area->preops_c10,
                'area' => $area->area_c10
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
