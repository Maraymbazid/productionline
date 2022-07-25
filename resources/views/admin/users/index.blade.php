@extends('layouts.layout')
@section('title','dashboard')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <section class="content" style="text-align: center; direction: rtl;">
        <div class="container-fluid">

            <div id="myModal" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Row information</h4>
                        </div>
                        <div class="modal-body">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>

                </div>
            </div>
            <!-- /.row (main row) -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <div class="content-wrapper">
        @if (session()->has('success'))
            <div class="alert alert-success mt-5 " role="alert">
                {{ session()->get('success') }}
            </div>
        @endif
        <section class="content" style="text-align: center; direction: rtl;">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-12 col-12">

                        <!-- small box -->

                    </div>
                    <!-- ./col -->

                    <!-- ./col -->
                    <div class="col-lg-4 col-12">
                        <!-- small box -->

                    </div>
                    <!-- ./col -->

                    <!-- ./col -->
                </div>
                <!-- /.row -->
                <!-- Main row -->



                <!-- Modal -->

                <!-- /.row (main row) -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- Main content -->


        <!---- new -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

                        <!-- /.card -->

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"> المستخدمين   </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped text-center">
                                    <thead>
                                        <tr>
                                        <th>الاسم</th>
                                        <th>الايميل</th>
                                        <th>الادوار</th>
                                        <th width="280px">الاحداث</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($users as $user)
                                            <tr class="UserRow{{$user->id}}">
                                                <td> {{ $user->name }}</td>
                                                <td> {{ $user->email }}</td>
                                                <td>
                                                @if(!empty($user->getRoleNames()))
                                                    @foreach($user->getRoleNames() as $v)
                                                    <label class="badge badge-success">{{ $v }}</label>
                                                    @endforeach
                                                @endif
                                                </td>
                                                <td>
                                                <a class="btn btn-info" href="{{ route('users.show',$user->id) }}">Show</a>
                                                <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">Edit</a>
                                                <a href="" class="btn btn-danger button-delete" user_id="{{$user->id}}">Delete </a>
                                                </td>
                                        @endforeach
                                    </tbody>
                                </table>



                            </div>
                            <!-- /.card-body -->
                        </div>

                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            @if ($users->hasPages())
                    <nav>
                        <ul class="pagination">
                            {{-- Previous Page Link --}}
                            @if ($users->onFirstPage())
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                                </li>
                            @else
                                <li class="page-item ">
                                    <a class="page-link" href=" {{ $users->previousPageUrl() }}"
                                        tabindex="-1">Previous</a>
                                </li>
                            @endif


                            {{-- Next Page Link --}}
                            @if ($users->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link"
                                        href="{{ $users->nextPageUrl() }}">Next</a>
                                </li>
                            @else
                                <li class="page-item disabled" aria-disabled="true"
                                    aria-label="@lang('pagination.next')">
                                    <span class="page-link" aria-hidden="true">&rsaquo;</span>
                                </li>
                            @endif
                        </ul>
                    </nav>
                    @endif

        </section>
    </div>
   

@endsection
@section('js')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://unpkg.com/sweetalert2@7.8.2/dist/sweetalert2.all.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script>
        $(document).on('click', '.button-delete', function (e) {
            e.preventDefault();
            var user_id = $(this).attr('user_id');
            $.ajax({
                type: 'post',
                url: "{{route('users.delete')}}",
                data: {
                    '_token': "{{csrf_token()}}",
                    'id' :user_id
                },
                success: (response) => {
                    if (response) {
                    $('.UserRow'+response.id).remove();
                    Swal.fire({
                            position: 'top-center',
                            icon: 'success',
                            title: response.msg,
                            showConfirmButton: false,
                            timer: 1500
                        })
                }}
                , error: function (reject) {

                }
            });
           // console.log(gouvernement_id);
        });
    </script>
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "info": false,
                "bPaginate": true,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });



        Swal.bindClickHandler()


        Swal.mixin({
            title: 'هل تريد الاستمرار؟',
            icon: 'question',
            iconHtml: '؟',
            confirmButtonText: 'نعم',
            cancelButtonText: 'لا',
            showCancelButton: true,
            showCloseButton: true
        }).bindClickHandler('data-swal-toast-template')
    </script>


    @endsection
