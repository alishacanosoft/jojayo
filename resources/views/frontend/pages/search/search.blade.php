<ul class="list-unstyled">
    @foreach ($products as $product)
        <li class="text-left">{{$product->name}}</li>
    @endforeach
</ul>
