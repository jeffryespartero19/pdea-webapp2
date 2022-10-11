use Illuminate\Support\Facades\DB;
require_once __DIR__.'/scripts/progress_printer.php';


function migrateDb(){
    DB::connection('old_db')->table('db028')->orderBy('rel_c5')->chunk(100, function($religions) {
        foreach($religions as $key => $religion) {
            show_status($key + 1,count($religions));

            if(DB::table('religions')->where('name',$religion->rdesc_c40)->exists()) continue;

            $migrate = DB::table('religions')->insert([
                'religion_code' => $religion->rel_c5,
                'name' => $religion->rdesc_c40,
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
