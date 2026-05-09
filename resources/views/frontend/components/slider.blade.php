<div id="heroSlider" class="carousel slide hero-slider" data-bs-ride="carousel">

    <!-- Indicators -->
    <div class="carousel-indicators">
        @foreach($sliders as $slider)
            <button type="button"
                    data-bs-target="#heroSlider"
                    data-bs-slide-to="{{ $loop->index }}"
                    class="{{ $loop->first ? 'active' : '' }}">
            </button>
        @endforeach
    </div>

    <div class="carousel-inner">

        @foreach($sliders as $slider)
        @php
            $bgDesktop = asset('storage/'.$slider->image);
            $bgMobile = $slider->image_mobile ? asset('storage/'.$slider->image_mobile) : $bgDesktop;
            $slideAlt = filled($slider->title) ? strip_tags($slider->title) : __('Banner');
        @endphp
        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">

            <div class="hero-slide-bg">
                <picture class="hero-slide-bg__media">
                    <source media="(min-width: 768px)" srcset="{{ $bgDesktop }}">
                    <img class="hero-slide-bg__img"
                        src="{{ $bgMobile }}"
                        alt="{{ $slideAlt }}"
                        loading="{{ $loop->first ? 'eager' : 'lazy' }}"
                        @if ($loop->first) fetchpriority="high" @endif
                        decoding="async">
                </picture>
                <div class="hero-slide-bg__overlay">
                    <div class="container">

                    @if (filled($slider->title))
                        <h1>{{ $slider->title }}</h1>
                    @endif
                    @if (filled($slider->description))
                        <p>{{ $slider->description }}</p>
                    @endif

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
