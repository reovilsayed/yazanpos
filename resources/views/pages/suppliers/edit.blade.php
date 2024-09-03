<x-layout>
    <div class="box_model">
        <div class="dash_head">
            <h4>Edit Supplier</h4>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


  <x-supplierform :supplier="$supplier"/>

    </div>
</x-layout>
