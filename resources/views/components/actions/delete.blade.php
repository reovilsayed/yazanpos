<form action="{{$action}}" method="post" class="d-inline">
    @csrf
    @method('delete')
    <button class="btn btn-sm btn-danger h-auto" onclick="return confirm('Are you sure')"><i class="fa fa-trash"></i></button>
</form>