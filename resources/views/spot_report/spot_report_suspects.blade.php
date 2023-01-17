@forelse($suspects as $srs)
<tr class="suspect_details">
    <td hidden><input type="number" name="spot_suspect_id[]" class="form-control" value="{{ $srs->id }}"></td>
    <td><input required type="text" name="suspect_number[]" style="width: 200px; pointer-events:none; background-color : #e9ecef;" class="form-control" value="{{ $srs->suspect_number }}"></td>
    <td>
        <select name="suspect_status_id[]" class="form-control suspect_status_id" style="width: 200px;" required>
            <option value='' selected>Select Option</option>
            @foreach ($suspect_status as $sstat)
            <option value="{{ $sstat->id }}" {{ $sstat->id == $srs->suspect_status_id ? 'selected' : '' }}>
                {{ $sstat->name }}
            </option>
            @endforeach
        </select>
    </td>
    <td><input {{ 2 == $srs->suspect_status_id ? '' : 'required' }} type="text" name="lastname[]" style="width: 200px;" class="form-control change_control cc1" value="{{ $srs->lastname }}"></td>
    <td><input {{ 2 == $srs->suspect_status_id ? '' : 'required' }} type="text" name="firstname[]" style="width: 200px;" class="form-control change_control cc2" value="{{ $srs->firstname }}"></td>
    <td><input {{ 2 == $srs->suspect_status_id ? '' : 'required' }} type="text" name="middlename[]" style="width: 200px;" class="form-control change_control cc3" value="{{ $srs->middlename }}"></td>
    <td><input {{ 2 == $srs->suspect_status_id ? '' : 'required' }} type="text" name="alias[]" style="width: 200px;" class="form-control change_control cc4" value="{{ $srs->alias }}"></td>
    <td><input {{ 2 == $srs->suspect_status_id ? '' : 'required' }} type="date" name="birthdate[]" style="width: 200px;" class="form-control change_control cc5" value="{{ $srs->birthdate }}"></td>
    <td>
        <select name="est_birthdate[]" class="form-control" style="width: 200px;">
            <option value="0" {{ $srs->est_birthdate == false ? 'selected' : '' }}>No
            </option>
            <option value="1" {{ $srs->est_birthdate == true ? 'selected' : '' }}>Yes
            </option>
        </select>
    </td>
    <td><input type="text" name="birthplace[]" style="width: 200px;" class="form-control" value="{{ $srs->birthplace }}"></td>
    <td>
        <select name="present_region_c[]" class="form-control present_region_c" style="width: 200px;">
            <option value='' selected>Select Option</option>
            @foreach ($region as $rg)
            <option value="{{ $rg->region_c }}" {{ $rg->region_c == $srs->region_c ? 'selected' : '' }}>
                {{ $rg->abbreviation }} -
                {{ $rg->region_m }}
            </option>
            @endforeach
        </select>
    </td>
    <td>
        <select name="present_province_c[]" class="form-control present_province_c" style="width: 200px;">
            @if($srs->province_c != null)
            <option value="{{ $srs->province_c }}">
                {{ $srs->province_name }}
            </option>
            @else
            <option value='' selected>Select Option</option>
            @endif
        </select>
    </td>
    <td>
        <select name="present_city_c[]" class="form-control present_city_c" style="width: 200px;">
            @if($srs->city_c != null)
            <option value="{{ $srs->city_c }}">
                {{ $srs->city_name }}
            </option>
            @else
            <option value='' selected>Select Option</option>
            @endif
        </select>
    </td>
    <td>
        <select name="present_barangay_c[]" class="form-control present_barangay_c" style="width: 200px;">
            @if($srs->barangay_c != null)
            <option value="{{ $srs->barangay_c }}">
                {{ $srs->barangay_name }}
            </option>
            @else
            <option value='' selected>Select Option</option>
            @endif
        </select>
    </td>
    <td><input type="text" name="present_street[]" style="width: 200px;" class="form-control" value="{{ $srs->street }}"></td>
    <td>
        <select name="permanent_region_c[]" class="form-control permanent_region_c" style="width: 200px;">
            <option value='' selected>Select Option</option>
            @foreach ($region as $prg)
            <option value="{{ $prg->region_c }}" {{ $prg->region_c == $srs->permanent_region_c ? 'selected' : '' }}>
                {{ $prg->abbreviation }} -
                {{ $prg->region_m }}
            </option>
            @endforeach
        </select>
    </td>
    <td>
        <select name="permanent_province_c[]" class="form-control permanent_province_c" style="width: 200px;">
            @if($srs->permanent_province_c != null)
            <option value="{{ $srs->permanent_province_c }}">
                {{ $srs->permanent_province_name }}
            </option>
            @else
            <option value='' selected>Select Option</option>
            @endif
        </select>
    </td>
    <td>
        <select name="permanent_city_c[]" class="form-control permanent_city_c" style="width: 200px;">
            @if($srs->permanent_city_c != null)
            <option value="{{ $srs->permanent_city_c }}">
                {{ $srs->permanent_city_name }}
            </option>
            @else
            <option value='' selected>Select Option</option>
            @endif
        </select>
    </td>
    <td>
        <select name="permanent_barangay_c[]" class="form-control permanent_barangay_c" style="width: 200px;">
            @if($srs->permanent_barangay_c != null)
            <option value="{{ $srs->permanent_barangay_c }}">
                {{ $srs->permanent_barangay_name }}
            </option>
            @else
            <option value='' selected>Select Option</option>
            @endif
        </select>
    </td>
    <td><input type="text" name="permanent_street[]" style="width: 200px;" class="form-control" value="{{ $srs->permanent_street }}"></td>
    <td>
        <select name="gender[]" class="form-control" style="width: 200px;">
            <option value="male" {{ 'male' == $srs->gender ? 'selected' : '' }}>
                Male</option>
            <option value="female" {{ 'female' == $srs->gender ? 'selected' : '' }}>
                Female</option>
        </select>
    </td>
    <td>
        <select name="civil_status_id[]" class="form-control" style="width: 200px;">
            <option value='' selected>Select Option</option>
            @foreach ($civil_status as $cs)
            <option value="{{ $cs->id }}" {{ $cs->id == $srs->civil_status_id ? 'selected' : '' }}>
                {{ $cs->name }}
            </option>
            @endforeach
        </select>
    </td>
    <td>
        <select name="nationality_id[]" class="form-control" style="width: 200px;">
            <option value='' selected>Select Option</option>
            @foreach ($nationality as $na)
            <option value="{{ $na->id }}" {{ $na->id == $srs->nationality_id ? 'selected' : '' }}>
                {{ $na->name }}
            </option>
            @endforeach
        </select>
    </td>
    <td>
        <select name="ethnic_group_id[]" class="form-control" style="width: 200px;">
            <option value='' selected>Select Option</option>
            @foreach ($ethnic_group as $eg)
            <option value="{{ $eg->id }}" {{ $eg->id == $srs->ethnic_group_id ? 'selected' : '' }}>
                {{ $eg->name }}
            </option>
            @endforeach
        </select>
    </td>
    <td>
        <select name="religion_id[]" class="form-control" style="width: 200px;">
            <option value='' selected>Select Option</option>
            @foreach ($religion as $rl)
            <option value="{{ $rl->id }}" {{ $rl->id == $srs->religion_id ? 'selected' : '' }}>
                {{ $rl->name }}
            </option>
            @endforeach
        </select>
    </td>
    <td>
        <select name="educational_attainment_id[]" class="form-control" style="width: 200px;">
            <option value='' selected>Select Option</option>
            @foreach ($education as $ed)
            <option value="{{ $ed->id }}" {{ $ed->id == $srs->educational_attainment_id ? 'selected' : '' }}>
                {{ $ed->name }}
            </option>
            @endforeach
        </select>
    </td>
    <td>
        <select name="occupation_id[]" class="form-control" style="width: 200px;">
            <option value='' selected>Select Option</option>
            @foreach ($occupation as $occ)
            <option value="{{ $occ->id }}" {{ $occ->id == $srs->occupation_id ? 'selected' : '' }}>
                {{ $occ->name }}
            </option>
            @endforeach
        </select>
    </td>
    <td>
        <select name="identifier_id[]" class="form-control" style="width: 200px;">
            <option value='' selected>Select Option</option>
            @foreach ($identifier as $identifiers)
            <option value="{{ $identifiers->id }}" {{ $identifiers->id == $srs->identifier_id ? 'selected' : '' }}>
                {{ $identifiers->name }}
            </option>
            @endforeach
        </select>
    </td>
    <td>
        <select name="suspect_classification_id[]" class="form-control suspect_classification_id" style="width: 200px;">
            <option value='' selected>Select Option</option>
            @foreach ($suspect_classification as $sclass)
            <option value="{{ $sclass->id }}" {{ $sclass->id == $srs->suspect_classification_id ? 'selected' : '' }}>
                {{ $sclass->name }}
            </option>
            @endforeach
        </select>
    </td>
    <td>
        <select name="suspect_category_id[]" class="form-control suspect_category_id" style="width: 200px;">
            <option value='' selected>Select Option</option>
            @foreach ($suspect_category as $scat)
            <option value="{{ $scat->id }}" {{ $scat->id == $srs->suspect_category_id ? 'selected' : '' }}>
                {{ $scat->name }}
            </option>
            @endforeach
        </select>
    </td>
    <td>
        <select name="suspect_sub_category_id[]" class="form-control" style="width: 200px;">
            <option value='' selected>Select Option</option>
            @foreach ($suspect_sub_category as $scat)
            <option value="{{ $scat->id }}" {{ $scat->id == $srs->suspect_sub_category_id ? 'selected' : '' }}>
                {{ $scat->name }}
            </option>
            @endforeach
        </select>
    </td>
    <td><input type="text" name="whereabouts[]" style="width: 200px;" class="form-control" value="{{ $srs->whereabouts }}"></td>
    <td><input type="text" name="remarks[]" style="width: 200px;" class="form-control" value="{{ $srs->remarks }}"></td>
    <td style="text-align: center; padding: 10px"><input name="active" type="checkbox" style="pointer-events: none;" {{ $srs->listed == 1 ? 'checked' : ''}}></td>
    <td><input type="text" style="width: 200px;" class="form-control" value="{{ $srs->uname }} - {{ $srs->ulvl }}" disabled></td>
    <td class="mt-10"><button type="button" class="badge badge-danger" onclick="SomeDeleteRowFunction(this)"><i class="fa fa-trash"></i> Delete</button>
    </td>
