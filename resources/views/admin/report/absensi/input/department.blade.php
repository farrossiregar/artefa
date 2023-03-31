<select name="department" class="form-control col-md-6 chzn-select" tabindex="2">
    <option disabled="true" selected="true">--Pilih Unit--</option>
    @foreach($departmens as $department)
    <option value="{{$department->id}}">{{$department->department}} - {{$department->unit}}</option>
    @endforeach
</select>