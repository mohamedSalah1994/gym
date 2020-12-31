@include('head')   
   @include('nav')
 <div class="pages-header" style="background-image:url({{asset('images/5.jpg')}})">
            <div class="container">
                <div class="pages-title">
                    <h4>{{__('main.packagesPageHead')}}</h4>
<!--                    <p>Fitness is not a destination it is a way of life.</p>-->
                </div>
            </div>
        </div>
    </header>
   <section>

        <div class="container">
            <div class="row justify-content-md-center">
                @php
                $plans = \App\plans::where('status' , 1)->get();
                @endphp
                @foreach($plans as $plan)
              <div class="col-md-4">
                  <div class="pricing-table">
                    <div class="table-header">
                      <h4>{{$plan->name}}</h4>
                      <h2><span>{{__('main.coin')}}</span>{{$plan->price}}</h2>
                    </div>
                    <div class="table-list">
                        @php
                         $months = round($plan->days / 30);
                        @endphp
                        <p>{{__('main.month')}} / {{$months}}</p>  
                    </div>
                    <p>
                        @if(auth()->guard('user')->check())
                        @if(auth()->guard('user')->user()->subscriptionOb && \Carbon\Carbon::parse(auth()->guard('user')->user()->subscriptionOb->end_to) < \Carbon\Carbon::now())
                      <a class="btn btn-custom btn-custom-small bookplannow" data-plan="{{$plan->id}}" action="{{route('subscribe.plan')}}">{{__('main.Renew Package')}}</a>  
                    @elseif(auth()->guard('user')->user()->subscriptionOb && \Carbon\Carbon::parse(auth()->guard('user')->user()->subscriptionOb->end_to) > \Carbon\Carbon::now())
                   <a class="btn btn-custom btn-custom-small bookplannow" data-plan="{{$plan->id}}" action="{{route('subscribe.plan')}}">{{__('main.Add Package')}}</a> 
                   @else
                          <a class="btn btn-custom btn-custom-small bookplannow" data-plan="{{$plan->id}}" action="{{route('subscribe.plan')}}">{{__('main.ORDER NOW')}}</a> 
                   @endif
                  @else
                   <a class="btn btn-custom btn-custom-small bookplannow" data-plan="{{$plan->id}}" action="{{route('subscribe.plan')}}">{{__('main.ORDER NOW')}}</a> 
                  @endif
                        </p>
                  </div>
              </div>
                @endforeach
            </div> 
        </div>
        
       
        
        <div class="container-fluid parallax" style="background-image:url({{asset('images/3.jpg')}});">
 
        </div>
        
        <div class="container filterable-portfolio">
            <div class="section-title">
                <h2>{{__('main.GALLERY')}}</h2>
                <hr class="center">
            </div>
              <ul class="nav nav-pills center-pills portfolio-filter">
                  @php
                   $gallery_cats = \App\gallery_categories::all();
                  @endphp
                    <li role="presentation" class="active"><a href="#" data-filter="*">{{__('main.All')}}</a></li>
                  @foreach($gallery_cats as $cat)
                    <li role="presentation"><a href="#" data-filter=".{{$cat->id}}">{{$cat->name}}</a></li>
                  @endforeach
             </ul>
          <div class="row portfolio-items">
                @foreach($gallery_cats as $cat)
                      @foreach($cat->gallerys as $gallery)
                           <figure class="portfolio-item col-md-4 {{$cat->id}}">
              <div class="magnific-img">
                <a class="image-popup-vertical-fit" href="{{asset('uploads/gallery/'.$gallery->image)}}">
                    <img src="{{asset('uploads/gallery/'.$gallery->image)}}" alt="" />
                </a>
              </div>
            </figure>
                     @endforeach
                  @endforeach
          </div>
        </div>
        
        <div class="container">
            <div class="section-title">
                <h2>{{__('main.Customer Opinions')}}</h2>
                <hr class="center">
                <p></p>
            </div>
            <div class="main-gallery">
                @php
                  $customersComments = \App\customersComments::all();
                @endphp
                @foreach($customersComments as $comment)
                <div class="gallery-cell">
                   <div class="testimonial-section">
                    <div class="author-avatar"><img src="{{asset('uploads/comments/'.$comment->image)}}" alt=""></div>
                    <h3 class="autor">{{$comment->cName}}</h3>
                    <p class="quote">"{{$comment->cComment}}"</p>
                  </div>
                </div>
             @endforeach
            </div>
        </div>
        
        <div class="container-fluid promotion-parallax" style="background-image:url({{asset('images/4.jpg')}});">
          
        </div>
        
        <div class="container">
            <div class="section-title">
                <h2>{{__('main.Latest News')}}</h2>
                <hr class="center">
            </div>
            <div class="row">
                @php
                   $posts = \App\posts::all()->take(3);
                @endphp
                @foreach($posts as $post)
              <div class="col-lg-4">
                <div class="blog-preview">
                  <figure class="thumb-preview"><a href="{{route('post.show',$post->slug)}}">
                      <div class="post-image-preview" style="background-image:url({{asset('uploads/'.$post->image)}})"></div>
                      </a></figure>
                  <div class="fig-caption">
                    <h3><a href="{{route('post.show',$post->slug)}}">{{$post->title}}</a></h3>
                    <p>{{\Illuminate\Support\Str::limit(strip_tags($post->content),100,'...')}}</p>
                    <hr>
                    <div class="preview-post-detalils">
                        <div class="post-categorie-left">
                              @foreach($post->post_cats as $post_cat)
                            <span class="categorie">{{$post_cat->cat_obj->name}}</span>
                                                @endforeach
                           
                        </div> 
                    </div>
                  </div>
                </div>  
              </div>
            @endforeach
            </div>
        </div>
   
    
    </section>
@include('footer')