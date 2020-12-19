<aside class="widget widget--blog widget--search">
              <form class="ps-form--widget-search" action="#" method="get">
                <input class="form-control" type="text" placeholder="Search...">
                <button><i class="icon-magnifier"></i></button>
              </form>
            </aside>
            <aside class="widget widget--blog widget--categories">
              <h3 class="widget__title">Categories</h3>
              <div class="widget__content">
              @if(!empty($bcategories))
                <ul>
               @foreach($bcategories as $bcategory)
               <li><a href="{{url('/blogs/categories/'.$bcategory->slug)}}">{{ucwords($bcategory->name)}}</a></li>
                  @endforeach
                </ul>
              @endif
              </div>
            </aside>
            <aside class="widget widget--blog widget--categories">
              <h3 class="widget__title">Recent Posts</h3>
              <div class="widget__content">
              @if(!empty($latestPosts))
              <ul>
               @foreach($latestPosts as $latest)
               <li><a href="{{url('/blogs/'.$latest->slug)}}">{{ucwords($latest->title)}}</a></li>
              @endforeach
              </ul>
              @endif
              </div>
            </aside>