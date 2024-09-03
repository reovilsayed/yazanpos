<x-layout>

    <div class="card mt-4">
        <div class="card-body">
            <form action="{{ route('categories.update', $category) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div>
                    <h3>Edit Category</h3>
                    <div class="mb-3">
                        <label for="disabledTextInput" class="form-label">Categorie Name</label>
                        <input type="text" id="disabledTextInput" class="form-control" placeholder="Disabled input"
                            name="name" value="{{ $category->name }}">
                    </div>
                    <div class="mb-3">
                        <label for="disabledTextInput1" class="form-label">Image</label>
                        <input type="file" id="disabledTextInput1" class="form-control" placeholder="Disabled input"
                            name="image" value="{{ $category->image }}">
                    </div>

                    <div class="repeater-remove-btn">
                        <button type="submit" class="btn btn-success" style="height: auto;">Submit</button>
                        <a href="{{ route('categories.index') }}" class="btn btn-danger">Cancle</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

</x-layout>
