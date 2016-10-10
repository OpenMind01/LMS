@include('include.inputs.text', [
    'name' => 'title',
    'caption' => 'Title',
    'required' => true
])

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <label class="form-checkbox form-normal form-primary form-text">
            {!! Form::checkbox('ready', 1, Input::old('ready', false)) !!} Open for clients
        </label>
    </div>
</div>

@include('include.inputs.begin', [
    'name' => 'usergroups',
    'caption' => 'User groups',
    'required' => true
])

<select multiple="multiple" name="usergroups[]" id="usergroups" class="form-control">
    @foreach($usergroupsList as $usergroup)
        <option value="{{$usergroup->id}}" @if(isset($currentUsergroups[$usergroup->id]))selected="selected"@endif>{{$usergroup->title}}</option>
    @endforeach
</select>

@include('include.inputs.end')