<!DOCTYPE html>
<html>
<head>
    <title>Invitation to Join {{ $companyName }}</title>
</head>
<body>
    <h1>You've Been Invited to Join {{ $companyName }}!</h1>
    <p>You have been invited to join <strong>{{ $companyName }}</strong> as a <strong>{{ $role }}</strong>.</p>
    <p>Click the link below to accept your invitation:</p>
    <!-- The link should be a get reqwuest for the FE and pass the token to use for the real post request -->
    <a href="{{ url('/api/auth/register-from-invitation?token=' . $invitation->token) }}">Accept Invitation</a>
    <p>If you did not expect this invitation, you can ignore this email.</p>
</body>
</html>
