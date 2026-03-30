<section class="sorath-section py-5">
    <div class="container">
        <div class="row align-items-center position-relative">

            <!-- Left Image -->
            <div class="col-lg-6 col-md-6">
                <div class="sorath-image-wrapper">
                    <img src="{{ asset('images/h1.jpg') }}" class="img-fluid" alt="Interior">
                </div>

                <!-- Watch Video -->
                <div class="sorath-watch-video d-flex align-items-center">
                    <div class="sorath-play-btn">
                        ▶
                    </div>
                    <span class="ms-3">WATCH VIDEO</span>
                </div>
            </div>

            <!-- Right Content -->
            <div class="col-lg-6 col-md-6">
                <div class="sorath-content-box shadow">
                    <p class="sorath-small-title">/ WELCOME TO WHITEROCK</p>
                    <h2 class="sorath-title">
                        STYLISH DESIGNS,<br>INNOVATIVE IDEAS
                    </h2>
                    <p class="sorath-desc">
                        Far far away, behind the word mountains, far from the countries
                        Vokalia and Consonantia, there live the blind texts.
                    </p>
                    <a href="{{ route('about') }}" class="btn btn-dark mt-3">READ MORE</a>
                </div>

                <!-- Counters -->
                <div class="row text-center mt-4">
                    <div class="col-5">
                        <h3 class="sorath-counter-title">
                            <span class="sorath-counter" data-count="20">0</span>+
                        </h3>
                        <p class="sorath-counter-text">Years of Experience</p>
                    </div>
                    <div class="col-6">
                        <h3 class="sorath-counter-title">
                            <span class="sorath-counter" data-count="1375">0</span>+
                        </h3>
                        <p class="sorath-counter-text">Projects Completed</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


    <script>
document.addEventListener("DOMContentLoaded", () => {
    const counters = document.querySelectorAll('.sorath-counter');

    counters.forEach(counter => {
        counter.innerText = '0';

        const updateCounter = () => {
            const target = +counter.getAttribute('data-count');
            const count = +counter.innerText;

            const increment = target / 100;

            if (count < target) {
                counter.innerText = Math.ceil(count + increment);
                setTimeout(updateCounter, 20);
            } else {
                counter.innerText = target;
            }
        };

        updateCounter();
    });
});
</script>