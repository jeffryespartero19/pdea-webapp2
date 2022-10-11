use Illuminate\Support\Facades\DB;
require_once __DIR__.'/scripts/progress_printer.php';


function migrateDb(){
    DB::connection('old_db')->table('db029')->orderBy('edu_c5')->chunk(100, function($educational_attainments) {
        foreach($educational_attainments as $key => $education) {
            show_status($key + 1,count($educational_attainments));

            if(DB::table('educational_attainment')->where('name',$education->edsc_c40)->exists()) continue;

            $migrate = DB::table('educational_attainment')->insert([
                'educational_attainment_code' => $education->edu_c5,
                'name' => $education->edsc_c40,
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
