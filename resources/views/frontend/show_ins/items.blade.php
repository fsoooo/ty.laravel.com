<div class="product-equity">
    {{--<h3 class="section-title">保障权益</h3>--}}
    <div class="table-head">保障权益</div>
    @foreach($protect_items as $value)
        {{--<div class="product-equity-item" id="{{$value['protectItemId']}}">--}}
            {{--<div class="table-head">{{$value['name']}}</div>--}}
            <table>
                <tr>
                    <td class="product-equity-img">
                        <img src="{{config('view_url.view_url')}}image/610318870343627142.png" alt="" />
                    </td>
                    <td class="product-equity-name">{{$value['name']}}</td>
                    @if(isset($value['defaultValue']))
                    <td class="product-equity-price">{{ $value['defaultValue']}}</td>
                    @endif
                    <td class="product-equity-info">
                        <?php
                        $descrip = isset($value['description']) ? $value['description'] : $value['name'];
                        echo $descrip;
                        ?>
                </td>
                </tr>
            </table>
        {{--</div>--}}
    @endforeach
</div>
<input type="hidden" id="protect_item" name="protect_item" value="{{json_encode($protect_items, JSON_UNESCAPED_UNICODE)}}">