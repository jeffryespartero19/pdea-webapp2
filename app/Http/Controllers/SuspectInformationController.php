<?php

namespace App\Http\Controllers;

use Auth;
use Image;
use App\Audit;
use App\SuspectInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class SuspectInformationController extends Controller
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
        $data = DB::table('suspect_information')->orderby('id', 'asc')->get();

        return view('suspect_information.suspect_information_list', compact('data'));

        // return view('suspect_information.suspect_information_list');
    }

    public function add()
    {

        $region = DB::table('region')->orderby('region_sort', 'asc')->get();
        $operating_unit = DB::table('operating_unit')->orderby('name', 'asc')->get();
        $civil_status = DB::table('civil_status')->where('active', true)->orderby('name', 'asc')->get();
        $religion = DB::table('religions')->where('active', true)->orderby('name', 'asc')->get();
        $education = DB::table('Educational_attainment')->where('status', true)->orderby('name', 'asc')->get();
        $ethnic_group = DB::table('ethnic_group')->where('status', true)->orderby('name', 'asc')->get();
        $nationality = DB::table('nationality')->where('status', true)->orderby('name', 'asc')->get();
        $suspect_classification = DB::table('suspect_classification')->where('status', true)->orderby('name', 'asc')->get();
        $identifier = DB::table('identifier')->where('status', true)->orderby('name', 'asc')->get();
        $group_affiliation = DB::table('group_affiliation')->where('status', true)->orderby('name', 'asc')->get();
        $occupation = DB::table('occupation')->where('status', true)->orderby('name', 'asc')->get();
        $operation_classification = DB::table('operation_classification')->where('status', true)->orderby('name', 'asc')->get();


        return view('suspect_information.suspect_information_add', compact('region', 'operating_unit', 'civil_status', 'religion', 'education', 'ethnic_group', 'nationality', 'suspect_classification', 'identifier', 'group_affiliation', 'occupation', 'operation_classification'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'suspect_number' => 'required',
            'lastname' => 'required',
            'firstname' => 'required',
            'middlename' => 'required',
            'alias' => 'required',
            'gender' => 'required',
            'birthdate' => 'required',
            'status' => 'required',
            'operation_classification_id' => 'required',
            'operation_date' => 'required',
            'operation_region' => 'required',
            'operating_unit_id' => 'required',
        ]);

        if ($request->hasFile('photo')) {
            $image_file = $request->photo;
            $image = Image::make($image_file);

            Response::make($image->encode('jpeg'));

            $photo = base64_encode($image);
        } else {
            $photo = null;
        }

        // dd($request->all());

        $form_data = array(
            'suspect_number' => $request->suspect_number,
            'lastname' => $request->lastname,
            'firstname' => $request->firstname,
            'middlename' => $request->middlename,
            'alias' => $request->alias,
            'gender' => $request->gender,
            'birthdate' => $request->birthdate,
            'birthplace' => $request->birthplace,
            'nationality_id' => $request->nationality_id,
            'civil_status_id' => $request->civil_status_id,
            'religion_id' => $request->religion_id,
            'educational_attainment_id' => $request->educational_attainment_id,
            'ethnic_group_id' => $request->ethnic_group_id,
            'occupation_id' => $request->occupation_id,
            'monthly_income' => $request->monthly_income,
            'region_c' => $request->region_c,
            'province_c' => $request->province_c,
            'city_c' => $request->city_c,
            'barangay_c' => $request->barangay_c,
            'street' => $request->street,
            'identifier_id' => $request->identifier_id,
            'suspect_classification_id' => $request->suspect_classification_id,
            'group_affiliation_id' => $request->group_affiliation_id,
            'drug_group' => $request->drug_group,
            'remarks' => $request->remarks,
            'status' => $request->has('status') ? true : false,
            'photo' => $photo,
            'operation_classification_id' => $request->operation_classification_id,
            'operation_date' => $request->operation_date,
            'operation_region' => $request->operation_region,
            'operating_unit_id' => $request->operating_unit_id,
        );

        DB::table('suspect_information')->insert($form_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Suspect Information Setup',
            'activity' => 'Add',
            'description' => 'Added ' . $request->name . ' on suspect information setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully added new suspect information!');
    }

    public function edit($id)
    {
        $suspect_information = DB::table('suspect_information')->where('id', $id)->get();
        $region = DB::table('region')->orderby('region_sort', 'asc')->get();
        $province = DB::table('province')->orderby('province_m', 'asc')->get();
        $city = DB::table('city')->orderby('city_m', 'asc')->get();
        $barangay = DB::table('barangay')->orderby('barangay_m', 'asc')->get();
        $operating_unit = DB::table('operating_unit')->orderby('name', 'asc')->get();
        $civil_status = DB::table('civil_status')->where('active', true)->orderby('name', 'asc')->get();
        $religion = DB::table('religions')->where('active', true)->orderby('name', 'asc')->get();
        $education = DB::table('Educational_attainment')->where('status', true)->orderby('name', 'asc')->get();
        $ethnic_group = DB::table('ethnic_group')->where('status', true)->orderby('name', 'asc')->get();
        $nationality = DB::table('nationality')->where('status', true)->orderby('name', 'asc')->get();
        $suspect_classification = DB::table('suspect_classification')->where('status', true)->orderby('name', 'asc')->get();
        $identifier = DB::table('identifier')->where('status', true)->orderby('name', 'asc')->get();
        $group_affiliation = DB::table('group_affiliation')->where('status', true)->orderby('name', 'asc')->get();
        $occupation = DB::table('occupation')->where('status', true)->orderby('name', 'asc')->get();
        $operation_classification = DB::table('operation_classification')->where('status', true)->orderby('name', 'asc')->get();

        return view('suspect_information.suspect_information_edit', compact('region', 'province', 'city', 'barangay', 'operating_unit', 'civil_status', 'religion', 'education', 'ethnic_group', 'nationality', 'suspect_classification', 'identifier', 'group_affiliation', 'occupation', 'suspect_information', 'operation_classification'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'suspect_number' => 'required',
            'lastname' => 'required',
            'firstname' => 'required',
            'middlename' => 'required',
            'alias' => 'required',
            'gender' => 'required',
            'birthdate' => 'required',
            'status' => 'required',
            'operation_classification_id' => 'required',
            'operation_date' => 'required',
            'operation_region' => 'required',
            'operating_unit_id' => 'required',
        ]);

        if ($request->hasFile('photo')) {
            $image_file = $request->photo;
            $image = Image::make($image_file);

            Response::make($image->encode('jpeg'));

            $photo = base64_encode($image);

            $pos_data = array(
                'suspect_number' => $request->suspect_number,
                'lastname' => $request->lastname,
                'firstname' => $request->firstname,
                'middlename' => $request->middlename,
                'alias' => $request->alias,
                'gender' => $request->gender,
                'birthdate' => $request->birthdate,
                'birthplace' => $request->birthplace,
                'nationality_id' => $request->nationality_id,
                'civil_status_id' => $request->civil_status_id,
                'religion_id' => $request->religion_id,
                'educational_attainment_id' => $request->educational_attainment_id,
                'ethnic_group_id' => $request->ethnic_group_id,
                'occupation_id' => $request->occupation_id,
                'monthly_income' => $request->monthly_income,
                'region_c' => $request->region_c,
                'province_c' => $request->province_c,
                'city_c' => $request->city_c,
                'barangay_c' => $request->barangay_c,
                'street' => $request->street,
                'permanent_region_c' => $request->permanent_region_c,
                'permanent_province_c' => $request->permanent_province_c,
                'permanent_city_c' => $request->permanent_city_c,
                'permanent_barangay_c' => $request->permanent_barangay_c,
                'permanent_street' => $request->permanent_street,
                'identifier_id' => $request->identifier_id,
                'suspect_classification_id' => $request->suspect_classification_id,
                'group_affiliation_id' => $request->group_affiliation_id,
                'drug_group' => $request->drug_group,
                'remarks' => $request->remarks,
                'status' => $request->has('status') ? true : false,
                'photo' => $photo,
                'operation_classification_id' => $request->operation_classification_id,
                'operation_date' => $request->operation_date,
                'operation_region' => $request->operation_region,
                'operating_unit_id' => $request->operating_unit_id,
            );
        } else {
            $pos_data = array(
                'suspect_number' => $request->suspect_number,
                'lastname' => $request->lastname,
                'firstname' => $request->firstname,
                'middlename' => $request->middlename,
                'alias' => $request->alias,
                'gender' => $request->gender,
                'birthdate' => $request->birthdate,
                'birthplace' => $request->birthplace,
                'nationality_id' => $request->nationality_id,
                'civil_status_id' => $request->civil_status_id,
                'religion_id' => $request->religion_id,
                'educational_attainment_id' => $request->educational_attainment_id,
                'ethnic_group_id' => $request->ethnic_group_id,
                'occupation_id' => $request->occupation_id,
                'monthly_income' => $request->monthly_income,
                'region_c' => $request->region_c,
                'province_c' => $request->province_c,
                'city_c' => $request->city_c,
                'barangay_c' => $request->barangay_c,
                'street' => $request->street,
                'permanent_region_c' => $request->permanent_region_c,
                'permanent_province_c' => $request->permanent_province_c,
                'permanent_city_c' => $request->permanent_city_c,
                'permanent_barangay_c' => $request->permanent_barangay_c,
                'permanent_street' => $request->permanent_street,
                'identifier_id' => $request->identifier_id,
                'suspect_classification_id' => $request->suspect_classification_id,
                'group_affiliation_id' => $request->group_affiliation_id,
                'drug_group' => $request->drug_group,
                'remarks' => $request->remarks,
                'status' => $request->has('status') ? true : false,
                'operation_classification_id' => $request->operation_classification_id,
                'operation_date' => $request->operation_date,
                'operation_region' => $request->operation_region,
                'operating_unit_id' => $request->operating_unit_id,
            );
        }

        DB::table('suspect_information')->where('id', $id)->update($pos_data);

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Sudpect Classification Setup',
            'activity' => 'Update',
            'description' => 'Updated ' . $request->name . ' on suspect information setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully updated suspect information!');
    }
}
