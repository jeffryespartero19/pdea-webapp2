<?php

namespace App\Http\Controllers;

use Auth;
use App\Audit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DrugVerificationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $data1 = DB::table('spot_report_suspect as a')
            ->leftjoin('spot_report_header as b', 'a.spot_report_number', '=', 'b.spot_report_number')
            ->leftjoin('drug_management as d', 'a.id', '=', 'd.suspect_id')
            ->leftjoin('region as f', 'b.region_c', '=', 'f.region_c')
            ->leftjoin('province as g', 'b.province_c', '=', 'g.province_c')
            ->leftjoin('city as h', 'b.city_c', '=', 'h.city_c')
            ->leftjoin('barangay as i', 'b.barangay_c', '=', 'i.barangay_c')
            ->leftjoin('operating_unit as j', 'b.operating_unit_id', '=', 'j.id')
            ->leftjoin('operation_type as k', 'b.operation_type_id', '=', 'k.id')
            ->leftjoin('suspect_classification as l', 'a.suspect_classification_id', '=', 'l.id')
            ->leftjoin('suspect_category as m', 'a.suspect_category_id', '=', 'm.id')
            ->leftjoin('suspect_status as n', 'a.suspect_status_id', '=', 'n.id')
            ->leftjoin('identifier as o', 'a.identifier_id', '=', 'o.id')
            ->leftjoin('suspect_sub_category as p', 'a.suspect_sub_category_id', '=', 'p.id')

            ->select(
                'a.id',
                'b.preops_number',
                'b.spot_report_number',
                'b.operation_datetime',
                'f.region_m',
                'g.province_m',
                'h.city_m',
                'i.barangay_m',
                'a.lastname',
                'a.firstname',
                'a.middlename',
                'd.ndis_id',
                'd.listed',
                'd.remarks',
                'j.name as operating_unit',
                'k.name as operation_type',
                'l.name as suspect_classification',
                'm.name as suspect_category',
                'n.name as status',
                'b.street',
                'o.name as identifier',
                'p.name as suspect_sub_category',
                'b.id as spot_id'
            )
            ->where(function ($query){
                return $query->where('b.operation_lvl', 1)
                    ->orWhere('m.hvt', 1);
            })
            // ->where('b.operation_lvl', 1)
            // ->orWhere(function ($query) {
            //     return $query->where('b.operation_lvl', 0)
            //         ->where('m.hvt', 1);
            // })
            ->orderby('a.lastname', 'asc')
            ->paginate(20);

        // $data2 = DB::table('spot_report_suspect as a')
        //     ->leftjoin('spot_report_header as b', 'a.spot_report_number', '=', 'b.spot_report_number')
        //     ->leftjoin('drug_management as d', 'a.id', '=', 'd.suspect_id')
        //     ->leftjoin('region as f', 'b.region_c', '=', 'f.region_c')
        //     ->leftjoin('province as g', 'b.province_c', '=', 'g.province_c')
        //     ->leftjoin('city as h', 'b.city_c', '=', 'h.city_c')
        //     ->leftjoin('barangay as i', 'b.barangay_c', '=', 'i.barangay_c')
        //     ->leftjoin('operating_unit as j', 'b.operating_unit_id', '=', 'j.id')
        //     ->leftjoin('operation_type as k', 'b.operation_type_id', '=', 'k.id')
        //     ->leftjoin('suspect_classification as l', 'a.suspect_classification_id', '=', 'l.id')
        //     ->leftjoin('suspect_category as m', 'a.suspect_category_id', '=', 'm.id')
        //     ->leftjoin('suspect_status as n', 'a.suspect_status_id', '=', 'n.id')
        //     ->leftjoin('identifier as o', 'a.identifier_id', '=', 'o.id')
        //     ->leftjoin('suspect_sub_category as p', 'a.suspect_sub_category_id', '=', 'p.id')

        //     ->select(
        //         'a.id',
        //         'b.preops_number',
        //         'b.spot_report_number',
        //         'b.operation_datetime',
        //         'f.region_m',
        //         'g.province_m',
        //         'h.city_m',
        //         'i.barangay_m',
        //         'a.lastname',
        //         'a.firstname',
        //         'a.middlename',
        //         'd.ndis_id',
        //         'd.listed',
        //         'd.remarks',
        //         'j.name as operating_unit',
        //         'k.name as operation_type',
        //         'l.name as suspect_classification',
        //         'm.name as suspect_category',
        //         'n.name as status',
        //         'b.street',
        //         'o.name as identifier',
        //         'p.name as suspect_sub_category',
        //     )
        //     ->where('b.operation_lvl', 0)
        //     ->where('m.hvt', 1)
        //     ->orderby('a.lastname', 'asc')
        //     ->get();

        // $data1 = $data->merge($data2)->paginate(20);
        $suspect_classification = DB::table('suspect_classification')->where('status', true)->orderby('name', 'asc')->get();
        $suspect_category = DB::table('suspect_category')->where('status', true)->orderby('name', 'asc')->get();
        $suspect_sub_category = DB::table('suspect_sub_category')->where('status', true)->orderby('name', 'asc')->get();
        $identifier = DB::table('identifier')->where('status', true)->orderby('name', 'asc')->get();


        return view('drug_verification.drug_verification_list', compact(
            'data1',
            'suspect_category',
            'suspect_sub_category',
            'suspect_classification',
            'identifier'
        ));
    }

    public function store(Request $request)
    {

        if ($request->dv_id > 0 || $request->dv_id != null) {
            $form_data = array(
                'ndis_id' => $request->ndis_id,
                'listed' => $request->listed,
                'remarks' => $request->remarks,
                'user_id' => Auth::user()->id,
            );

            DB::table('drug_management')->where('id', $request->dv_id)->update($form_data);

            $form_data2 = array(
                'suspect_classification_id' => $request->suspect_classification_id,
                'suspect_category_id' => $request->suspect_category_id,
                'suspect_sub_category_id' => $request->suspect_sub_category_id,
                'identifier_id' => $request->identifier_id,
            );

            DB::table('spot_report_suspect')->where('id', $request->suspect_id)->update($form_data2);



            //Save audit trail
            $data_audit = array(
                'user_id' => Auth::user()->id,
                'module'  => 'Drug Management',
                'menu'    => 'Drug Management Setup',
                'activity' => 'Update',
                'description' => 'Updated record on drug management setup.',
            );

            Audit::create($data_audit);

            return back()->with('success', 'You have successfully updated drug management!');
        } else {
            $form_data = array(
                'suspect_id' => $request->suspect_id,
                'ndis_id' => $request->ndis_id,
                'listed' => $request->listed,
                'remarks' => $request->remarks,
                'user_id' => Auth::user()->id,
            );

            DB::table('drug_management')->insert($form_data);

            $form_data2 = array(
                'suspect_classification_id' => $request->suspect_classification_id,
                'suspect_category_id' => $request->suspect_category_id,
                'suspect_sub_category_id' => $request->suspect_sub_category_id,
                'identifier_id' => $request->identifier_id,
            );

            DB::table('spot_report_suspect')->where('id', $request->suspect_id)->update($form_data2);

            //Save audit trail
            $data_audit = array(
                'user_id' => Auth::user()->id,
                'module'  => 'Drug Management',
                'menu'    => 'Drug Management Setup',
                'activity' => 'Add',
                'description' => 'Added record on drug management setup.',
            );

            Audit::create($data_audit);

            return back()->with('success', 'You have successfully added new drug management!');
        }
    }

    public function search_drug_verification_list(Request $request)
    {
        $param = $request->get('param');

        $data1 = DB::table('spot_report_suspect as a')
            ->leftjoin('spot_report_header as b', 'a.spot_report_number', '=', 'b.spot_report_number')
            ->leftjoin('drug_management as d', 'a.id', '=', 'd.suspect_id')
            ->leftjoin('region as f', 'b.region_c', '=', 'f.region_c')
            ->leftjoin('province as g', 'b.province_c', '=', 'g.province_c')
            ->leftjoin('city as h', 'b.city_c', '=', 'h.city_c')
            ->leftjoin('barangay as i', 'b.barangay_c', '=', 'i.barangay_c')
            ->leftjoin('operating_unit as j', 'b.operating_unit_id', '=', 'j.id')
            ->leftjoin('operation_type as k', 'b.operation_type_id', '=', 'k.id')
            ->leftjoin('suspect_classification as l', 'a.suspect_classification_id', '=', 'l.id')
            ->leftjoin('suspect_category as m', 'a.suspect_category_id', '=', 'm.id')
            ->leftjoin('suspect_status as n', 'a.suspect_status_id', '=', 'n.id')
            ->leftjoin('identifier as o', 'a.identifier_id', '=', 'o.id')
            ->leftjoin('suspect_sub_category as p', 'a.suspect_sub_category_id', '=', 'p.id')

            ->select(
                'a.id',
                'b.preops_number',
                'b.spot_report_number',
                'b.operation_datetime',
                'f.region_m',
                'g.province_m',
                'h.city_m',
                'i.barangay_m',
                'a.lastname',
                'a.firstname',
                'a.middlename',
                'd.ndis_id',
                'd.listed',
                'd.remarks',
                'j.name as operating_unit',
                'k.name as operation_type',
                'l.name as suspect_classification',
                'm.name as suspect_category',
                'n.name as status',
                'b.street',
                'o.name as identifier',
                'p.name as suspect_sub_category',
                'b.id as spot_id'
            )
            ->where(function ($query) {
                return $query->where('b.operation_lvl', 1)
                    ->orWhere('m.hvt', 1);
            })
            ->where(function ($query)  use ($param) {
                return $query->where('b.spot_report_number', 'LIKE', '%' . $param . '%')
                    ->orWhere('b.preops_number', 'LIKE', '%' . $param . '%');
            })
            ->orderby('a.lastname', 'asc')
            ->paginate(20);

        return view('drug_verification.drug_verification_list_data', compact('data1'))->render();
    }
}
