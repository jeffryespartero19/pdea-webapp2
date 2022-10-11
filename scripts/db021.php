
use Illuminate\Support\Facades\DB;
require_once __DIR__.'/scripts/progress_printer.php';


function migrateDb(){
    DB::connection('old_db')->table('db021')->orderBy('pakdsc_c40')->chunk(100, function($packagings) {
        foreach($packagings as $key => $packaging) {
            show_status($key + 1,count($packagings));

            if(DB::table('packaging')->where('name',$packaging->pakdsc_c40)->exists()) continue;

            $packaging = DB::table('packaging')->insert([
                'name' => $packaging->pakdsc_c40,
                'packing_type_code' => $packaging->pactyp_c5,
                // default only for migration
                'created_at' => date('Y-m-d'),
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
?>