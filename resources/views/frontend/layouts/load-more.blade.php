<script type="text/javascript">
	var page = 1;
	$(window).scroll(function() {
       window_scrolled = ($(document).height()/100)*75;
       if($(window).scrollTop() + $(window).height() >= window_scrolled) {
           page++;
           if(page <= "{{ $lastpage }}"){
            loadMoreData(page);
           } else {
            setTimeout(function(){
                $('.ajax-load').html('<p class="text-center text-danger"><strong>No More Product available.</strong></p>');
                $('.ajax-load').show();
            }, 2000);
            return;
           }
       }
	});

	function loadMoreData(page){
	  $.ajax({
         url: '?page=' + page,
         type: "get",
         beforeSend: function()
         {
               $('.ajax-load').show();
         },
         success(callback_resonse){
            let receive = callback_resonse.data; console.log(callback_resonse)
            $('.ajax-load').hide();
            let html = "";
            let listhtml = "";
            var description = "";
            let fb = "";
            $.each(receive, function( key, value ){
            var data = value.slug;
            var url = "{{ route('single-product', ':data') }}";
            url = url.replace(':data', data);
            title = value.name;
            var final_price = (value.sizes[0].selling_price - value.sizes[0].discount);
            var txt= value.description;
            if(txt == 'undefined'){
                description = ".....";
            } else {
                if(txt.length > 155)
                description = txt.substring(0,100) + '.....';
            }
            html = '<div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-6"><div class="ps-product"><div class="ps-product__thumbnail"><a href="'+url+'"><img src="/uploads/products/'+value.images[0].images[0].image+'" alt=""></a><ul class="ps-product__actions"><li><a data-placement="top" class="btn-quick-view" value="'+value.id+'" title="Quick View" data-toggle="modal" data-target="#product-quickview"><i class="icon-eye"></i></a></li><li><a data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Add to Whishlist"><i class="icon-heart"></i></a></li></ul></div><div class="ps-product__container"><a class="ps-product__vendor" href="#">'+value.category.name+'</a><div class="ps-product__content"><a class="ps-product__title" href="'+url+'">'+title+'</a><div class="ps-product__rating"><div class="br-wrapper br-theme-fontawesome-stars"><select class="ps-rating" data-read-only="true" style="display: none;"><option value="1">1</option><option value="1">2</option><option value="1">3</option><option value="1">4</option><option value="2">5</option></select><div class="br-widget br-readonly"><a href="#" data-rating-value="1" data-rating-text="1" class="br-selected br-current"></a><a href="#" data-rating-value="1" data-rating-text="2" class="br-selected br-current"></a><a href="#" data-rating-value="1" data-rating-text="3" class="br-selected br-current"></a><a href="#" data-rating-value="1" data-rating-text="4" class="br-selected br-current"></a><a href="#" data-rating-value="2" data-rating-text="5"></a><div class="br-current-rating">1</div></div></div></div><p class="ps-product__price">NPR 3,000</p></div><div class="ps-product__content hover"><a class="ps-product__title" href="'+url+'">'+title+'</a><p class="ps-product__price">NPR 3000</p></div></div></div></div>';
            listhtml = '<div class="ps-shopping-product"><div class="ps-product ps-product--wide"><div class="ps-product__thumbnail"><a href="'+url+'"><img src="/uploads/products/'+value.images[0].images[0].image+'" alt=""></a></div><div class="ps-product__container"><div class="ps-product__content"><a class="ps-product__title" href="'+url+'">'+title+'</a><div class="ps-product__rating"><div class="br-wrapper br-theme-fontawesome-stars"><select class="ps-rating" data-read-only="true" style="display: none;"><option value="1">1</option><option value="1">2</option><option value="1">3</option><option value="1">4</option><option value="2">5</option></select><div class="br-widget br-readonly"><a href="#" data-rating-value="1" data-rating-text="1" class="br-selected br-current"></a><a href="#" data-rating-value="1" data-rating-text="2" class="br-selected br-current"></a><a href="#" data-rating-value="1" data-rating-text="3" class="br-selected br-current"></a><a href="#" data-rating-value="1" data-rating-text="4" class="br-selected br-current"></a><a href="#" data-rating-value="2" data-rating-text="5"></a><div class="br-current-rating">1</div></div></div>NPR 2,000</div><p class="ps-product__vendor">Category:<a href="#">'+value.category.name+'</a></p><span style="min-height:50px">'+description+'</span></div><ul class="ps-product__actions"><li><a class="btn-quick-view" value="'+value.id+'" data-toggle="modal" data-target="#product-quickview"><i class="icon-eye"></i> </a></li><li><a href="#"><i class="icon-heart"></i></a></li></ul></div></div></div>';
            });
            $("#product-data").append(html);
            $("#list-product-data").append(listhtml);
         }
      });
	}
</script>
