@foreach($p_brokerage as $val)
    <tr>
        <td>{{$val['by_stages_way']. $val['pay_type_unit']}}</td>
        <td>{{$val['ratio_for_agency']}}%</td>

        <td>
            <input type="text" name="brokerage[]">%
            <input class="ditch-id" name="ditch_id[]" type="hidden" value="{{ $id }}">
            <input class="by-stages-way" name="by_stages_way[]" type="hidden" value="{{$val['by_stages_way']. $val['pay_type_unit']}}">
            <input type="hidden" name="ty_product_id[]" id="ty_product_id" value="">
            <input type="hidden" name="man[]" id="man_agent" value="">
            <input type="hidden" name="ratio_for_agency[]" id="man_agent" value="{{$val['ratio_for_agency']}}">
        </td>

    </tr>
@endforeach
