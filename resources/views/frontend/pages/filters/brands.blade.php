<h4 class="widget-title">BY BRANDS</h4>
<div class="ps-form--widget-search">
    <button><span class="fa fa-search form-control-feedback"></span></button>
    <input class="form-control" type="text" id="chkfilter">
</div>

    <figure class="ps-custom-scrollbar" data-height="250">
    @php($i=1)
    @foreach ($brands as $brand)
        <div class="ps-checkbox" id="brand-{{$i}}">
            <input class="form-control" value="{{$brand->slug}}" type="checkbox" id="brand-{{$i}}" name="brands"
                onclick="selectBrands()" {{in_array($brand->id,$requested['selected_brands'])?'checked':''}}>
            <label for="brand-{{$i}}">{{ucfirst($brand->slug)}}</label>
        </div>
        @php($i++)
        @endforeach
              
    </figure>

    @section('scripts')
    <script>  
    $('#chkfilter').on('keyup', function() {
    var query = this.value;

        $('[name^="brands"]').each(function(i, elem) {
            if (elem.value.indexOf(query) != -1) {
                elem.style.display = 'block';

                if(this.style.display === 'block'){ 
                    $("#"+this.id).css("display", "block");
                }
                
            }else{
                elem.style.display = 'none';
                if(this.style.display === 'none'){ 
                    $("#"+this.id).css("display", "none");

                }

            }
        });
    });
    </script>
    @endsection

   