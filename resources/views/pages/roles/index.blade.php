<x-layout>
    <div class="dashboard_content_inner" style="margin-bottom: 50px">
        <div class="dashboard_content ps-0 mt-2">
            <div class="dashboard_content_inner">
                <div class="head_row justify-content-between">
                    <div style="float">
                        @if (auth()->user()->role->hasPermissionTo('create role'))
                            <a href="javascript:void(0)" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#create"><svg class="svg-inline--fa fa-plus fa-w-14" aria-hidden="true"
                                    focusable="false" data-prefix="fa" data-icon="plus" role="img"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                    <path fill="currentColor"
                                        d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z">
                                    </path>
                                </svg><!-- <i class="fa fa-plus"></i> Font Awesome fontawesome.com --> Add new
                                Role</a>
                        @endif


                    </div>

                </div>
                <div class="mainData">

                    <div class="tab-content">

                        <div class="tab-pane fade active show" id="list" role="tabpanel"
                            aria-labelledby="list-tab">
                            <table class="list_table all custom-fade-in">
                                <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Display name</th>
                                        <th scope="col">Actions</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $role)
                                        <tr>
                                            <td>
                                                {{ $role->name }}
                                            </td>

                                            <td>
                                                {{ $role->dsiplay_name }}

                                            </td>
                                            <td>
                                                @if (auth()->user()->role->hasPermissionTo('edit role'))
                                                    <a href="{{ route('roles.edit', $role) }}"
                                                        class="btn btn-sm btn-warning h-auto"><svg
                                                            class="svg-inline--fa fa-edit fa-w-18" aria-hidden="true"
                                                            focusable="false" data-prefix="fa" data-icon="edit"
                                                            role="img" xmlns="http://www.w3.org/2000/svg"
                                                            viewBox="0 0 576 512" data-fa-i2svg="">
                                                            <path fill="currentColor"
                                                                d="M402.6 83.2l90.2 90.2c3.8 3.8 3.8 10 0 13.8L274.4 405.6l-92.8 10.3c-12.4 1.4-22.9-9.1-21.5-21.5l10.3-92.8L388.8 83.2c3.8-3.8 10-3.8 13.8 0zm162-22.9l-48.8-48.8c-15.2-15.2-39.9-15.2-55.2 0l-35.4 35.4c-3.8 3.8-3.8 10 0 13.8l90.2 90.2c3.8 3.8 10 3.8 13.8 0l35.4-35.4c15.2-15.3 15.2-40 0-55.2zM384 346.2V448H64V128h229.8c3.2 0 6.2-1.3 8.5-3.5l40-40c7.6-7.6 2.2-20.5-8.5-20.5H48C21.5 64 0 85.5 0 112v352c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V306.2c0-10.7-12.9-16-20.5-8.5l-40 40c-2.2 2.3-3.5 5.3-3.5 8.5z">
                                                            </path>
                                                        </svg></a>
                                                @endif
                                                @if (auth()->user()->role->hasPermissionTo('delete role'))
                                                    <x-actions.delete :action="route('roles.destroy', $role)" />
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>




    </div>

    <div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="create" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="">Create Role</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('roles.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <x-form.input name="name" :value="old('name')" label="Name" id="name" required />
                        <x-form.input name="display_name" :value="old('display_name')" label="Display Name" id="display_name"
                            required />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>
