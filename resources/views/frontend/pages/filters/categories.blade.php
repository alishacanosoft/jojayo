<aside class="widget widget_shop">
    <h4 class="widget-title">Categories</h4>
    <ul class="ps-list--categories">
        @if ($cat['secondary'])
        @foreach ($cat['cat'] as $category)
        <li class="current-menu-item menu-item-has-children">
            <a href="{{route('categories', $category->slug)}}">{{$category->name}}</a>
            <span class="sub-toggle">
                <i class="fa fa-angle-down"></i>
            </span>
            <ul class="sub-menu">
                @foreach ($category->FinalCategory as $final)
                <li class="current-menu-item ">
                    <a href="{{route('categories.sec',[$cat['primary_slug'], $final->slug])}}">{{$final->name}}</a>
                </li>
                @endforeach
            </ul>
        </li>
        @endforeach
        @endif
        @if (!$cat['secondary'])
        @foreach ($cat['cat'] as $category)
        <li class="current-menu-item menu-item-has-children">
            <a href="{{route('categories.sec',[$cat['primary_slug'], $category->slug])}}">{{$category->name}}</a>
        </li>
        @endforeach

        @endif
    </ul>
</aside>
