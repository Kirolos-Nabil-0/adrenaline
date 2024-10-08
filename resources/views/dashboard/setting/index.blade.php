@extends('layouts.master')
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!-- Internal Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection

@section('content')

    <br>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session()->has('Add'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Add') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session()->has('delete'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('delete') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session()->has('edit'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('edit') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <form action="{{ route('setting.update') }}" method="post" enctype="multipart/form-data">
        {{ method_field('put') }}
        {{ csrf_field() }}
        <!-- row -->
        <p></p>
        <div class="row row-sm">
            @if ($user->type == 'showroom' || $user->type == 'admin')
                <!-- Col -->
                <div class="col-lg-4">

                    <div class="card mg-b-20">
                        <div class="card-body">
                            <div class="pl-0">
                                <div class="main-profile-overview">
                                    <input type="text" value="{{ $user->id }}" name="user_id" hidden>
                                    <div class="main-img-user profile-user">
                                        <h4>صورة الشعار</h4>
                                        <img id="profile-image" alt=""
                                            src="{{ URL::asset($setting->logo ?? '') }}">
                                        <label for="image-upload" class="fas fa-camera profile-edit"></label>
                                        <input id="image-upload" type="file" style="display: none;" name="image">
                                    </div>
                                    <hr class="mg-y-30">

                                    <div class="image-container">
                                        <h4>صورة الخلفية</h4>
                                        <img id="background-image" alt=""
                                            src="{{ URL::asset($setting->background_image ?? '') }}">
                                        <label for="background_image" class="fas fa-camera profile-edit"></label>
                                        <input id="background_image" type="file" style="display: none;"
                                            name="background_image">
                                    </div>

                                    <hr class="mg-y-30">

                                    <div class="d-flex justify-content-between mg-b-20">
                                        <div>
                                            <h5 class="main-profile-name">المعرض باللغه الانجليزيه :
                                                {{ $setting->showroom_en ?? '' }}</h5>
                                            <h5 class="main-profile-name">المعرض باللغه العربيه :
                                                {{ $setting->showroom_ar ?? '' }}</h5>
                                            <p class="main-profile-name-text">{{ $setting->email ?? '' }}</p>
                                        </div>
                                    </div>

                                </div><!-- main-profile-overview -->
                            </div>
                        </div>

                    </div>
                    <div class="card mg-b-20">
                        <div class="card-body">
                            <div class="main-content-label tx-13 mg-b-25">
                                التواصل
                            </div>
                            <div class="main-profile-contact-list">
                                <div class="media">
                                    <div class="media-icon bg-primary-transparent text-primary">
                                        <i class="icon ion-md-phone-portrait"></i>
                                    </div>
                                    <div class="media-body">
                                        <span>الهاتف</span>
                                        <div>
                                            {{ $setting->company_phone ?? '' }}
                                        </div>
                                    </div>
                                </div>
                                <div class="media">
                                    <div class="media-icon bg-success-transparent text-success">
                                        <i class="icon ion-logo-slack"></i>
                                    </div>
                                    <div class="media-body">
                                        <span>موقع المعرض</span>
                                        <div>
                                            {{ $setting->website_link ?? '' }}
                                        </div>
                                    </div>
                                </div>
                                <div class="media">
                                    <div class="media-icon bg-info-transparent text-info">
                                        <i class="icon ion-md-locate"></i>
                                    </div>
                                    <div class="media-body">
                                        <span>عنوان المعرض</span>
                                        <div>
                                            {{ $setting->company_address ?? '' }}
                                        </div>
                                    </div>
                                </div>
                            </div><!-- main-profile-contact-list -->
                        </div>
                    </div>
                </div>
            @endif
            <!-- Col -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('userUpdate', $user->id) }}"
                            class="btn btn-outline-success btn-sm ml-0 mb-3">تعديل
                            بيانات المستخدم</a>

                        <div class="row">
                            <div class="col-md-3">
                                <h6>اسم المستخدم</h6>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control" readonly value="{{ $user->name }}"
                                    id="username" name="username">
                            </div>
                            <br>
                            <div class="col-md-3">
                                <h6>رقم الهاتف</h6>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control" readonly value="{{ $user->phone }}"
                                    id="phone" name="phone">
                            </div>

                            <br>
                            <div class="col-md-3">
                                <h6>البريد الاكتروني</h6>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control" readonly value="{{ $user->email }}"
                                    id="email" name="email">
                            </div>

                            <br>
                            <div class="col-md-3">
                                <h6>نوع المستخدم</h6>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control" readonly value="{{ typeUser($user->type) }}"
                                    id="type" name="type">
                            </div>


                            <br>

                            <div class="col-md-3">
                                <h6>حالة المستخدم</h6>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control" readonly
                                    value=" {{ $user->status == 1 ? 'مفعل' : 'غير مفعل' }}" id="status"
                                    name="status">
                            </div>



                        </div>
                        @if ($user->type == 'showroom' || $user->type == 'admin')
                            <h5 class="my-4 main-content-label">معلومات المعرض</h5>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="form-label">الاسم بالعربي</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" placeholder=""
                                            value="{{ old('showroom_ar', $setting->showroom_ar) }}" name="showroom_ar"
                                            id="showroom_ar">
                                    </div>
                                </div>
                                <div class="row my-1">
                                    <div class="col-md-3">
                                        <label class="form-label">الاسم بالانجليزي</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" placeholder=""
                                            value="{{ old('showroom_en', $setting->showroom_en) }}" name="showroom_en"
                                            id="showroom_en">
                                    </div>
                                </div>
                            </div>

                            <h5 class="my-4 main-content-label">معلومات الاتصال</h5>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="form-label">البريد الاكتروني<i>(مطلوب)</i></label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" placeholder="Email"
                                            value="{{ $setting->email }}" name="email" id="email">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="form-label">رابط الموقع</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="Website" id="Website"
                                            placeholder="Website" value="{{ $setting->website_link }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="form-label">هاتف المعرض</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" placeholder="phone number"
                                            value="{{ $setting->company_phone }}" name="phone" id="phone">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="form-label">عنوان المعرض</label>
                                    </div>
                                    <div class="col-md-9">
                                        <textarea class="form-control" name="address" id="address" rows="2" placeholder="Address">{{ $setting->company_address }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <h6 class="my-4 main-content-label">معلومات اضافيه عن المعرض</h6>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="form-label" name="example" id="example">الوصف</label>
                                    </div>
                                    <div class="col-md-9">
                                        <textarea class="form-control" name="aboutcompany" rows="4" placeholder="">{{ $setting->biographical_information }}</textarea>
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                    @if ($user->type == 'showroom')
                        <div class="card-footer text-left">
                            <button type="submit" class="btn btn-primary waves-effect waves-light">تحديث
                                البروفيل</button>
                        </div>
                    @endif
                </div>
            </div>




            <!-- /Col -->
        </div>
    </form>



    <div class="row">

        <div class="col-xl-12">
            <div class="card">

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="example1">
                            <thead>
                                <tr>
                                    <th class="wd-10p border-bottom-0">#</th>
                                    <th class="wd-15p border-bottom-0">معرف الاعلان</th>
                                    <th class="wd-15p border-bottom-0">اسم الاعلان</th>
                                    <th class="wd-15p border-bottom-0">طبيعة الاعلان</th>
                                    <th class="wd-15p border-bottom-0">نوع ناقل الحركة</th>
                                    <th class="wd-15p border-bottom-0">صورة الاعلان</th>
                                    <th class="wd-10p border-bottom-0">السعر الرئيسي</th>
                                    <th class="wd-10p border-bottom-0">الدولة</th>
                                    <th class="wd-10p border-bottom-0">العلامة التجارية</th>
                                    <th class="wd-15p border-bottom-0">العمليات</th>
                                </tr>
                            </thead>
                            <tbody>

                                @php
                                    $i = 0;
                                @endphp

                                @foreach ($products as $product)
                                    @php
                                        $i++;
                                    @endphp
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $product->id }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->condition == 'new' ? 'جديد' : 'مستعمل' }}</td>
                                        <td>{{ $product->motion_vector }}</td>
                                        <td>
                                            <div class="image-container">
                                                <img src="{{ asset($product->image) }}" alt="Avatar Image"
                                                    class="full-screen-hover">
                                            </div>
                                        </td>
                                        <td>{{ $product->price }}</td>
                                        <td>{{ $product->country?->name_ar }}</td>
                                        <td>{{ $product->brand?->name_ar }}</td>


                                        <td>
                                            <div class="d-flex">
                                                @can('حالة اعلان')
                                                    <div class="main-toggle main-toggle-success {{ $product->status == true ? 'on' : '' }} btn-sm ml-2"
                                                        data-product-id="{{ $product->id }}">
                                                        <span></span>
                                                    </div>
                                                @endcan
                                                @can('تعديل اعلان')
                                                    <a class="btn btn-sm btn-info btn-sm ml-2"
                                                        href="{{ route('products.show', $product->id) }}" title="تفاصيل">
                                                        <i class="las la-eye"></i>
                                                    </a>
                                                @endcan
                                                @can('تعديل اعلان')
                                                    <a class="btn btn-sm btn-info btn-sm ml-2"
                                                        href="{{ route('products.edit', $product->id) }}" title="تعديل">
                                                        <i class="las la-pen"></i>
                                                    </a>
                                                @endcan
                                                {{-- @can('تعديل اعلان')
                                                    <a class="btn btn-sm btn-info btn-sm ml-2"
                                                        href="{{ route('products.edit', $product->id) }}" title="حساب">
                                                        <i class="las la-user"></i>
                                                    </a>
                                                @endcan --}}
                                                {{-- @can('نسخ الاعلان')
                                                    <a class="btn btn-sm btn-info btn-sm ml-2 btn-custom"
                                                        href="{{ route('products.editFork', $product->id) }}"
                                                        title="نسح الاعلان">
                                                        <i class="fas fa-code-branch" style="color: rgb(250, 250, 250);"></i>

                                                    </a>
                                                @endcan --}}
                                                @can('حذف اعلان')
                                                    <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                        data-id="{{ $product->id }}" data-name="{{ $product->name_ar }}"
                                                        data-toggle="modal" href="#modaldemo9" title="حذف"><i
                                                            class="las la-trash"></i></a>
                                                @endcan
                                            </div>

                                        </td>
                                    </tr>
                                @endforeach



                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" id="modaldemo8">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">اضافة قسم</h6><button aria-label="Close" class="close"
                            data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('categories.store') }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="exampleInputEmail1">اسم الاعلان باللغه العربيه</label>
                                <input type="text" class="form-control" id="name_ar" name="name_ar" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">اسم الاعلان باللغه الانجليزيه</label>
                                <input type="text" class="form-control" id="name_en" name="name_en" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">ترتيب الاعلان </label>
                                <input type="number" class="form-control" id="arrange" name="arrange">
                            </div>
                            <div class="form-group">
                                <label for="image">تحميل صوره للاعلان</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="image" name="image"
                                        required>
                                    <label class="custom-file-label" for="image">اختار صوره</label>
                                </div>
                                <img src="#" id="preview"
                                    style="display: none; max-width: 200px; max-height: 200px;">
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">تاكيد</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
        <!-- row closed -->
        <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">تعديل الاعلان</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('categories.update', 0) }}" method="post" enctype="multipart/form-data">
                            {{ method_field('PUT') }}
                            {{ csrf_field() }}
                            <input type="hidden" name="id" id="id" value="">

                            {{-- <input type="hidden" name="status" id="status" value=""> --}}

                            <div class="form-group">
                                <label for="exampleInputEmail1">اسم الاعلان باللغه العربيه</label>
                                <input type="text" class="form-control" id="name_ar" name="name_ar">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">اسم الاعلان باللغه الانجليزيه</label>
                                <input type="text" class="form-control" id="name_en" name="name_en">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">ترتيب الاعلان </label>
                                <input type="number" class="form-control" id="arrange" name="arrange">
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">صوره الاعلان</label>
                                <input class="form-control" name="image" id="image" type="file">
                                <img src="image" id="image" class="img-thumbnail"
                                    style="width: 100px; height: 100px;">
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">تاكيد</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- delete -->
        <div class="modal" id="modaldemo9">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">حذف الاعلان</h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('products.destroy') }}" method="post">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <p>هل أنت متأكد من عملية الحذف؟</p><br>
                            <input type="hidden" name="id" id="id" value="">
                            <input class="form-control" name="name" id="name" type="text" readonly>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                            <button type="submit" class="btn btn-danger">تأكيد</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>
