use Illuminate\Support\Facades\DB;
require_once __DIR__.'/scripts/progress_printer.php';

function uploadAfterOperationFile($file_upload) {

    if (!file_exists(public_path("/files/uploads/after_operations/"))) {
        mkdir(public_path("/files/uploads/after_operations/"), 0777, true);
    }

    $path = public_path("/files/uploads/after_operations/");
    $filename = $file_upload->fnam_c20.'.pdf';

    file_put_contents($path.$filename, $file_upload->fcon_b);

    $after_operation_file_id = DB::table('after_operation_files')->insertGetId([
        'preops_number' => $file_upload->mser_c20,
        'filenames' => $filename,
        'created_at' => date('Y-m-d'),
    ]);

    return [
        'filename' => $filename,
        'transaction_type' => 2,
        'after_operation_file_id' => $after_operation_file_id,
    ];
}

function uploadSpotReportFile($file_upload) {
    $path = public_path("/files/uploads/spot_reports/");
    $filename = $file_upload->fnam_c20.'.pdf';

    file_put_contents($path.$filename, $file_upload->fcon_b);

    $spot_report_file_id = DB::table('spot_report_files')->insertGetId([
        'spot_report_number' => $file_upload->mser_c20,
        'filenames' => $filename,
        'created_at' => date('Y-m-d'),
    ]);

    return [
        'filename' => $filename,
        'transaction_type' => 3,
        'spot_report_file_id' => $spot_report_file_id,
    ];
}

function uploadProgressReportFile($file_upload) {
    $path = public_path("/files/uploads/progress_reports/");
    $filename = $file_upload->fnam_c20.'.pdf';

    file_put_contents($path.$filename, $file_upload->fcon_b);

    $progress_report_file_id = DB::table('progress_report_files')->insertGetId([
        'spot_report_number' => $file_upload->mser_c20,
        'filenames' => $filename,
        'created_at' => date('Y-m-d'),
    ]);

    return [
        'filename' => $filename,
        'transaction_type' => 4,
        'progress_report_file_id' => $progress_report_file_id,
    ];
}

function migrateDb(){
    DB::connection('old_db')->table('db047')->orderBy('serno_c10')->chunk(100, function($file_uploads) {
        foreach($file_uploads as $key => $file_upload) {
            show_status($key + 1,count($file_uploads));

            if($file_upload->ftyp_c2 === "01")
                $file_upload_details = uploadAfterOperationFile($file_upload);
            else if($file_upload->ftyp_c2 === "02") 
                $file_upload_details = uploadSpotReportFile($file_upload);
            else if($file_upload->ftyp_c2 === "03") 
                $file_upload_details = uploadProgressReportFile($file_upload);

            $file_upload_details['created_at'] = date('Y-m-d');
                
            $migrate = DB::table('file_upload_list')->insert($file_upload_details);

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
