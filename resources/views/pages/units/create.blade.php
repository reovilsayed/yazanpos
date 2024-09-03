<x-layout>
    <h3 class="mt-5">
        Create Box Pattern
    </h3>
    <div class="card">
        <div class="card-body">
            <form action="{{route('units.store')}}" method="post">
                @csrf
                @include('pages.units.form',$unit)
            </form>
        </div>
    </div>
</x-layout>