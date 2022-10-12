use Illuminate\Support\Facades\DB;
require_once __DIR__.'/scripts/progress_printer.php';


function migrateDb(){
    DB::connection('old_db')->table('db035')->orderBy('preops_c10')->chunk(100, function($preops_headers) {
        foreach($preops_headers as $key => $preops_header) {
            show_status($key + 1,count($preops_headers));

            if(DB::table('preops_header')->where('preops_number',$preops_header->pops_c20)->exists()) continue;

            $operating_unit = DB::table('operating_unit')->where('operating_unit_code',$preops_header->opu_c10)->first();
            $operation_type = DB::table('operation_type')->where('operation_type_code',$preops_header->optyp_c5)->first();

            $migrate = DB::table('preops_header')->insert([
                'coc_serial_number' => $preops_header->preops_c10,
                'preops_number' => $preops_header->pops_c20,
                'region_c' => $preops_header->rcod_c10,
                'operating_unit_id' => $operating_unit ? $operating_unit->id : 0,
                'operation_type_id' => $operation_type ? $operation_type->id : 0,
                'coordinated_datetime' => $preops_header->sysdt_dt,
                'duration' => $preops_header->dur_n5,
                'operation_datetime' => $preops_header->fd_dt.' '.substr_replace($preops_header->sh_c4, ":", 2, 0),
                'validity' => $preops_header->td_dt.' '.substr_replace($preops_header->eh_c4, ":", 2, 0),
                'remarks' => $preops_header->rem_m,
                'with_aor' => $preops_header->aor_c1 ?? 0,
                'with_sr' => $preops_header->spot_c1 ?? 0,

                // default only for migration
                'ro_code' => '10001',
                'province_c' => '00000',
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
