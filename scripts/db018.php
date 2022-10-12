<?php

use Illuminate\Support\Facades\DB;
require_once __DIR__.'/scripts/progress_printer.php';


function migrateDb(){
    DB::connection('old_db')->table('db018')->orderBy('etyp_c5')->chunk(100, function($evidence_types) {
        foreach($evidence_types as $key => $evidence_typ) {
            show_status($key + 1,count($evidence_types));

            $migrate = DB::table('evidence_type')->insert([
                'name' => $evidence_typ->etyp_c5,
                'description' => $evidence_typ->edsc_c40,
                'category' => $evidence_typ->ecat_c1,
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
