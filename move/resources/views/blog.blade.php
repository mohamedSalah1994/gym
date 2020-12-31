@include('head')   
   @include('nav')
 <div class="pages-header" style="background-image:url({{asset('images/5.jpg')}})">
            <div class="container">
                <div class="pages-title">
               <h4>{{__('main.Blogs')}}</h4>
<!--                    <p>Fitness is not a destination it is a way of life.</p>-->
                </div>
            </div>
        </div>
    </header>
   <section>
<div class="container  @if(app()->getLocale() == 'ar') rtlpage @endif">
<div class="row">
    @include('post_sidebar')
<div class="col-lg-9">
                      @foreach($posts as $post)
                  <div class="posts-list">
                    <div class="post-preview-image">
                      <figure><img src="{{asset('uploads/'. $post->image)}}" alt=""></figure>
                      <div class="date-label">
                          <h6 style="direction:ltr;">{{\Carbon\Carbon::parse($post->created_at)->format('d M. yy')}}</h6>
                      </div>
                    </div>  
                    <div class="fig-caption" style="font-size: 19px;text-align:right">
                        <h2 style="text-align:right">{{$post->title}}</h2>
                        <div class="post-preview-details">
<!--                           <p>By: Jessica Doe &nbsp; / &nbsp; gym, fitness &nbsp; / &nbsp; 190 Comments </p> -->
                        </div>
                        {{\Illuminate\Support\Str::limit(strip_tags($post->content),100,'...')}}
                        <a style="display:block" href="{{route('post.show',$post->slug)}}">{{__('posts.readMore')}}</a>
                    </div>
                  </div>
        @endforeach
              </div>
</div>

</div>
    </section>
@include('footer')