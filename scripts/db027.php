use Illuminate\Support\Facades\DB;
require_once __DIR__.'/scripts/progress_printer.php';


function migrateDb(){
    DB::connection('old_db')->table('db027')->orderBy('eth_c5')->chunk(100, function($ethnic_groups) {
        foreach($ethnic_groups as $key => $ethnic_group) {
            show_status($key + 1,count($ethnic_groups));

            if(DB::table('ethnic_group')->where('name',$ethnic_group->edsc_c40)->exists()) continue;

            $migrate = DB::table('ethnic_group')->insert([
                'ethnicity_code' => $ethnic_group->eth_c5,
                'name' => $ethnic_group->edsc_c40,
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
