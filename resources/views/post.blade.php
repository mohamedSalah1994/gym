@include('head')   
   @include('nav')
 <div class="pages-header" style="background-image:url({{asset('images/5.jpg')}})">
            <div class="container">
                <div class="pages-title">
                 <h4>{{__('main.posts')}}</h4>
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
                <div class="post-content">
                    <div class="post-caption-image">
                      <figure><img src="{{asset('uploads/'. $post->image)}}" alt=""></figure>
                      <div class="date-label">
                        <h6 style="direction:ltr">{{\Carbon\Carbon::parse($post->created_at)->format('d M. yy')}}</h6>
                      </div>
                    </div>  
                    <div class="fig-caption">
                        <h2 class="post_single_title">{{$post->title}}</h2>
                        <div class="post-preview-details">
                        </div>
                        <div class="post-text">
                           {!! $post->content !!}
                        </div>
                    </div> 
                  
                </div>
              </div>
</div>

</div>
    </section>
@include('footer')