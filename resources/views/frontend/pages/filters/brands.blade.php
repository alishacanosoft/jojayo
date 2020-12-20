<h4 class="widget-title">BY BRANDS</h4>
<div class="ps-form--widget-search">
    <button><span class="fa fa-search form-control-feedback"></span></button>
    <input class="form-control" type="text" id="chkfilter">
</div>

    <figure class="ps-custom-scrollbar" data-height="250">
    @php($i=1)
    @foreach ($brands as $brand)
        <div class="ps-checkbox brand-{{$i}}" >
            <input class="form-control" myname="brand-{{$i}}" value="{{$brand->slug}}" type="checkbox" id="brand-{{$i}}" name="brands"
                onclick="selectBrands()" {{in_array($brand->id,$requested['selected_brands'])?'checked':''}}>
            <label for="brand-{{$i}}">{{ucfirst($brand->slug)}} ({{App\Models\Product::where('brand_id',$brand->id)->count()}})</label>
        </div>
        @php($i++)
        @endforeach
              
    </figure>

    @push('scripts')
    <script>  
    $('#chkfilter').on('keyup', function() {
    var query = this.value;

        $('[name^="brands"]').each(function(i, elem) {
            if (elem.value.indexOf(query) != -1) {
                elem.style.display = 'block';

                if(this.style.display === 'block'){ 
                    var mainid = this.id
                    var aa =$('#'+mainid).attr("myname");
                    if(this.id===aa){
                        $('.'+aa).show();
                    }
                }
                
            }else{
                elem.style.display = 'none';
                if(this.style.display === 'none'){ 
                    var mainid = this.id
                    var aa =$('#'+mainid).attr("myname");
                    if(this.id===aa){
                        $('.'+aa).hide();
                    }

                }

            }
        });
    });
    </script>
    <script>
    var current_url='{{url()->current()}}'
    // var favorite = [];
    var brands = '';
    var sort = '{{$requested["sort"]}}';
    var minPrice = '';
    var maxPrice = '';
    // var sizes = [];

    function selectBrands(){
       setBrands();
        window.location.replace(getUrl());
    }

    // function bySize(){
    //     setSizes();
    //     window.location.replace(getUrl());
    // }

    function setBrands(){
        brands=[];
        $.each($("input[name='brands']:checked"), function(){
            brands.push($(this).val());
        });
    }
    // function setSizes(){
    //     sizes=[];
    //     $.each($("input[name='sizes']:checked"), function(){
    //         sizes.push($(this).val());
    //     });
    // }



   $('#onSort').change(function(){
       var sortBy=$(this).val();
       sort = sortBy
       window.location.replace(getUrl());
   })

    $('#byPrice').on('click',function(){
         minPrice = $('#minPrice').val();
         maxPrice = $('#maxPrice').val();
         window.location.replace(getUrl());
    })

  
    function getUrl(){
        var new_url=current_url
        var brand_url='';
        var price_url='';
        // var size_url='';
        var sort_url='';

        minPrice = $('#minPrice').val();
        maxPrice = $('#maxPrice').val();

        // setSizes();
        setBrands();

        if(brands.length>0){
            $.each(brands,function(index,value){
               brand_url+='brands['+index+']='+value+'&';
            })
        }

        // if(sizes.length>0){
        //     $.each(sizes,function(index,value){
        //        size_url+='sizes['+index+']='+value+'&';
        //     })
        // }

        if(sort.length>0){
            sort_url = 'sort=' + sort + '&';
        }

        if(minPrice>0&&maxPrice>0){
            price_url = 'price='+minPrice+'-'+maxPrice+'&';
        }

        return new_url+='?' + price_url + sort_url
    }
</script>
    @endpush

   