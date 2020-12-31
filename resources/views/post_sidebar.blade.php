<div class="col-lg-3">
                <aside class="blogs-right-side">
                    <div class="inner-sidebar">
                        <h5>{{__('posts.Categories')}}</h5>  
                        <hr class="short">
                        <ul class="list-group list-group-flush">
                            @php
                            $cats = \App\categories::all();
                            @endphp
                            @foreach($cats as $cat)
                              <li class="list-group-item"><a href="{{route('catBySlug',$cat->slug)}}">{{$cat->name}}</a></li>
                            @endforeach
                        </ul>
                      </div>
                      <div class="inner-sidebar">
                          <h5>{{__('posts.RECENT NEWS')}}</h5>
                          <hr class="short">
                                @php
                            $latestPosts = \App\posts::orderBy('id','DESC')->get()->take(4);
                            @endphp
                          @foreach($latestPosts as $post)
                          <div class="media-list">
                            <div class="media-post">
                                <figure class="media-thumb"><a href="{{route('post.show',$post->slug)}}"><img style="width:100%;" src="{{asset('uploads/'. $post->image)}}" alt=""></a></figure>
                              <div class="media-caption">
                                <h5><a href="{{route('post.show',$post->slug)}}">{{$post->title}}</a></h5> 
                                <p style="direction:ltr">{{\Carbon\Carbon::parse($post->created_at)->format('d M. yy')}}</p>
                              </div>
                            </div>
                          </div>
                          @endforeach
                      </div>
                    <div class="inner-sidebar">
                        <h5>{{__('posts.TAGS')}}</h5>
                        <hr class="short">
                        <div class="tags-lists">
                              @php
                            $tags = \App\tags::all();
                            @endphp
                            @foreach($tags as $tag)
                            <button class="btn btn-custom btn-tags" type="submit"><i class="fa fa-tags" aria-hidden="true"></i> {{$tag->name}}</button>
                            @endforeach
                        </div>
                    </div>
                </aside>  
              </div>