<p>
    Hi {{ $admin->fullName }}, <br/>
    {{ $moderator->fullName }} has raised their hand on a discussion: <br/>
    <a href="{{ $thread->slug }}">{{ $thread->title }}</a> by {{ $thread->user->fullName }}<br /><br />
    Click the link above to continue the discussion.
</p>
