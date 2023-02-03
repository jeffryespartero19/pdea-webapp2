<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['middleware' => 'auth'], function () {
    // Control Pannel Routes

    // User List
    Route::get('/list', 'UsersController@index')->name('list');
    Route::post('/list_add', 'UsersController@store')->name('list_add');
    // User List Access Rights
    Route::get('/access_rights/{id}', 'AccessRightsController@index')->name('access_rigths');
    Route::post('/access_rights/{id}', 'AccessRightsController@update_access')->name('access_rigths');
    // User Activiti List
    Route::get('/audits', 'AuditController@index')->name('audits');
    // Civil Status
    Route::get('/civil_status_list', 'CivilStatusController@index')->name('civil_status');
    Route::get('/civil_status_add', 'CivilStatusController@add')->name('civil_status_add');
    Route::get('/civil_status_edit/{id}', 'CivilStatusController@edit')->name('civil_status_edit');
    Route::post('/civil_status_add', 'CivilStatusController@store');
    Route::patch('/civil_status_edit/{id}', 'CivilStatusController@update');
    // Religion Setup
    Route::get('/religion_list', 'ReligionsController@index')->name('religions');
    Route::get('/religion_add', 'ReligionsController@add')->name('religion_add');
    Route::get('/religion_edit/{id}', 'ReligionsController@edit')->name('religion_edit');
    Route::post('/religion_add', 'ReligionsController@store');
    Route::patch('/religion_edit/{id}', 'ReligionsController@update');
    // User Level Setup
    Route::get('user_level_list', 'UserLevelController@index')->name('user_level_list');
    Route::get('user_level_add', 'UserLevelController@add')->name('user_level_add');
    Route::get('user_level_edit/{id}', 'UserLevelController@edit')->name('user_level_edit');
    Route::post('user_level_add', 'UserLevelController@store');
    Route::patch('user_level_edit/{id}', 'UserLevelController@update');
    // Case List Setup
    Route::get('case_list', 'CaseListController@index')->name('case_list');
    Route::get('case_list_add', 'CaseListController@add')->name('case_list_add');
    Route::get('case_list_edit/{id}', 'CaseListController@edit')->name('case_list_edit');
    Route::post('case_list_add', 'CaseListController@store');
    Route::patch('case_list_edit/{id}', 'CaseListController@update');
    // Suspect Classsification Setup
    Route::get('suspect_classification_list', 'SuspectClassificationController@index')->name('suspect_classification_list');
    Route::get('suspect_classification_add', 'SuspectClassificationController@add')->name('suspect_classification_add');
    Route::get('suspect_classification_edit/{id}', 'SuspectClassificationController@edit')->name('suspect_classification_edit');
    Route::post('suspect_classification_add', 'SuspectClassificationController@store');
    Route::patch('suspect_classification_edit/{id}', 'SuspectClassificationController@update');
    // Drug Type Setup
    Route::get('drug_type_list', 'DrugTypeController@index')->name('drug_type_list');
    Route::get('drug_type_add', 'DrugTypeController@add')->name('drug_type_add');
    Route::get('drug_type_edit/{id}', 'DrugTypeController@edit')->name('drug_type_edit');
    Route::post('drug_type_add', 'DrugTypeController@store');
    Route::patch('drug_type_edit/{id}', 'DrugTypeController@update');
    // Negative Reason Setup
    Route::get('negative_reason_list', 'NegativeReasonController@index')->name('negative_reason_list');
    Route::get('negative_reason_add', 'NegativeReasonController@add')->name('negative_reason_add');
    Route::get('negative_reason_edit/{id}', 'NegativeReasonController@edit')->name('negative_reason_edit');
    Route::post('negative_reason_add', 'NegativeReasonController@store');
    Route::patch('negative_reason_edit/{id}', 'NegativeReasonController@update');
    // Province Setup
    Route::get('province_list', 'ProvinceController@index')->name('province_list');
    Route::get('province_add', 'ProvinceController@add')->name('province_add');
    Route::get('province_edit/{id}', 'ProvinceController@edit')->name('province_edit');
    Route::post('province_add', 'ProvinceController@store');
    Route::patch('province_edit/{id}', 'ProvinceController@update');
    // Region Setup
    Route::get('region_list', 'RegionController@index')->name('region_list');
    Route::get('region_add', 'RegionController@add')->name('region_add');
    Route::get('region_edit/{id}', 'RegionController@edit')->name('region_edit');
    Route::post('region_add', 'RegionController@store');
    Route::patch('region_edit/{id}', 'RegionController@update');
    // City Setup
    Route::get('city_list', 'CityController@index')->name('city_list');
    Route::get('city_add', 'CityController@add')->name('city_add');
    Route::get('city_edit/{id}', 'CityController@edit')->name('city_edit');
    Route::post('city_add', 'CityController@store');
    Route::patch('city_edit/{id}', 'CityController@update');
    // Barangay Setup
    Route::get('barangay_list', 'BarangayController@index')->name('barangay_list');
    Route::get('barangay_add', 'BarangayController@add')->name('barangay_add');
    Route::get('barangay_edit/{id}', 'BarangayController@edit')->name('barangay_edit');
    Route::post('barangay_add', 'BarangayController@store');
    Route::patch('barangay_edit/{id}', 'BarangayController@update');
    // Operating Unit Setup
    Route::get('operating_unit_list', 'OperatingUnitController@index')->name('operating_unit_list');
    Route::get('operating_unit_add', 'OperatingUnitController@add')->name('operating_unit_add');
    Route::get('operating_unit_edit/{id}', 'OperatingUnitController@edit')->name('operating_unit_edit');
    Route::post('operating_unit_add', 'OperatingUnitController@store');
    Route::patch('operating_unit_edit/{id}', 'OperatingUnitController@update');
    // Operation Category Setup
    Route::get('operation_category_list', 'OperationCategoryController@index')->name('operation_category_list');
    Route::get('operation_category_add', 'OperationCategoryController@add')->name('operation_category_add');
    Route::get('operation_category_edit/{id}', 'OperationCategoryController@edit')->name('operation_category_edit');
    Route::post('operation_category_add', 'OperationCategoryController@store');
    Route::patch('operation_category_edit/{id}', 'OperationCategoryController@update');
    // Operation Type Setup
    Route::get('operation_type_list', 'OperationTypeController@index')->name('operation_type_list');
    Route::get('operation_type_add', 'OperationTypeController@add')->name('operation_type_add');
    Route::get('operation_type_edit/{id}', 'OperationTypeController@edit')->name('operation_type_edit');
    Route::post('operation_type_add', 'OperationTypeController@store');
    Route::patch('operation_type_edit/{id}', 'OperationTypeController@update');
    // Operation Classification Setup
    Route::get('operation_classification_list', 'OperationClassificationController@index')->name('operation_classification_list');
    Route::get('operation_classification_add', 'OperationClassificationController@add')->name('operation_classification_add');
    Route::get('operation_classification_edit/{id}', 'OperationClassificationController@edit')->name('operation_classification_edit');
    Route::post('operation_classification_add', 'OperationClassificationController@store');
    Route::patch('operation_classification_edit/{id}', 'OperationClassificationController@update');
    // Local Operating Unit Setup
    // Route::get('local_operating_unit_list', 'LocalOperatingUnitController@index')->name('local_operating_unit_list');
    // Route::get('local_operating_unit_add', 'LocalOperatingUnitController@add')->name('local_operating_unit_add');
    // Route::get('local_operating_unit_edit/{id}', 'LocalOperatingUnitController@edit')->name('local_operating_unit_edit');
    // Route::post('local_operating_unit_add', 'LocalOperatingUnitController@store');
    // Route::patch('local_operating_unit_edit/{id}', 'LocalOperatingUnitController@update');
    // Educational Attainment Setup
    Route::get('educational_attainment_list', 'EducationalAttainmentController@index')->name('educational_attainment_list');
    Route::get('educational_attainment_add', 'EducationalAttainmentController@add')->name('educational_attainment_add');
    Route::get('educational_attainment_edit/{id}', 'EducationalAttainmentController@edit')->name('educational_attainment_edit');
    Route::post('educational_attainment_add', 'EducationalAttainmentController@store');
    Route::patch('educational_attainment_edit/{id}', 'EducationalAttainmentController@update');
    // Ethnic Group Setup
    Route::get('ethnic_group_list', 'EthnicGroupController@index')->name('ethnic_group_list');
    Route::get('ethnic_group_add', 'EthnicGroupController@add')->name('ethnic_group_add');
    Route::get('ethnic_group_edit/{id}', 'EthnicGroupController@edit')->name('ethnic_group_edit');
    Route::post('ethnic_group_add', 'EthnicGroupController@store');
    Route::patch('ethnic_group_edit/{id}', 'EthnicGroupController@update');
    // Jail Facility Setup
    Route::get('jail_facility_list', 'JailFacilityController@index')->name('jail_facility_list');
    Route::get('jail_facility_add', 'JailFacilityController@add')->name('jail_facility_add');
    Route::get('jail_facility_edit/{id}', 'JailFacilityController@edit')->name('jail_facility_edit');
    Route::post('jail_facility_add', 'JailFacilityController@store');
    Route::patch('jail_facility_edit/{id}', 'JailFacilityController@update');
    // Laboratory Facility Setup
    Route::get('laboratory_facility_list', 'LaboratoryFacilityController@index')->name('laboratory_facility_list');
    Route::get('laboratory_facility_add', 'LaboratoryFacilityController@add')->name('laboratory_facility_add');
    Route::get('laboratory_facility_edit/{id}', 'LaboratoryFacilityController@edit')->name('laboratory_facility_edit');
    Route::post('laboratory_facility_add', 'LaboratoryFacilityController@store');
    Route::patch('laboratory_facility_edit/{id}', 'LaboratoryFacilityController@update');
    // Evidence Type Setup
    Route::get('evidence_type_list', 'EvidenceTypeController@index')->name('evidence_type_list');
    Route::get('evidence_type_add', 'EvidenceTypeController@add')->name('evidence_type_add');
    Route::get('evidence_type_edit/{id}', 'EvidenceTypeController@edit')->name('evidence_type_edit');
    Route::post('evidence_type_add', 'EvidenceTypeController@store');
    Route::patch('evidence_type_edit/{id}', 'EvidenceTypeController@update');
    // Evidence Setup
    Route::get('evidence_list', 'EvidenceController@index')->name('evidence_list');
    Route::get('evidence_add', 'EvidenceController@add')->name('evidence_add');
    Route::get('evidence_edit/{id}', 'EvidenceController@edit')->name('evidence_edit');
    Route::post('evidence_add', 'EvidenceController@store');
    Route::patch('evidence_edit/{id}', 'EvidenceController@update');
    // Packaging Setup
    Route::get('packaging_list', 'PackagingController@index')->name('packaging_list');
    Route::get('packaging_add', 'PackagingController@add')->name('packaging_add');
    Route::get('packaging_edit/{id}', 'PackagingController@edit')->name('packaging_edit');
    Route::post('packaging_add', 'PackagingController@store');
    Route::patch('packaging_edit/{id}', 'PackagingController@update');
    // Regional Office Setup
    Route::get('regional_office_list', 'RegionalOfficeController@index')->name('regional_office_list');
    Route::get('regional_office_add', 'RegionalOfficeController@add')->name('regional_office_add');
    Route::get('regional_office_edit/{id}', 'RegionalOfficeController@edit')->name('regional_office_edit');
    Route::post('regional_office_add', 'RegionalOfficeController@store');
    Route::patch('regional_office_edit/{id}', 'RegionalOfficeController@update');
    Route::get('/get_ro_region/{ro_code}', 'RegionalOfficeController@getRORegion');
    Route::get('/get_ro_province/{ro_code}', 'RegionalOfficeController@getROProvince');
    Route::get('/get_ro_details/{ro_code}', 'RegionalOfficeController@getRODetails');
    // Nationality Setup
    Route::get('nationality_list', 'NationalityController@index')->name('nationality_list');
    Route::get('nationality_add', 'NationalityController@add')->name('nationality_add');
    Route::get('nationality_edit/{id}', 'NationalityController@edit')->name('nationality_edit');
    Route::post('nationality_add', 'NationalityController@store');
    Route::patch('nationality_edit/{id}', 'NationalityController@update');
    // Identifier Setup
    Route::get('identifier_list', 'IdentifierController@index')->name('identifier_list');
    Route::get('identifier_add', 'IdentifierController@add')->name('identifier_add');
    Route::get('identifier_edit/{id}', 'IdentifierController@edit')->name('identifier_edit');
    Route::post('identifier_add', 'IdentifierController@store');
    Route::patch('identifier_edit/{id}', 'IdentifierController@update');
    // Group Affiliation Setup
    Route::get('group_affiliation_list', 'GroupAffiliationController@index')->name('group_affiliation_list');
    Route::get('group_affiliation_add', 'GroupAffiliationController@add')->name('group_affiliation_add');
    Route::get('group_affiliation_edit/{id}', 'GroupAffiliationController@edit')->name('group_affiliation_edit');
    Route::post('group_affiliation_add', 'GroupAffiliationController@store');
    Route::patch('group_affiliation_edit/{id}', 'GroupAffiliationController@update');
    // Occupation Setup
    Route::get('occupation_list', 'OccupationController@index')->name('occupation_list');
    Route::get('occupation_add', 'OccupationController@add')->name('occupation_add');
    Route::get('occupation_edit/{id}', 'OccupationController@edit')->name('occupation_edit');
    Route::post('occupation_add', 'OccupationController@store');
    Route::patch('occupation_edit/{id}', 'OccupationController@update');
    // Suspect Information Setup
    Route::get('suspect_information_list', 'SuspectInformationController@index')->name('suspect_information_list');
    Route::get('suspect_information_add', 'SuspectInformationController@add')->name('suspect_information_add');
    Route::get('suspect_information_edit/{id}', 'SuspectInformationController@edit')->name('suspect_information_edit');
    Route::post('suspect_information_add', 'SuspectInformationController@store');
    Route::post('suspect_information_edit/{id}', 'SuspectInformationController@update');
    // Suspect Status Setup
    Route::get('suspect_status_list', 'SuspectStatusController@index')->name('suspect_status_list');
    Route::get('suspect_status_add', 'SuspectStatusController@add')->name('suspect_status_add');
    Route::get('suspect_status_edit/{id}', 'SuspectStatusController@edit')->name('suspect_status_edit');
    Route::post('suspect_status_add', 'SuspectStatusController@store');
    Route::patch('suspect_status_edit/{id}', 'SuspectStatusController@update');
    // Support Unit Setup
    Route::get('support_unit_list', 'SupportUnitController@index')->name('support_unit_list');
    Route::get('support_unit_add', 'SupportUnitController@add')->name('support_unit_add');
    Route::get('support_unit_edit/{id}', 'SupportUnitController@edit')->name('support_unit_edit');
    Route::post('support_unit_add', 'SupportUnitController@store');
    Route::patch('support_unit_edit/{id}', 'SupportUnitController@update');
    // Position Setup
    Route::get('position_list', 'PositionController@index')->name('position_list');
    Route::get('position_add', 'PositionController@add')->name('position_add');
    Route::get('position_edit/{id}', 'PositionController@edit')->name('position_edit');
    Route::post('position_add', 'PositionController@store');
    Route::patch('position_edit/{id}', 'PositionController@update');
    // Unit of Measurement Setup
    Route::get('unit_measurement_list', 'UnitMeasurementController@index')->name('unit_measurement_list');
    Route::get('unit_measurement_add', 'UnitMeasurementController@add')->name('unit_measurement_add');
    Route::get('unit_measurement_edit/{id}', 'UnitMeasurementController@edit')->name('unit_measurement_edit');
    Route::post('unit_measurement_add', 'UnitMeasurementController@store');
    Route::patch('unit_measurement_edit/{id}', 'UnitMeasurementController@update');
    // Suspect Category Setup
    Route::get('suspect_category_list', 'SuspectCategoryController@index')->name('suspect_category_list');
    Route::get('suspect_category_add', 'SuspectCategoryController@add')->name('suspect_category_add');
    Route::get('suspect_category_edit/{id}', 'SuspectCategoryController@edit')->name('suspect_category_edit');
    Route::post('suspect_category_add', 'SuspectCategoryController@store');
    Route::patch('suspect_category_edit/{id}', 'SuspectCategoryController@update');
    // Suspect SubCategory Setup
    Route::get('suspect_sub_category_list', 'SuspectSubCategoryController@index')->name('suspect_sub_category_list');
    Route::get('suspect_sub_category_add', 'SuspectSubCategoryController@add')->name('suspect_sub_category_add');
    Route::get('suspect_sub_category_edit/{id}', 'SuspectSubCategoryController@edit')->name('suspect_sub_category_edit');
    Route::post('suspect_sub_category_add', 'SuspectSubCategoryController@store');
    Route::patch('suspect_sub_category_edit/{id}', 'SuspectSubCategoryController@update');
    // Officer Position Setup
    Route::get('officer_position_list', 'OfficerPositionController@index')->name('officer_position_list');
    Route::get('officer_position_add', 'OfficerPositionController@add')->name('officer_position_add');
    Route::get('officer_position_edit/{id}', 'OfficerPositionController@edit')->name('officer_position_edit');
    Route::post('officer_position_add', 'OfficerPositionController@store');
    Route::patch('officer_position_edit/{id}', 'OfficerPositionController@update');
    // Approved By Setup
    Route::get('approved_by_list', 'ApprovedByController@index')->name('approved_by_list');
    Route::get('approved_by_add', 'ApprovedByController@add')->name('approved_by_add');
    Route::get('approved_by_edit/{id}', 'ApprovedByController@edit')->name('approved_by_edit');
    Route::post('approved_by_add', 'ApprovedByController@store');
    Route::patch('approved_by_edit/{id}', 'ApprovedByController@update');
    // HIO Type Setup
    Route::get('hio_type_list', 'HIOController@index')->name('hio_type_list');
    Route::get('hio_type_add', 'HIOController@add')->name('hio_type_add');
    Route::get('hio_type_edit/{id}', 'HIOController@edit')->name('hio_type_edit');
    Route::post('hio_type_add', 'HIOController@store');
    Route::patch('hio_type_edit/{id}', 'HIOController@update');

    Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

    //Search Spot Report Number
    Route::get('/search_spot_report_number', 'SpotReportController@search_spot_report_number')->name('search_spot_report_number');
    Route::get('/pr_search_spot_report_number', 'ProgressReportController@search_spot_report_number')->name('pr_search_spot_report_number');
    //Search Operating Unit
    Route::get('/search_operating_unit', 'GlobalController@search_operating_unit')->name('search_operating_unit');
    Route::get('/search_operating_unit_ro_code', 'GlobalController@search_operating_unit_ro_code')->name('search_operating_unit_ro_code');
    Route::get('/search_operating_unit_region_c', 'GlobalController@search_operating_unit_region_c')->name('search_operating_unit_region_c');
    //Search Support Unit
    Route::get('/search_support_unit', 'GlobalController@search_support_unit')->name('search_support_unit');
    //Search Spot Report Number
    
    Route::get('/ao_search_preops_number', 'AfterOperationReportController@search_preops_number');
    //Search Operation Type
    Route::get('/search_operation_type', 'GlobalController@search_operation_type')->name('search_operation_type');
    Route::get('/search_operation_type_ro_code', 'GlobalController@search_operation_type_ro_code')->name('search_operation_type_ro_code');
    Route::get('/search_operation_type_show', 'GlobalController@search_operation_type_show')->name('search_operation_type_show');
    Route::get('/search_case', 'GlobalController@search_case')->name('search_case');
    Route::get('/get_hio_type', 'GlobalController@get_hio_type')->name('get_hio_type');
    //Search Maintenance Data
    Route::get('/search_nationality', 'GlobalController@search_nationality')->name('search_nationality');
    Route::get('/search_civil_status', 'GlobalController@search_civil_status')->name('search_civil_status');
    Route::get('/search_ethnic_group', 'GlobalController@search_ethnic_group')->name('search_ethnic_group');
    Route::get('/search_religion', 'GlobalController@search_religion')->name('search_religion');
    Route::get('/search_education', 'GlobalController@search_education')->name('search_education');
    Route::get('/search_occupation', 'GlobalController@search_occupation')->name('search_occupation');
    Route::get('/search_identifier', 'GlobalController@search_identifier')->name('search_identifier');
    Route::get('/search_suspect_classification', 'GlobalController@search_suspect_classification')->name('search_suspect_classification');
    Route::get('/search_suspect_category', 'GlobalController@search_suspect_category')->name('search_suspect_category');
    Route::get('/search_suspect_sub_category', 'GlobalController@search_suspect_sub_category')->name('search_suspect_sub_category');

    //Global Controller



    //Memo
    Route::get('memo_list', 'MemoController@index')->name('memo_list');
    Route::get('memo_add', 'MemoController@add')->name('memo_add');
    Route::get('memo_edit/{id}', 'MemoController@edit')->name('memo_edit');
    Route::post('memo_add', 'MemoController@store');
    Route::patch('memo_edit/{id}', 'MemoController@update');

    // Drug Verification
    Route::get('drug_verification_list', 'DrugVerificationController@index')->name('drug_verification_list');
    Route::post('drug_verification_add', 'DrugVerificationController@store');
    Route::patch('drug_verification_edit/{id}', 'DrugVerificationController@update');
    // Drug Management
    Route::get('drug_management_list', 'DrugManagementController@index')->name('drug_management_list');
    Route::post('drug_management_add', 'DrugManagementController@store');
    Route::patch('drug_management_edit/{id}', 'DrugManagementController@update');

    // Report Generation
    Route::get('report_generation_list', 'ReportGenerationController@index')->name('report_generation_list');

    //SPOT REPORT GET SUSPECT LIST
    Route::get('/spot_report/fetch_suspect', 'SpotReportController@fetch_suspect');

    //Report PDF
    Route::get('/view_SpotReport/{id}', 'SpotReportController@viewPDF');
    Route::get('/view_Preops/{id}', 'IssuanceOfPreopsController@viewPDF');
    Route::get('/view_ProgressReport/{id}', 'ProgressReportController@viewPDF');

    //Global Controller
    Route::get('/get_preops_number/{region_c}', 'GlobalController@getPreopsNumber');
    Route::get('/get_preops_header/{preops_number}', 'GlobalController@getPreopsHeader');
    Route::get('/get_preops_team/{preops_number}', 'GlobalController@getPreopsTeam');
    Route::get('/get_preops_area/{preops_number}', 'GlobalController@getPreopsArea');
    Route::get('/get_spot_report_header/{spot_report_number}', 'GlobalController@get_spot_report_header');
    Route::get('/get_spot_report_suspect/{spot_report_number}', 'GlobalController@get_spot_report_suspect');
    Route::get('/get_spot_report_evidence_drug/{spot_report_number}', 'GlobalController@get_spot_report_evidence_drug');
    Route::get('/get_spot_report_case/{spot_report_number}', 'GlobalController@get_spot_report_case');
    Route::get('/get_preops_list/{ro_code}/{operating_unit_id}/{operation_type_id}/{operation_date}/{operation_date_to}', 'GlobalController@get_preops_list');
    Route::get('/get_after_operation_list/{ro_code}/{operating_unit_id}/{operation_type_id}/{operation_date}', 'GlobalController@get_after_operation_list');
    Route::get('/get_spot_report_list/{region_c}/{operating_unit_id}/{operation_type_id}/{operation_date}/{operation_date_to}', 'GlobalController@get_spot_report_list');
    Route::get('/get_progress_report_list/{region_c}/{operating_unit_id}/{operation_type_id}/{operation_date}', 'GlobalController@get_progress_report_list');
    Route::get('/get_preops_target/{preops_number}', 'ReportGenerationController@getPreopsTarget');
    Route::get('/get_preops_support_unit/{preops_number}', 'ReportGenerationController@getPreopsSUnit');
    Route::get('/get_preops_operating_team/{preops_number}', 'ReportGenerationController@getPreopsOTeam');
    Route::get('/get_preops_operating_team/{preops_number}', 'ReportGenerationController@getPreopsOTeam');
    Route::get('/get_after_operation_evidence/{preops_number}', 'ReportGenerationController@getPreopsAOE');
    Route::get('/get_preops_spot/{preops_number}', 'ReportGenerationController@getPreopsSPOT');
    Route::get('/get_preops_spot_suspect/{preops_number}', 'ReportGenerationController@getPreopsSPOTSuspect');
    Route::get('/get_preops_spot_evidence/{preops_number}', 'ReportGenerationController@getPreopsSPOTEvidence');
    Route::get('/get_preops_spot_case/{preops_number}', 'ReportGenerationController@getPreopsSPOTCase');
    Route::get('/get_preops_progress_suspect/{preops_number}', 'ReportGenerationController@getPreopsPROSuspect');
    Route::get('/get_preops_spot_suspect_listed/{preops_number}', 'ReportGenerationController@getPreopsPROSuspectListed');
    Route::get('/SPsearch_preops_number', 'SpotReportController@search_preops_number');
    
});


// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', 'WelcomeController@index')->name('welcome');

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

// Route::get('chat_list', 'ChatController@chat_list')->name('chat_list');

// COC Module
// Issuance of Pre-ops Setup
Route::get('/issuance_of_preops_list', 'IssuanceOfPreopsController@index')->name('issuance_of_preops_list');
Route::get('/issuance_of_preops_list/fetch_data', 'IssuanceOfPreopsController@fetch_data');
Route::get('/issuance_of_preops_list/search_preops_list', 'IssuanceOfPreopsController@search_preops_list');
Route::get('issuance_of_preops_add', 'IssuanceOfPreopsController@add')->name('issuance_of_preops_add');
Route::get('issuance_of_preops_edit/{id}', 'IssuanceOfPreopsController@edit')->name('issuance_of_preops_edit');
Route::post('issuance_of_preops_add', 'IssuanceOfPreopsController@store');
Route::post('issuance_of_preops_edit/{id}', 'IssuanceOfPreopsController@update');
Route::get('/issuance_report/pdf/{id}', 'IssuanceOfPreopsController@pdf');
Route::get('/get_preops_header_count/{ro_code}/{province_c}', 'IssuanceOfPreopsController@get_preops_header_count');
// Route::get('/get_preops_header/{preops_number}', 'IssuanceOfPreopsController@get_preops_header');

