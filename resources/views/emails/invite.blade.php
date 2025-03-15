<!DOCTYPE html>
<html>
<head>
    <title>Invitation to Join {{ $companyName }}</title>
</head>
<body>
    <h1>You've Been Invited to Join {{ $companyName }}!</h1>
    <p>You have been invited to join <strong>{{ $companyName }}</strong> as a <strong>{{ $role }}</strong>.</p>
    <p>Click the link below to accept your invitation:</p>
    
    <a href="{{ url('http://localhost:3000/invited/' . $invitation->token) }}" style="display: inline-block; padding: 10px 20px; background-color: #007bff; color: #fff; text-decoration: none; border-radius: 5px;">
        Accept Invitation
    </a>

    <p>If you did not expect this invitation, you can ignore this email.</p>
</body>
</html>
