<div>
    @if (request()->has('filter') || request()->has('order') || request()->has('search'))
        <a class="btn btn-sm btn-danger h-auto p-2" style="position: fixed;bottom:20px;right:60px" type="button"
            href="{{ $url }}">
            <i class="fa fa-undo"></i>
        </a>
    @endif
    <button class="btn btn-sm btn-dark h-auto p-2" style="position: fixed;bottom:20px;right:20px" type="button"
        data-bs-toggle="offcanvas" data-bs-target="#offcanvasFilter" aria-controls="offcanvasFilter">
        <i class="fa fa-filter"></i>
    </button>
    <div class="offcanvas offcanvas-end" id="offcanvasFilter" aria-labelledby="offcanvasFilterLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasFilterLabel">Search & Filter</h5>
            <button type="button" class="h-auto btn-outline-dark btn-sm text-reset" data-bs-dismiss="offcanvas"
                aria-label="Close"> <i class="fa fa-times"></i></button>
        </div>
        <div class="offcanvas-body">
            <form action="{{ $url }}">
                {{ $slot }}

                <button class="btn btn-dark btn-sm h-auto float-end p-2">
                    <i class="fa fa-filter"></i> Filter
                </button>
            </form>
        </div>
    </div>
</div>