// After Operation Report Setup
Route::get('after_operation_report_list', 'AfterOperationReportController@index')->name('after_operation_report_list');
Route::get('/after_operation_report_list/fetch_data', 'AfterOperationReportController@fetch_data');
Route::get('/after_operation_report_list/search_preops_list', 'IssuanceOfPreopsController@search_preops_list');
Route::get('after_operation_report_add', 'AfterOperationReportController@add')->name('after_operation_report_add');
Route::get('after_operation_report_edit/{preops_number}', 'AfterOperationReportController@edit')->name('after_operation_report_edit');
Route::post('after_operation_report_add', 'AfterOperationReportController@store');
Route::post('after_operation_report_edit/{preops_number}', 'AfterOperationReportController@update');
Route::get('after_operation_file_delete/{id}', 'AfterOperationReportController@fileDelete');


// Spot & Progress Report Module
// Spot Report Setup
Route::get('spot_report_list', 'SpotReportController@index')->name('spot_report_list');
Route::get('/spot_report_list/fetch_data', 'SpotReportController@fetch_data');
Route::get('/spot_report_list/search_spot_report_list', 'SpotReportController@search_spot_report_list');
Route::get('spot_report_add', 'SpotReportController@add')->name('spot_report_add');
Route::get('spot_report_edit/{id}', 'SpotReportController@edit')->name('spot_report_edit');
Route::post('spot_report_add', 'SpotReportController@store');
Route::post('spot_report_edit/{id}', 'SpotReportController@update');
Route::get('get_spot_report_item_seized/{spot_report_number}', 'SpotReportController@get_spot_report_item_seized')->name('get_spot_report_item_seized');
Route::get('spot_report_file_delete/{id}', 'SpotReportController@fileDelete');
Route::get('/spot_report/pdf/{id}', 'SpotReportController@viewPDF');
Route::get('/get_suspect_number_count/{count}', 'SpotReportController@get_suspect_number_count');

