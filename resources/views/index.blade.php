@include('head')
       @include('nav')
  <div class="carousel">
                        @php
                   $sliders = \App\slider::all();
                  @endphp
            <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-ride="carousel">
              <ol class="carousel-indicators">
                                    @foreach($sliders as $slider)
                <li data-target="#carouselExampleIndicators" data-slide-to="{{$loop->index}}" @if($loop->first) class="active" @endif></li>
                                @endforeach
              </ol>
              <div class="carousel-inner">

                  @foreach($sliders as $slider)
                <div class="carousel-item @if($loop->first) active @endif">
                  <div class="carousel-img" style="background-image:url({{asset('uploads/slider/'.$slider->image)}})"></div>
                  <div class="carousel-caption">
                     <h1 class="animated fadeInLeft">{{$slider->title}}</h1>
                     <h5 class="animated fadeInUp">{{$slider->subtitle}}</h5>
                  </div>
                </div>
         @endforeach
              </div>
              <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
            </div>
<!--      <div class="headoverlay"></div>-->
        </div>
    </header>
    <section>
        <div class="container">
             @php
                  $home_second = \App\home_second::find(1);
               @endphp
            <div class="section-title">
                <h2>{{$home_second->title ?? ''}}</h2>
                <hr class="center">
                <p>{{$home_second->subtitle ?? ''}}</p>
            </div>
            <div class="row hover-effects image-hover">
              <div class="col-lg-4 image-box">
                <figure><img src="{{asset('uploads/home_second_section/'.$home_second->firstImage)}}" alt=""/></figure>

              </div>
              <div class="col-lg-4 image-box">
                <figure><img src="{{asset('uploads/home_second_section/'.$home_second->secondImage)}}" alt=""/></figure>

              </div>
              <div class="col-lg-4 image-box">
                <figure><img src="{{asset('uploads/home_second_section/'.$home_second->thiedImage)}}" alt=""/></figure>

              </div>
            </div>
        </div>

        <div class="container-fluid inner-color" style="margin:0px;">
            <div class="container">
                <div class="row">
                  <div class="col-lg-4">
                    <div class="aside-left">
                        @php
                          $services = \App\services::all()->take(3);
                        @endphp
                            @php
                          $lastservices = \App\services::orderBy('id','DESC')->get()->take(3);
                        @endphp
                        @foreach($services as $service)
                        <div class="icon-lists">
                            <div class="icon-text">
                                <h3>{{$service->title}}</h3>
                                <p>{{$service->description}}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <figure class="center-pic"><img src="{{asset('images/1.png')}}" alt=""></figure>
                  </div>
                  <div class="col-lg-4">
                    <div class="aside-right">
                         @foreach($lastservices as $service)
                        <div class="icon-lists">

                            <div class="icon-text">
                                <h3>{{$service->title}}</h3>
                                <p>{{$service->description}}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                  </div>
                </div>
            </div>
        </div>
        {{--
        <div class="container">
            <div class="section-title">
                <h2>{{__('main.Our Trainers')}}</h2>
                <hr class="center">
                <p></p>
            </div>

                <div class="trainers-carousel">
                    <div class="row">
                        @php
                        $trainers = \App\trainers::all();
                        @endphp
                        @foreach($trainers as $trainer)
              <div class="col-lg-4 profile-card"><div class="gallery-cell">
                <div class="team-box">
                    <figure class="avatar"><img src="{{asset('uploads/trainers/'. $trainer->image)}}" alt=""></figure>
                    <div class="team-social lineal">
                         @if($trainer->facebook)
                        <div class="circle-icon">
                            <a href="{{$trainer->facebook}}"><div class="center-fa"><i class="fa fa-facebook" aria-hidden="true"></i></div></a>
                        </div>
                        @endif
                        @if($trainer->twitter)
                        <div class="circle-icon">
                            <a href="{{$trainer->twitter}}"><div class="center-fa"><i class="fa fa-twitter" aria-hidden="true"></i></div></a>
                        </div>
                        @endif
                         @if($trainer->insta)
                        <div class="circle-icon">
                            <a href="{{$trainer->insta}}"><div class="center-fa"><i class="fa fa-instagram" aria-hidden="true"></i></div></a>
                        </div>
                        @endif
                    </div>
                    <div class="figure-caption">
                         <h4>{{$trainer->name}}</h4>
                        <h5 class="trainer-tittle">{{$trainer->jobTitle}}</h5>
                        <p>{{$trainer->desc}}</p>
                    </div>
                </div>
              </div></div>
                        @endforeach
                    </div>
            </div>
        </div> --}}

        <div class="container-fluid parallax" style="background-image:url({{asset('images/3.jpg')}});margin-top: 0;">

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
