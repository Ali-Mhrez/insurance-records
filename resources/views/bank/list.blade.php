@extends("master.layout")

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">البنوك</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">البنوك</li>
                    <li class="breadcrumb-item"><a href="{{route('welcome')}}">الرئيسية <i class="fa fa-tachometer-alt"></i></a></li>

                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">جدول البنوك</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->

        <div class="card-body">
            <div class="row  justify-content-center">
                <div class="col-lg-8">
                    <form action="{{ route('bank.store') }}" class="form-inline ">
                        @csrf
                        <input id="name" name="name" class="form-control @error('title') is-invalid @enderror col-lg-12" type="text" placeholder="اسم البنك" aria-label="اسم البنك">
                        <button class="btn btn-success mr-auto mt-2" type="Submit">إضافة</button>
                    </form>
                    @error('name')
                    <li class=" alert alert-danger">{{ $message }}</li>
                    @enderror
                    <table class="table mt-5">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" contenteditable='true'>اسم البنك</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($banks as $bank)
                            <tr>
                                <td scope="row" class="edit col-12" id="{{ $bank->id }}" contenteditable=true>{{ $bank->name }}
                                </td>
                                <td scope="row">
                                    <form action="{{ route('bank.delete', ['id' => $bank->id]) }}" class="form-inline" style="float:left;">
                                        <button type="Submit" class="btn btn-danger swalDefaultSuccess" onclick="return confirm('هل أنت متأكد?')">حذف</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                        <tfoot>
                            <tr>
                                <td>
                                    {{ $banks->links() }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <i>جدول البنوك</i>
        </div>

</div>





@stop
@section('scripts')
<script>
    $(document).ready(function() {
        $(".edit").focusout(function() {
            var id = this.id;
            var name = this.innerText;

            $.ajax({
                type: 'post',
                url: "{{ route('bank.update') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id,
                    "name": name
                },
                success: function(data) {
                    console.log("Data Save: " + data);
                },
                error: function(data) {
                    console.log("Error");
                }
            });
        });
    });
</script>
@stop
