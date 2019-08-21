<?php

$this->theme = app('wp.theme');


$user = User::current();
$is_editor = $user->hasRole('administrator');

View::share('theme', $this->theme);
View::share('is_editor', $is_editor);
