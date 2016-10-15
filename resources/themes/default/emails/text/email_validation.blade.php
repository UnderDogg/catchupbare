Hello {{ $staff->first_name }}

Only one more step to activate your account.

Clink on the following link ({{ URL::to('auth/verify/' . $staff->confirmation_code) }}) to validate your email address.

Thank you.