// Progress Report Setup
Route::get('progress_report_list', 'ProgressReportController@index')->name('progress_report_list');
Route::get('/progress_report_list/fetch_data', 'ProgressReportController@fetch_data');
Route::get('/progress_report_list/search_spot_report_list', 'ProgressReportController@search_spot_report_list');
Route::get('progress_report_add', 'ProgressReportController@add')->name('progress_report_add');
Route::get('progress_report_edit/{id}', 'ProgressReportController@edit')->name('progress_report_edit');
Route::post('progress_report_add', 'ProgressReportController@store');
Route::post('progress_report_edit/{id}', 'ProgressReportController@update');
Route::get('progress_report_file_delete/{id}', 'ProgressReportController@fileDelete');
Route::get('/progress_report/pdf/{id}', 'ProgressReportController@pdf');

//File Uploads
Route::get('preops_files_list', 'FileUploadsController@preops_files_list')->name('preops_files_list');
Route::get('afteroperation_files_list', 'FileUploadsController@afteroperation_files_list')->name('afteroperation_files_list');
Route::get('spotreport_files_list', 'FileUploadsController@spotreport_files_list')->name('spotreport_files_list');
Route::get('progressreport_files_list', 'FileUploadsController@progressreport_files_list')->name('progressreport_files_list');