@endsection
@section('js')
    <script>
        window.alert = function() {};
    </script>

    <!-- Internal Data tables -->
    <script src="{{ URL::asset('assets/js/modal.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
    <!--Internal  Chart.bundle js -->
    <script src="{{ URL::asset('assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>
    <!-- Internal Select2.min js -->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>
    <script>
        function insertImage(e, id) {
            const file = e.target.files[0];
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById(id).src = event.target.result;
            };
            reader.readAsDataURL(file);
        }

        document.getElementById('image-upload').addEventListener('change', e => insertImage(e, 'profile-image'));
        document.getElementById('background_image').addEventListener('change', e => insertImage(e, 'background-image'));
    </script>
@endsection
{{--                        <div class="mb-4 main-content-label">المعلومات التواصل الاجتماعي</div> --}}
{{--                        <div class="form-group "> --}}
{{--                            <div class="row"> --}}
{{--                                <div class="col-md-3"> --}}
{{--                                    <label class="form-label">تويتر</label> --}}
{{--                                </div> --}}
{{--                                <div class="col-md-9"> --}}
{{--                                    <input type="text" class="form-control" placeholder="twitter" --}}
{{--                                        value="{{ $setting->twitter }}" name="twitter" id="twitter"> --}}
{{--                                </div> --}}
{{--                            </div> --}}
{{--                        </div> --}}
{{--                        <div class="form-group "> --}}
{{--                            <div class="row"> --}}
{{--                                <div class="col-md-3"> --}}
{{--                                    <label class="form-label">فيسبوك</label> --}}
{{--                                </div> --}}
{{--                                <div class="col-md-9"> --}}
{{--                                    <input type="text" class="form-control" placeholder="facebook" --}}
{{--                                        value="{{ $setting->facebook }}" name="facebook" id="facebook"> --}}
{{--                                </div> --}}
{{--                            </div> --}}
{{--                        </div> --}}
{{--                        <div class="form-group "> --}}
{{--                            <div class="row"> --}}
{{--                                <div class="col-md-3"> --}}
{{--                                    <label class="form-label">انستقرام</label> --}}
{{--                                </div> --}}
{{--                                <div class="col-md-9"> --}}
{{--                                    <input type="text" class="form-control" placeholder="google" --}}
{{--                                        value="{{ $setting->google }}" name="google" id="google"> --}}
{{--                                </div> --}}
{{--                            </div> --}}
{{--                        </div> --}}
{{--                        <div class="form-group "> --}}
{{--                            <div class="row"> --}}
{{--                                <div class="col-md-3"> --}}
{{--                                    <label class="form-label">لينكدن</label> --}}
{{--                                </div> --}}
{{--                                <div class="col-md-9"> --}}
{{--                                    <input type="text" class="form-control" placeholder="linkedin" --}}
{{--                                        value="{{ $setting->linkedin }}" name="linkedin" id="linkedin"> --}}
{{--                                </div> --}}
{{--                            </div> --}}
{{--                        </div> --}}
{{--                        <div class="form-group "> --}}
{{--                            <div class="row"> --}}
{{--                                <div class="col-md-3"> --}}
{{--                                    <label class="form-label">جيتهاب</label> --}}
{{--                                </div> --}}
{{--                                <div class="col-md-9"> --}}
{{--                                    <input type="text" class="form-control" placeholder="github" --}}
{{--                                        value="{{ $setting->github }}" name="github" id="github"> --}}
{{--                                </div> --}}
{{--                            </div> --}}
{{--                        </div> --}}
