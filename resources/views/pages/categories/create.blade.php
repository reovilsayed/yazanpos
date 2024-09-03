<x-layout>

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
    
    <div class="card mt-4">
        <div class="card-body">
            <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="">
                    <h3>Create Category</h3>
                    <div class="item-content">
                        <div class="mb-3">
                            <label for="inputName1" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="inputName1" placeholder="Categorie Name"
                                data-name="name" name="name">
                        </div>
                    </div>
                    <div class="item-content">
                        <div class="mb-3">
                            <label for="inputName2" class="form-label">Image</label>
                            <input type="file" class="form-control" id="inputName2" placeholder="Categorie Name"
                                data-name="name" name="image">
                        </div>
                    </div>
                    <!-- Repeater Remove Btn -->
                    <div class="repeater-remove-btn">
                        <button type="submit" class="btn btn-success" style="height: auto;">Submit</button>
                        <a href="{{ route('categories.index') }}" class="btn btn-danger">Cancle</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

</x-layout>
