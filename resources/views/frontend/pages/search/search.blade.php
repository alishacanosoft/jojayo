
@if(!$products->isEmpty())
<ul class="list-unstyled result">
    @foreach ($products as $product)
        <li class="text-left">{{ucwords($product->name)}}</li>
    @endforeach
   
</ul>
@else
<ul class="list-unstyled no-result">
    <li class="text-left">No Result Found</li>
</ul>
@endif
