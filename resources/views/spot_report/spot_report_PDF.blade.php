<style>
    @page {
        margin: 10px;
    }

    .page-border {
        position: fixed;
        left: 10px;
        top: 10px;
        bottom: 10px;
        right: 10px;
        border: 2px dotted black;
    }

    .hidden {
        display: none;
    }

    td {
        border: 1px solid black;
        border-collapse: collapse;
    }

    .pagenum:before {
        content: 'Page 'counter(page);
    }
</style>
<div class="page-border">
    <table style="width:100%;">
        <tr style="text-align: center;">
            <td style="font-size: 24px; font-weight:700;">Inhabitants List</td>
        </tr>
        <!-- <tr style="text-align: center;">
            <td style="font-size: 24px; font-weight:700;">Sample</td>
        </tr> -->
    </table>
    <br>
    <table style="width:100%; border-top:1px solid black; border-bottom:1px solid black;border-collapse: collapse;">
        <thead>
            <tr>
                <th @if($chk_Household_Name==0) class="hidden" @endif style="border:1px solid black;">Household Name</th>
                <th @if($chk_Household_Monthly_Income==0) class="hidden" @endif style="border:1px solid black;">Monthly Income</th>
                <th @if($chk_Tenure_of_Lot==0) class="hidden" @endif style="border:1px solid black;">Tenure of Lot</th>
                <th @if($chk_Housing_Unit==0) class="hidden" @endif style="border:1px solid black;">Housing Unit</th>
                <th @if($chk_Family_Type_Name==0) class="hidden" @endif style="border:1px solid black;">Family Type</th>
            </tr>
        </thead>
        <tbody>
            @foreach($db_entries as $x)
            <tr>
                <td @if($chk_Household_Name==0) class="hidden" @else class="sm_data_col" @endif>{{$x->Household_Name}}</td>
                <td @if($chk_Household_Monthly_Income==0) class="hidden" @else class="sm_data_col" @endif>{{$x->Household_Monthly_Income}}</td>
                <td @if($chk_Tenure_of_Lot==0) class="hidden" @else class="sm_data_col" @endif>{{$x->Tenure_of_Lot}}</td>
                <td @if($chk_Housing_Unit==0) class="hidden" @else class="sm_data_col" @endif>{{$x->Housing_Unit}}</td>
                <td @if($chk_Family_Type_Name==0) class="hidden" @else class="sm_data_col" @endif>{{$x->Family_Type_Name}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>