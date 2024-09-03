<x-layout>
    <h3 class="mt-5">
        Box Pattern Edit
    </h3>
    <div class="card">
        <div class="card-body">
            <form action="{{route('units.update',$unit)}}" method="post">
                @csrf
                @method('put')
                @include('pages.units.form',$unit)
            </form>
        </div>
    </div>
</x-layout>