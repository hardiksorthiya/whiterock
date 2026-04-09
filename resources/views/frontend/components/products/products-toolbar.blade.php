{{-- $toolbarLabel, $sort, $perPage --}}
<div class="products-toolbar row align-items-center g-3 mb-4">
    <div class="col-12 col-lg-auto">
        <div class="products-toolbar__badge text-center text-lg-start fw-semibold px-3 py-2 rounded-2 bg-light border">
            {{ $toolbarLabel ?? 'All products' }}
        </div>
    </div>
    <div class="col-12 col-lg d-flex flex-wrap align-items-center justify-content-lg-center gap-2">
        <span class="small text-muted text-uppercase fw-semibold me-1 d-none d-md-inline">View</span>
        <div class="btn-group products-view-toggle shadow-sm" role="group" aria-label="Product layout">
            <button type="button" class="btn btn-outline-secondary products-view-btn px-3" data-products-view="grid-3"
                title="Grid (3 columns)">
                <i class="bi bi-grid-3x3-gap"></i>
            </button>
            <button type="button" class="btn btn-outline-secondary products-view-btn px-3" data-products-view="grid-4"
                title="Grid (4 columns)">
                <i class="bi bi-grid-fill"></i>
            </button>
            <button type="button" class="btn btn-outline-secondary products-view-btn px-3" data-products-view="grid-2"
                title="Larger cards">
                <i class="bi bi-layout-split"></i>
            </button>
            <button type="button" class="btn btn-outline-secondary products-view-btn px-3" data-products-view="list"
                title="List view">
                <i class="bi bi-list-ul"></i>
            </button>
        </div>
    </div>
    <div class="col-12 col-lg-auto">
        <form method="get" action="{{ url()->current() }}" class="d-flex flex-wrap gap-2 align-items-center justify-content-lg-end">
            <div class="d-flex align-items-center gap-2">
                <label class="small text-muted mb-0 text-nowrap">Show</label>
                <select name="per_page" class="form-select form-select-sm products-toolbar__select" style="width: auto; min-width: 4.5rem;"
                    onchange="this.form.submit()">
                    @foreach ([12, 24, 48] as $n)
                        <option value="{{ $n }}" @selected((int) $perPage === $n)>{{ $n }}</option>
                    @endforeach
                </select>
            </div>
            <div class="d-flex align-items-center gap-2">
                <label class="small text-muted mb-0 text-nowrap d-none d-sm-inline">Sort</label>
                <select name="sort" class="form-select form-select-sm products-toolbar__select" style="min-width: 10rem;"
                    onchange="this.form.submit()">
                    <option value="latest" @selected($sort === 'latest')>Newest first</option>
                    <option value="name_asc" @selected($sort === 'name_asc')>Name A–Z</option>
                    <option value="name_desc" @selected($sort === 'name_desc')>Name Z–A</option>
                </select>
            </div>
        </form>
    </div>
</div>
