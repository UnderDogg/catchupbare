<h1>Hello {{ $staff->first_name }}</h1>

Only one more step to activate your account.<br>
<br>
Clink on the following link to <a href="{{ URL::to('auth/verify/' . $staff->confirmation_code) }}">validate your email address.</a><br>
<br>
Thank you.<br>

