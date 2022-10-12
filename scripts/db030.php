use Illuminate\Support\Facades\DB;
require_once __DIR__.'/scripts/progress_printer.php';


function migrateDb(){
    DB::connection('old_db')->table('db030')->orderBy('occ_c5')->chunk(100, function($occupations) {
        foreach($occupations as $key => $occupation) {
            show_status($key + 1,count($occupations));

            if(DB::table('occupation')->where('name',$occupation->odesc_c40)->exists()) continue;

            $migrate = DB::table('occupation')->insert([
                'occupation_code' => $occupation->occ_c5,
                'name' => $occupation->odesc_c40,
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
