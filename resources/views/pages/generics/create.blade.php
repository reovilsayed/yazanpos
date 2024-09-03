<x-layout>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
    <form class="row" method="post" action="{{ route('generics.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="container mt-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="dash_head">Generic Details</h6>
                    <div class="row row-cols-3">

                        <div class="form-group col-md-12">
                            <x-form.input name="name" wire:model="name" label="Name *" value="" autofocus
                                required />
                            <x-form.input name="description" wire:model="description" id="description" value="" type="textarea"
                                label="Description *" />
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <button type="submit" class="btn btn-success mt-3" style="float: right">
                                <i class="fa fa-save"></i> Save
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>




    </form>
    @push('script')
    
    <script>
        $(document).ready(function() {
      $('#description').summernote({
        height: 100,
        placeholder: 'Enter your description',
        toolbar: [
              ['style', ['style']],
              ['font', ['bold', 'underline', 'clear']],
              ['color', ['color']],
              ['para', ['ul', 'ol', 'paragraph']],
              ['table', ['table']],
              ['insert', ['link', 'picture', 'video']],
              ['view', ['fullscreen', 'codeview', 'help']]
            ]
      });
    });
    </script>
    @endpush

</x-layout>