</tr>
@empty
<tr class="suspect_details">
    <td hidden><input type="number" name="spot_suspect_id[]" class="form-control"></td>
    <td><input type="text" name="suspect_number[]" style="width: 200px;" class="form-control" value="1" hidden>
        <div type="text" style="width: 200px;" class="form-control disabled_field">Auto Generated</div>
    </td>
    <td>
        <select name="suspect_status_id[]" class="form-control suspect_status_id" style="width: 200px;">
            <option value='' selected>Select Option</option>
            @foreach ($suspect_status as $sstat)
            <option value="{{ $sstat->id }}">
                {{ $sstat->name }}
            </option>
            @endforeach
        </select>
    </td>
    <td><input type="text" name="lastname[]" style="width: 200px;" class="form-control change_control cc1">
    </td>
    <td><input type="text" name="firstname[]" style="width: 200px;" class="form-control change_control cc2">
    </td>
    <td><input type="text" name="middlename[]" style="width: 200px;" class="form-control change_control cc3">
    </td>
    <td><input type="text" name="alias[]" style="width: 200px;" class="form-control change_control cc4">
    </td>
    <td><input type="date" name="birthdate[]" style="width: 200px;" class="form-control change_control cc5">
    </td>
    <td>
        <select name="est_birthdate[]" class="form-control" style="width: 200px;">
            <option value="0">No
            </option>
            <option value="1">Yes
            </option>
        </select>
    </td>
    <td><input type="text" name="birthplace[]" style="width: 200px;" class="form-control">
    </td>
    <td>
        <select name="present_region_c[]" class="form-control present_region_c" style="width: 200px;">
            <option value='' selected>Select Option</option>
            @foreach ($region as $rg)
            <option value="{{ $rg->region_c }}">
                {{ $rg->abbreviation }} -
                {{ $rg->region_m }}
            </option>
            @endforeach
        </select>
    </td>
    <td>
        <select name="present_province_c[]" class="form-control present_province_c" style="width: 200px;">
            <option value='' selected>Select Option</option>
        </select>
    </td>
    <td>
        <select name="present_city_c[]" class="form-control present_city_c" style="width: 200px;">
            <option value='' selected>Select Option</option>
        </select>
    </td>
    <td>
        <select name="present_barangay_c[]" class="form-control present_barangay_c" style="width: 200px;">
            <option value='' selected>Select Option</option>
        </select>
    </td>
    <td><input type="text" name="present_street[]" style="width: 200px;" class="form-control">
    </td>
    <td>
        <select name="permanent_region_c[]" class="form-control permanent_region_c" style="width: 200px;">
            <option value='' selected>Select Option</option>
            @foreach ($region as $rg)
            <option value="{{ $rg->region_c }}">
                {{ $rg->abbreviation }} -
                {{ $rg->region_m }}
            </option>
            @endforeach
        </select>
    </td>
    <td>
        <select name="permanent_province_c[]" class="form-control permanent_province_c" style="width: 200px;">
            <option value='' selected>Select Option</option>
        </select>
    </td>
    <td>
        <select name="permanent_city_c[]" class="form-control permanent_city_c" style="width: 200px;">
            <option value='' selected>Select Option</option>
        </select>
    </td>
    <td>
        <select name="permanent_barangay_c[]" class="form-control permanent_barangay_c" style="width: 200px;">
            <option value='' selected>Select Option</option>
        </select>
    </td>
    <td><input type="text" name="permanent_street[]" style="width: 200px;" class="form-control">
    </td>
    <td>
        <select name="gender[]" class="form-control" style="width: 200px;">
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select>
    </td>
    <td>
        <select name="civil_status_id[]" class="form-control" style="width: 200px;">
            <option value='' selected>Select Option</option>
            @foreach ($civil_status as $cs)
            <option value="{{ $cs->id }}">
                {{ $cs->name }}
            </option>
            @endforeach
        </select>
    </td>
    <td>
        <select name="nationality_id[]" class="form-control" style="width: 200px;">
            <option value='' selected>Select Option</option>
            @foreach ($nationality as $na)
            <option value="{{ $na->id }}">
                {{ $na->name }}
            </option>
            @endforeach
        </select>
    </td>
    <td>
        <select name="ethnic_group_id[]" class="form-control" style="width: 200px;">
            <option value='' selected>Select Option</option>
            @foreach ($ethnic_group as $eg)
            <option value="{{ $eg->id }}">
                {{ $eg->name }}
            </option>
            @endforeach
        </select>
    </td>
    <td>
        <select name="religion_id[]" class="form-control" style="width: 200px;">
            <option value='' selected>Select Option</option>
            @foreach ($religion as $rl)
            <option value="{{ $rl->id }}">
                {{ $rl->name }}
            </option>
            @endforeach
        </select>
    </td>
    <td>
        <select name="educational_attainment_id[]" class="form-control" style="width: 200px;">
            <option value='' selected>Select Option</option>
            @foreach ($education as $ed)
            <option value="{{ $ed->id }}">
                {{ $ed->name }}
            </option>
            @endforeach
        </select>
    </td>
    <td>
        <select name="occupation_id[]" class="form-control" style="width: 200px;">
            <option value='' selected>Select Option</option>
            @foreach ($occupation as $occ)
            <option value="{{ $occ->id }}">
                {{ $occ->name }}
            </option>
            @endforeach
        </select>
    </td>
    <td>
        <select name="identifier_id[]" class="form-control" style="width: 200px;">
            <option value='' selected>Select Option</option>
            @foreach ($identifier as $identifiers)
            <option value="{{ $identifiers->id }}">
                {{ $identifiers->name }}
            </option>
            @endforeach
        </select>
    </td>
    <td>
        <select name="suspect_classification_id[]" class="form-control suspect_classification_id" style="width: 200px;">
            <option value='' selected>Select Option</option>
            @foreach ($suspect_classification as $sclass)
            <option value="{{ $sclass->id }}">
                {{ $sclass->name }}
            </option>
            @endforeach
        </select>
    </td>
    <td>
        <select name="suspect_category_id[]" class="form-control suspect_category_id" style="width: 200px;">
            <option value='' selected>Select Option</option>
        </select>
    </td>
    <td>
        <select name="suspect_sub_category_id[]" class="form-control" style="width: 200px;">
            <option value='' selected>Select Option</option>
        </select>
    </td>
    <td><input type="text" name="whereabouts[]" style="width: 200px;" class="form-control"></td>
    <td><input type="text" name="remarks[]" style="width: 200px;" class="form-control"></td>
    <td style="text-align: center; padding: 10px"><input name="active" type="checkbox" style="pointer-events: none;"></td>
    <td><input type="text" style="width: 200px;" class="form-control" value="" disabled></td>
    <td class="mt-10"><button type="button" class="badge badge-danger"><i class="fa fa-trash"></i> Delete</button>
    </td>
</tr>
@endforelse