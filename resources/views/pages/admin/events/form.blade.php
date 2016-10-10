<link href="/assets/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css" rel="stylesheet">

@include('include.inputs.text', [
    'name' => 'title',
    'caption' => 'Title',
    'required' => true])

@include('include.inputs.date', [
    'name' => 'string_start_datetime',
    'caption' => 'Event start date',
    'required' => true])

@include('include.inputs.begin', [
    'name' => 'all_day',
    'caption' => ''])

<label class="form-checkbox form-normal form-primary form-text active">
{!! Form::checkbox('all_day', 1, Input::old('all_day'), ['id' => 'all_day']) !!}
All day
</label>

@include('include.inputs.end')

@include('include.inputs.date', [
    'name' => 'string_finish_datetime',
    'caption' => 'Event finish date',
    'hint' => 'Not necessary for "All day" events'])

@include('include.inputs.textarea', [
    'name' => 'text',
    'caption' => 'Text'])

<script src="/assets/plugins/bootstrap-datetimepicker/moment.js"></script>
<script src="/assets/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>

<script>
    $('#string_start_datetime').datetimepicker({
        format: "M/D/YYYY h:mm A",
        sideBySide: true,
        stepping: 15
    });

    $('#string_finish_datetime').datetimepicker({
        format: "M/D/YYYY h:mm A",
        sideBySide: true,
        stepping: 15
    });
</script>
