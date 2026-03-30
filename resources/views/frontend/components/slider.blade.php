<div id="heroSlider" class="carousel slide" data-bs-ride="carousel">

    <!-- Indicators -->
    <div class="carousel-indicators">
        @foreach($sliders as $key => $slider)
            <button type="button"
                    data-bs-target="#heroSlider"
                    data-bs-slide-to="{{ $key }}"
                    class="{{ $key == 0 ? 'active' : '' }}">
            </button>
        @endforeach
    </div>

    <div class="carousel-inner">

        @foreach($sliders as $key => $slider)
        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">

            <div style="
                background-image:url('{{ asset('storage/'.$slider->image) }}');
                background-size: cover;
                background-position: center;
                display:flex;
                align-items:center;
                color:white;
                height:750px;
            ">
                <div class="container">

                    <h1>{{ $slider->title }}</h1>
                    <p>{{ $slider->description }}</p>

                    @if($slider->show_button)
                        <a href="{{ $slider->button_link }}" class="btn btn-light">
                            {{ $slider->button_text }}
                        </a>
                    @endif

                    @if($slider->show_video)
                        <a href="{{ $slider->video_link }}" class="btn btn-outline-light ms-2">
                            ▶ Play
                        </a>
                    @endif

                </div>
            </div>

        </div>
        @endforeach

    </div>

    <!-- Navigation -->
    <button class="carousel-control-prev" type="button" data-bs-target="#heroSlider" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>

    <button class="carousel-control-next" type="button" data-bs-target="#heroSlider" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>

</div>