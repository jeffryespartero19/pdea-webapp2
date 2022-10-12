
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
require_once __DIR__.'/scripts/progress_printer.php';


function migrateDb(){
    DB::connection('old_db')->table('db024')->orderBy('sus_c10')->chunk(100, function($suspects) {
        foreach($suspects as $key => $suspect) {
            show_status($key + 1,count($suspects));

            $civil_status = DB::table('civil_status')->where('civil_status_code',$suspect->scst_c5)->first();
            $nationality = DB::table('nationality')->where('nationality_code',$suspect->snat_c5)->first();
            $ethnic = DB::table('ethnic_group')->where('ethnicity_code', $suspect->seth_c5)->first();
            $religion = DB::table('religions')->where('religion_code', $suspect->srel_c5)->first();
            $education = DB::table('educational_attainment')->where('educational_attainment_code', $suspect->seduc_c5)->first();
            $occupation = DB::table('occupation')->where('occupation_code', $suspect->soccu_c5)->first();

            $migrate = DB::table('suspect_information')->insert([
                'suspect_information_code' => $suspect->sus_c10,
                'lastname' => $suspect->slast_c40,
                'firstname' => $suspect->sfirst_c40,
                'middlename' => $suspect->smid_c40,
                'birthplace' => $suspect->spob_c10,
                'birthdate' => $suspect->sdob_d == '0000-00-00' ? '1990-01-01': date($suspect->sdob_d)  ,
                'permanent_street' => $suspect->sadd_c10,
                'gender' => $suspect->sgen_c1,
                'street' => $suspect->sadd_c40,
                'alias' => $suspect->al_c40,
                'civil_status_id' => $civil_status ?  $civil_status->id : 0,
                'nationality_id' => $nationality ?  $nationality->id : 0,
                'ethnic_group_id' => $ethnic ?  $ethnic->id : 0,
                'religion_id' => $religion ?  $religion->id : 0,
                'educational_attainment_id' => $education ? $education->id : 0,
                'occupation_id' => $occupation ? $occupation->id : 0,


                // default only for migration
                'operation_region' => 0,
                'operating_unit_id' => DB::table('operating_unit')->first()->id ?? 0
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
