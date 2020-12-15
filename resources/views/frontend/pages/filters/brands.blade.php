<h4 class="widget-title">BY BRANDS</h4>
{{-- <form class="ps-form--widget-search" action="do_action" method="get">
    <input class="form-control" type="text" placeholder="">
    <button><i class="icon-magnifier"></i></button>
</form> --}}
<div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 50px;">
    <figure class="ps-custom-scrollbar" data-height="250" style="overflow: hidden; width: auto; height: 50px;">
        @foreach ($brands as $key=>$brand)
        <div class="ps-checkbox">
            <input class="form-control" value="{{$brand->slug}}" type="checkbox" id="brand-{{$key}}" name="brands"
                onclick="selectBrands()" {{in_array($brand->id,$requested['selected_brands'])?'checked':''}}>
            <label for="brand-{{$key}}">{{$brand->slug}}</label>
        </div>
        @endforeach
    </figure>
    <div class="slimScrollBar"
        style="background: rgb(0, 0, 0); width: 6px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px; height: 166.667px;">
    </div>
    <div class="slimScrollRail"
        style="width: 6px; height: 100%; position: absolute; top: 0px; display: block; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;">
    </div>
</div>
