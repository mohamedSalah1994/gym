

<form method="post" action="{{route('import.save')}}" enctype="multipart/form-data">
    {{csrf_field()}}
<input type="file" name="file">
    <button type="submit">save</button>
</form>