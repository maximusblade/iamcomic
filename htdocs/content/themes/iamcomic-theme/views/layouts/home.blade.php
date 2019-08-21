<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>

        @include('includes.head')

        <script>
            $(document)
              .ready(function() {
                $('.special.card .image').dimmer({
                  on: 'hover'
                });
                $('.star.rating')
                  .rating()
                ;
                $('.card .dimmer')
                  .dimmer({
                    on: 'hover'
                  })
                ;
              })
            ;
            </script>

    </head>
    <body>
        <main id="crawler-app" class="ui container">

            <div class="ui inverted menu">
  <div class="header item">Brand</div>
  <div class="active item">Link</div>
  <a class="item">Link</a>
  <div class="ui dropdown item" tabindex="0">
    Dropdown
    <i class="dropdown icon"></i>
    <div class="menu" tabindex="-1">
      <div class="item">Action</div>
      <div class="item">Another Action</div>
      <div class="item">Something else here</div>
      <div class="divider"></div>
      <div class="item">Separated Link</div>
      <div class="divider"></div>
      <div class="item">One more separated link</div>
    </div>
  </div>
  <div class="right menu">
    <div class="item">
      <div class="ui transparent inverted icon input">
        <i class="search icon"></i>
        <input type="text" placeholder="Search">
      </div>
    </div>
    <a class="item">Link</a>
  </div>
</div>

            <div class="ui three stackable cards">


                @foreach ($comics as $comic)
                    
                    <div class="ui card">
                        <div class="image"> 
                            <img loading="lazy" src="{{ $comic->img }}">
                        </div>

                        <div class="content">

                            <div class="header">
                                {{ $comic->name }}
                            </div>

                            {{-- <div class="description">
                                One or two sentence description that may go to several lines
                            </div> --}}
                        </div>

                    </div>

                @endforeach

            </div>



        </main>
    </body>

    <script src="{{ $theme->getUrl('assets/js/theme.min.js') }}" type="text/javascript" charset="utf-8"></script>
 
</html>