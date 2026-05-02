<div class="modal fade" id="catalogueDownloadModal" tabindex="-1" aria-labelledby="catalogueDownloadModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow catalogue-download-modal">
            <div class="modal-header border-0 pb-0">
                <div>
                    <h5 class="modal-title mb-1" id="catalogueDownloadModalLabel">Download catalogue</h5>
                    <p class="small text-muted mb-0" id="catalogueDownloadCatalogueLabel"></p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="catalogueDownloadForm" method="POST" action="{{ route('catalogue.download') }}" novalidate>
                @csrf
                <input type="hidden" name="catalogue_id" id="catalogueDownloadCatalogueId" value="">
                <div class="modal-body pt-2">
                    <p class="small text-secondary mb-3">Please share your details to open the PDF. We may follow up
                        regarding products relevant to you.</p>
                    <div id="catalogueDownloadFormError" class="alert alert-danger py-2 small d-none" role="alert"></div>
                    <div class="mb-3">
                        <label for="catalogueDownloadName" class="form-label">Name</label>
                        <input type="text" id="catalogueDownloadName" name="name" class="form-control" required
                            maxlength="255" autocomplete="name">
                    </div>
                    <div class="mb-3">
                        <label for="catalogueDownloadEmail" class="form-label">Email</label>
                        <input type="email" id="catalogueDownloadEmail" name="email" class="form-control" required
                            maxlength="255" autocomplete="email">
                    </div>
                    <div class="mb-3">
                        <label for="catalogueDownloadPhone" class="form-label">Phone number</label>
                        <input type="tel" id="catalogueDownloadPhone" name="phone" class="form-control" required
                            maxlength="64" autocomplete="tel">
                    </div>
                    <div class="mb-0">
                        <label for="catalogueDownloadCity" class="form-label">City</label>
                        <input type="text" id="catalogueDownloadCity" name="city" class="form-control" required
                            maxlength="120" autocomplete="address-level2">
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn catalogue-download-modal__submit" id="catalogueDownloadSubmit">
                        Open PDF
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
