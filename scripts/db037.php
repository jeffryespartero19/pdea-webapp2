use Illuminate\Support\Facades\DB;
require_once __DIR__.'/scripts/progress_printer.php';


function migrateDb(){
    DB::connection('old_db')->table('db037')->orderBy('tm_c10')->chunk(100, function($teams) {
        foreach($teams as $key => $team) {
            show_status($key + 1,count($teams));

            $migrate = DB::table('preops_team')->insert([
                'id' => $team->tm_c10,
                'preops_number' => $team->preops_c10,
                'position' => $team->post_c1,

                // default only for migration
                'name' => 'test',
                'contact' => '123123'
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
