<?php

return [
    // Auth / Login / Registration
    'templates' => [
        'registration-notification' => [
            'name' => 'Registration Notification',
            'id' => 'b0457650-cddc-4ac5-bf56-c0069be77399',
            'validation' => [
                'user_email' => 'required|email',
                'user_password' => 'required'
            ]
        ],
        'password-reset-request' => [
            'name' => 'Password Reset Request',
            'id' => '39df7326-853e-4595-ac88-5b1aa4e17d8d',
            'validation' => [
                'password_reset_url' => 'required|url'
            ]
        ],

        // Raise Hand Feature
        'raise-hand-notification' => [
            'name' => 'Raise Hand Notification',
            'id' => '5c383be6-2400-4fcf-9019-57b2b5735e91',
            'validation' => [
                'admin_full_name' => 'required',
                'moderator_full_name' => 'required',
                'student_full_name' => 'required',
                'thread_title' => 'required',
                'thread_slug' => 'required',
            ]
        ],
        'raise-hand-reply' => [
            'name' => 'Raise Hand Reply Notification',
            'id' => '215c8a46-a69b-435e-bb5d-58b5572f97c6',
            'validation' => [
                'student_name' => 'required',
                'course_name' => 'required',
                'student_comment' => 'required',
            ]
        ],
    ]
];
