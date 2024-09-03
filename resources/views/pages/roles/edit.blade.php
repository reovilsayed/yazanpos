<x-layout>
    <style>
        ul {
            list-style-type: none;
            padding-left: 0;
        }

        li {
            margin-bottom: 10px;
        }

        label {
            font-weight: 500;
            color: #343a40;
            cursor: pointer;
        }

        ul ul {
            margin-left: 20px;
        }
    </style>
    <div class="dash_head m-3">
        <h4>Edit Role</h4>


    </div>
    <div class="card p-4">
        <form action="{{ route('roles.update', $role) }}" method="post">
            @csrf
            @method('put')
            <div class="row">
                <div class="col-md-6">

                    <x-form.input name="name" :value="$role->name" label="Name" id="name" required />
                </div>
                <div class="col-md-6">

                    <x-form.input name="display_name" :value="$role->dsiplay_name" label="Display Name" id="display_name"
                        required />
                </div>
            </div>

            {{-- <ul>
                @foreach ($permissions as $key => $items)
                    
       
                <li>
                    <div class="form-check">
                        <input class="form-check-input position-static" type="checkbox" id="parent_checkbox"
                            value="option1" aria-label="...">
                        <label for="">{{$key}}</label>
                    </div>
                </li>
                @foreach ($items as $permission)
                    
                <li>
                    <ul>
                        <li>
                            <div class="form-check">
                                <input class="child-checkbox-{{$key}} form-check-input position-static" type="checkbox" id="{{$permission->name }}"
                                    value="{{$permission->name }}" aria-label="..." name="permissions[{{$key}}][{{$permission->name }}]"  @if ($role->hasPermissionTo($permission->name)) checked @endif>
                                <label for="{{$permission->name }}">{{$permission->name }}</label>
                            </div>
                        </li>
              
                
                    </ul>
                </li>
                @endforeach
                @endforeach
            </ul> --}}
             <div class="container card my-3">
                <table class="table">

                    <tbody>
                        @foreach ($permissions as $key => $items)
                            <tr>
                                <td>
                                    <p class="" style="font-weight: 700">{{ $key }}</p>
                                </td>
                                @foreach ($items as $permission)
                                    <td>
                                        <div class="form-check">
                                            <input
                                                class="child-checkbox-{{ $key }} form-check-input position-static {{$role->hasPermissionTo($permission->name) ? 'border-primary' : 'border-danger'}} "
                                                type="checkbox" id="{{ $permission->name }}" value="{{ $permission->name }}"
                                                aria-label="..."
                                                name="permissions[{{ $key }}][{{ $permission->name }}]"
                                                @if ($role->hasPermissionTo($permission->name)) checked @endif>
                                            <label for="{{ $permission->name }}"
                                                class="form-label {{$role->hasPermissionTo($permission->name) ? 'text-primary' : 'text-danger'}}">{{ $permission->name }}</label>
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
    
    
                    </tbody>
                </table>
             </div>
            <button class="btn btn-primary" type="submit">Save</button>

        </form>

    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Select all parent checkboxes
            const parentCheckboxes = document.querySelectorAll('#parent_checkbox');

            parentCheckboxes.forEach(parentCheckbox => {
                // Attach event listener to each parent checkbox
                parentCheckbox.addEventListener('change', function() {
                    // Get the key (group) associated with this parent checkbox
                    const key = this.nextElementSibling.innerText.trim();

                    // Find all child checkboxes in this group
                    const childCheckboxes = document.querySelectorAll(`.child-checkbox-${key}`);

                    // Set the checked status of each child checkbox based on the parent checkbox's checked status
                    childCheckboxes.forEach(childCheckbox => {
                        childCheckbox.checked = this.checked;
                    });
                });
            });
        });
    </script>

</x-layout>
