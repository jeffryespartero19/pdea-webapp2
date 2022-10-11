use Illuminate\Support\Facades\DB;
require_once __DIR__.'/scripts/progress_printer.php';


function migrateDb(){
    DB::connection('old_db')->table('db026')->orderBy('nat_c5')->chunk(100, function($nationalities) {
        foreach($nationalities as $key => $nationality) {
            show_status($key + 1,count($nationalities));

            if(DB::table('nationality')->where('name',$nationality->ndesc_c40)->exists()) continue;

            $migrate = DB::table('nationality')->insert([
                'nationality_code' => $nationality->nat_c5,
                'name' => $nationality->ndesc_c40,
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
