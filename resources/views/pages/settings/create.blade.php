<x-layout>

    @php
        $currencies = App\Constant\Dataset::CURRENCY;

    @endphp
    <form action="{{ route('settings.store') }}" method="POST" class="row g-3" enctype="multipart/form-data">
        @csrf
        <div class=" dashboard_content_setting">
            <div class="dashboard_content_inner">
                <div class="">
                    <div class="">
                        <div class="box_model">
                            <div class="box_row">
                                <div class="profile_pic_lft">
                                    <div class="">
                                        <div class="row row-cols-1 row-cols-md-2">

                                            <div class="prf_box mt-3">
                                                <div class="prf" data-profile-image>
                                                    <img src="{{ Settings::option('logo') ? Storage::url(Settings::option('logo')) : asset('images/logo.png') }}"
                                                        alt="">
                                                    <span class="prf_pic_change">
                                                        <input type="file" accept="image/*" name="logo"
                                                            id="imageInput" onchange="handleImageSelect()">
                                                        <svg width="20" height="16" viewBox="0 0 20 16"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M17.3365 2.54808H14.3942L13.6933 0.583654C13.6448 0.449234 13.5561 0.333042 13.4392 0.250952C13.3222 0.168861 13.1828 0.124874 13.0399 0.125H6.4024C6.11034 0.125 5.84856 0.308894 5.7512 0.583654L5.04808 2.54808H2.10577C1.14952 2.54808 0.375 3.3226 0.375 4.27885V14.1442C0.375 15.1005 1.14952 15.875 2.10577 15.875H17.3365C18.2928 15.875 19.0673 15.1005 19.0673 14.1442V4.27885C19.0673 3.3226 18.2928 2.54808 17.3365 2.54808ZM9.72115 12.4135C7.80865 12.4135 6.25962 10.8644 6.25962 8.95192C6.25962 7.03942 7.80865 5.49039 9.72115 5.49039C11.6337 5.49039 13.1827 7.03942 13.1827 8.95192C13.1827 10.8644 11.6337 12.4135 9.72115 12.4135ZM7.64423 8.95192C7.64423 9.50276 7.86305 10.031 8.25255 10.4205C8.64205 10.81 9.17032 11.0288 9.72115 11.0288C10.272 11.0288 10.8003 10.81 11.1898 10.4205C11.5793 10.031 11.7981 9.50276 11.7981 8.95192C11.7981 8.40109 11.5793 7.87282 11.1898 7.48332C10.8003 7.09382 10.272 6.875 9.72115 6.875C9.17032 6.875 8.64205 7.09382 8.25255 7.48332C7.86305 7.87282 7.64423 8.40109 7.64423 8.95192Z"
                                                                fill="currentColor" />
                                                        </svg>
                                                    </span>
                                                </div>
                                                <div class="prf_rt">
                                                    <h4>{{ Settings::option('shopName') ? Settings::option('shopName') : old('shopName') }}
                                                    </h4>
                                                    <p>
                                                        <img src="{{ asset('images/email.png') }}" alt="" />
                                                        <a
                                                            href="">{{ Settings::option('email') ? Settings::option('email') : old('email') }}</a>
                                                    </p>
                                                    <p><img src="{{ asset('images/phone.png') }}"
                                                            alt="" />{{ Settings::option('address') ? Settings::option('address') : old('address') }}
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="prf_data_box">
                                                <div class="prf_data_row" data-editable>
                                                    <div class="label">Shop Name</div>
                                                    <div class="input">
                                                        <input type="text"
                                                            value="{{ Settings::option('shopName') ? Settings::option('shopName') : old('shopName') }}"
                                                            placeholder="Shop Name" class="" name="shopName">
                                                    </div>
                                                </div>

                                                <div class="prf_data_row" data-editable>
                                                    <div class="label">Address</div>
                                                    <div class="input">
                                                        <input type="text" placeholder="Address" class=""
                                                            name="address"
                                                            value="{{ Settings::option('address') ? Settings::option('address') : old('address') }}">
                                                    </div>
                                                </div>

                                                <div class="prf_data_row" data-editable>
                                                    <div class="label">Email Address</div>
                                                    <div class="input">
                                                        <input type="text" placeholder="Email Address"
                                                            class="@error('email')
                                                            is-invalid
                                                        @enderror"
                                                            name="email"
                                                            value="{{ Settings::option('email') ? Settings::option('email') : old('email') }}">
                                                        @error('email')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="prf_data_row" data-editable>
                                                    <div class="label">Phone Number</div>
                                                    <div class="input">
                                                        <input type="tel"
                                                            value="{{ Settings::option('phone') ? Settings::option('phone') : old('phone') }}"
                                                            placeholder="Phone Number"
                                                            class="@error('phone')
                                                            is-invalid
                                                            @enderror"
                                                            name="phone">
                                                        @error('phone')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="prf_data_row" data-editable>
                                                    <div class="label">Tax</div>
                                                    <div class="input">
                                                        <input type="text"
                                                            value="{{ Settings::option('tax') ? Settings::option('tax') : old('tax') }}"
                                                            placeholder="Tax"
                                                            class="@error('tax')
                                                                is-invalid
                                                            @enderror"
                                                            name="tax">
                                                        @error('tax')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="prf_data_row" data-editable>
                                                    <div class="label">Currency</div>
                                                    <div class="input">
                                                        <select class="selectize" name="currency">
                                                            @foreach ($currencies as $currency)
                                                                <option value="{{ $currency }}"
                                                                    {{ Settings::option('currency') ? (Settings::option('currency') == $currency ? 'selected' : '') : '' }}>
                                                                    {{ $currency }}</option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="prf_data_row" data-editable>
                                                    <div class="label">Manage Stock</div>
                                                    <div class="input">
                                                        <select class="selectize" name="manageStock">
                                                            <option value="1"
                                                                {{ Settings::option('manageStock') == 1 ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option value="2"
                                                                {{ Settings::option('manageStock') == 2 ? 'selected' : '' }}>
                                                                No</option>
                                                        </select>
                                                    </div>
                                                </div>



                                                <div class="col-12 d-flex justify-content-between mt-2">
                                                    <button class="btn btn-outline-primary h-auto" type="submit"> <i
                                                            class="fa fa-save"></i> Save</button>
                                                    <button type="button" class="btn btn-outline-primary"
                                                        data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                                                        <i class="fa-solid fa-key"></i> Change Password
                                                    </button>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Your Change Password Form -->
                    <form method="POST" action="{{ route('settings.change-password') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" class="form-control" id="current_password"
                                name="current_password" required>
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="new_password" name="new_password"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password"
                                name="confirm_password" required>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                                    class="fa-regular fa-circle-xmark"></i> Close</button>
                            <button type="submit" class="btn btn-outline-primary">
                                <i class="fa-solid fa-key"></i> Change Password
                            </button>
                        </div>
                    </form>
                    <!-- End of Change Password Form -->
                </div>
            </div>
        </div>
    </div>
</x-layout>
