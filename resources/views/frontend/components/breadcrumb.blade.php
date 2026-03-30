<section class="breadcrumb-section" 
    style="background-image: url('{{ $image ?? asset('default.jpg') }}');">

    <div class="breadcrumb-overlay"></div>

    <div class="container">
        <div class="breadcrumb-content text-center">

            <h1>{{ $title ?? 'Page Title' }}</h1>

            @if(isset($subtitle))
                <p>{{ $subtitle }}</p>
            @endif

        </div>
    </div>

</section>