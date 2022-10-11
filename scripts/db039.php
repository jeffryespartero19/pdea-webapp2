use Illuminate\Support\Facades\DB;
require_once __DIR__.'/scripts/progress_printer.php';


function migrateDb(){
    DB::connection('old_db')->table('db039')->orderBy('targ_c10')->chunk(100, function($preops_targets) {
        foreach($preops_targets as $key => $preops) {
            show_status($key + 1,count($preops_targets));

            $nationality = DB::table('nationality')->where('nationality_code',$preops->nat_c5)->first();

            $migrate = DB::table('preops_target')->insert([
                'id' => $preops->targ_c10,
                'preops_number' => $preops->preops_c10,
                'name' => $preops->tnme_c40,
                'nationality_id' => $nationality ? $nationality->id : 0
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
