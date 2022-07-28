@extends('layouts.layout')
@section('title', 'dashboard')
@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ url('assest/admin/plugins/select2/css/select2.min.css') }}">


    <script src="sweetalert2.min.js"></script>
    <link rel="stylesheet" href="sweetalert2.min.css">
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid" id='createhotel'>
                <div class="col-12 mt-5">
                    <div class="card">
                        <div class="mt-5 p-2">
                            <a href="javascript:void(0)" class="addnew btn btn-success btn-sm"> إضافة طلب جديد</a>
                        </div>
                        <div class="card-header">
                            <h3 class="card-title">قائمة الطلبات </h3>
                        </div>
                        <div class="card-body">
                            <table id='ex10' class="table table-bordered table-striped yajra-datatable">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>name</th>
                                        <th>code</th>
                                        <th>status</th>
                                        <th>action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('js')


    <script type="text/javascript">
        $(function() {
            var table = $('.yajra-datatable').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
              
                ajax: "{{ route('orders.indexd') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'code',
                        name: 'code'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    },
                ],

            });


            $('.yajra-datatable tbody').on('click', '.delete', function() {
                let name = $(this).attr("name");
                let id = $(this).attr("value");
                Swal.fire({
                    title: 'هل انت متأكد من حذف' + ' ' + name,
                    text: " سيؤدي حذف الطلب الى إختفاءه من السيستم نهائيا",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'متأكد امسح!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'post',
                            url: "{{ route('orders.delete') }}",
                            data: {
                                '_token': "{{ csrf_token() }}",
                                'id': id
                            },
                            success: (response) => {
                                if (response) {
                                    Swal.fire({
                                        position: 'top-center',
                                        icon: 'success',
                                        title: response.msg,
                                        showConfirmButton: false,
                                        timer: 1500
                                    })
                                    table.ajax.reload(null, false);
                                }
                            },
                            error: function(reject) {

                            }
                        })

                    }
                })
                // console.log($(this).attr("value"));
            });

            $('.addnew').on('click', function() {
                Swal.fire({
                    title: ' طلب باتش جديد',
                    input: 'text',
                    inputAttributes: {
                        autocapitalize: 'off'
                    },
                    showCancelButton: true,
                    confirmButtonText: ' اضافة',
                    showLoaderOnConfirm: true,
                    preConfirm: (login) => {
                        let form = {
                            'code': login,
                            '_token': "{{ csrf_token() }}",
                        }
                        return axios.post('{{ route('orders.store') }}', form)
                            .then(response => {
                                if (response.status !== 200) {
                                    throw new Error(response.data.statusText)
                                }
                                return response.data
                            })
                            .catch(error => {
                                Swal.showValidationMessage(
                                    error.response.data.message
                                )
                            })
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.isConfirmed) {
                        table.ajax.reload(null, false);
                        Swal.fire({
                            position: 'top-center',
                            icon: 'success',
                            title: result.value.msg,
                            showConfirmButton: false,
                            timer: 1500
                        })

                    }
                })
            });


        });
    </script>
@endsection
