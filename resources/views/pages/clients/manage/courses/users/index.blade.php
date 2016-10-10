@inject('courseUsers', 'Pi\Clients\Courses\Repositories\CourseUserRepository')
@extends('layouts.default')

@section('content')
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">Students for {{ $course->name }}</h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Completion %</th>
                    <th class="col-sm-3">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                @foreach($client->users as $user)
                    <tr>
                        <td>{{ $user->full_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $courseUsers->getUserCourseProgress($user, $course) }} %</td>
                        <td>
                            {!! Form::open(['class' => 'delete-user-progress-form', 'route' => ['clients.manage.courses.users.reset-progress', $client->slug, $course->slug, $user->id], 'method' => 'post']) !!}
                            <div class="checkbox">
                                <label class="form-checkbox form-normal form-primary active form-text"><input class="user-checkbox" data-user-id="{{ $user->id }}" type="checkbox" @if($courseUsers->userBelongsToCourse($user, $course)) checked="" @endif> Belongs To Course</label>
                            </div>

                            <button class="btn btn-danger">
                                <i class="fa fa-reload"></i>
                                Reset Course Progress
                            </button>

                            <a class="btn btn-success" href="{{ route('clients.manage.courses.users.show', [$client->slug, $course->slug, $user->id]) }}">
                                Show User Progress
                            </a>
                            {!! Form::close() !!}

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@stop

@section('inline-scripts')
    <script src="/assets/plugins/jquery-bpopup/jquery.bpopup.min.js"></script>
    <script src="/assets/plugins/jquery-sortable/jquery-sortable.js"></script>
    <script>
        (function ($) {
            $(".delete-user-progress-form").submit(function(e) {
                e.preventDefault();
                var $form = $(this);
                bootbox.confirm('Are you sure you wish to delete the progress for this user? All user progress will be lost and cannot be recovered.', function(yes) {
                    if (yes) {
                        $form[0].submit();
                    }
                })
            })
            $(".user-checkbox").change(function(e) {
                var $chkbox = $(this);
                var userId = $chkbox.data('userId');
                var url;
                var type;
                if (!$chkbox.is(":checked")) {
                    url = '{{ url('api/courses/'.$course->id.'/users') }}/'+userId;
                    $.ajax({
                        url: url,
                        type: 'delete',
                        success: function(response) {
                            if (!response.success) {
                                bootbox.alert(response.message);
                            }
                        }
                    })
                }else {
                    url = '{{ url('api/courses/'.$course->id.'/users') }}';
                    $.ajax({
                        url: url,
                        type: 'post',
                        data: {
                            user_id: userId
                        },
                        success: function(response) {
                            if (!response.success) {
                                bootbox.alert(response.message);
                            }
                        }
                    })
                }
            });
        })(jQuery);
    </script>

@stop