// Global Controller
Route::get('/get_province/{region_c}', 'GlobalController@getProvince');
Route::get('/get_city/{province_c}', 'GlobalController@getCity');
Route::get('/get_barangay/{city_c}', 'GlobalController@getBarangay');
Route::get('/getUsers', 'GlobalController@getUsers')->name('getUsers');
Route::get('/get_province_details/{province_c}', 'GlobalController@get_province_details');

Route::get('/get_user/{user_id}', 'GlobalController@getUser');
Route::get('/get_drug_management/{suspect_id}', 'GlobalController@getDrugManagement');
Route::get('/get_support_unit/{preops_number}', 'GlobalController@getPreopsSupportUnit');
Route::get('/get_evidence_type/{category}', 'GlobalController@getEvidenceType');
Route::get('/get_unit_measure/{evidence_id}', 'GlobalController@getUnitMeasure');
Route::get('/get_operation_type/{operation_type_id}', 'GlobalController@get_operation_type');

Route::get('/get_suspect_category/{suspect_classification_id}', 'GlobalController@get_suspect_category');
Route::get('/get_operating_unit/{ro_code}', 'GlobalController@get_operating_unit');
Route::get('/get_approved_by/{ro_code}', 'GlobalController@get_approved_by');
Route::get('/get_operation_category/{operation_classification_id}', 'GlobalController@get_operation_category');
Route::get('/get_suspect_sub_category/{suspect_category_id}', 'GlobalController@get_suspect_sub_category');
Route::get('/get_user_log', 'GlobalController@get_user_log');


//Chat Controller
Route::get('chat_list', 'ChatController@chat_list')->name('chat_list');
Route::get('msg_pane', 'ChatController@msg_pane')->name('msg_pane');
Route::post('chatting_with', 'ChatController@chatting_with')->name('chatting_with');
Route::post('send_chat', 'ChatController@send_chat')->name('send_chat');

//Geomapping
Route::get('geo_mapping', 'GeoMappingController@index')->name('geo_mapping');
Route::get('geo_mapping2', 'GeoMappingController@index2')->name('geo_mapping2');
Route::get('ops_details', 'GeoMappingController@ops_details')->name('ops_details');
Route::get('chat', 'ChatController@index')->name('chat');
Route::post('ops_update_warning', 'GeoMappingController@ops_update_warning')->name('ops_update_warning');
Route::post('ops_details_Xport', 'XLController@ops_details_Xport')->name('ops_details_Xport');

Route::get('search_suspect', 'SuspectInformationController@search_suspect');
Route::get('search_spot_report', 'SpotReportController@search_spot_report');
Route::get('search_preops', 'IssuanceOfPreopsController@search_preops');
Route::get('search_files', 'FileUploadsController@search_files');
