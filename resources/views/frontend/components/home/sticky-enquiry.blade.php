<button type="button"
    class="home-sticky-enquiry-btn"
    data-bs-toggle="modal"
    data-bs-target="#homeStickyEnquiryModal"
    aria-label="Open enquiry form">
    ENQUIRE NOW
</button>

<div class="modal fade" id="homeStickyEnquiryModal" tabindex="-1" aria-labelledby="homeStickyEnquiryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header">
                <h5 class="modal-title" id="homeStickyEnquiryModalLabel">Enquire Now</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if (session('success'))
                    <div class="alert alert-success mb-3">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('contact.store') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <input type="text" name="name" class="form-control" placeholder="Your Name"
                                value="{{ old('name') }}">
                        </div>
                        <div class="col-md-6">
                            <input type="email" name="email" class="form-control" placeholder="Your Email"
                                value="{{ old('email') }}">
                        </div>
                        <div class="col-md-6">
                            <input type="tel" name="phone" class="form-control" placeholder="Phone Number"
                                value="{{ old('phone') }}">
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="city" class="form-control" placeholder="City"
                                value="{{ old('city') }}">
                        </div>
                        <div class="col-12">
                            <input type="text" name="subject" class="form-control" placeholder="Subject"
                                value="{{ old('subject') }}">
                        </div>
                        <div class="col-12">
                            <textarea name="message" class="form-control" rows="5" placeholder="Your Message">{{ old('message') }}</textarea>
                        </div>
                    </div>

                    <button class="btn btn-dark w-100 mt-4 text-uppercase" type="submit">
                        Send Message
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
