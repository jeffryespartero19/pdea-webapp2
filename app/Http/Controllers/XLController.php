<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\Xporter;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use App\User;

class XLController extends Controller
{
    public function importExportView()
    {
       return view('import');
    }


    public function ops_details_Xport(Request $request)   {
        $data = request()->all();
        if($request->has('this_area_ID')){$filter1b =$data['this_area_ID'];}else{$filter1b =[''];}

        return Excel::download(new Xporter($filter1b), 'OPS_details.csv');
    }

}
