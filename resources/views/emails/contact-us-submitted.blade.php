<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Contact Enquiry</title>
</head>
<body style="font-family: Arial, sans-serif; color: #222;">
    <h2 style="margin-bottom: 12px;">New Contact Enquiry</h2>

    <p style="margin: 0 0 6px;"><strong>Name:</strong> {{ $contact['name'] ?? '—' }}</p>
    <p style="margin: 0 0 6px;"><strong>Email:</strong> {{ $contact['email'] ?? '—' }}</p>
    <p style="margin: 0 0 6px;"><strong>Phone:</strong> {{ $contact['phone'] ?? '—' }}</p>
    <p style="margin: 0 0 6px;"><strong>City:</strong> {{ $contact['city'] ?? '—' }}</p>
    <p style="margin: 0 0 6px;"><strong>Subject:</strong> {{ $contact['subject'] ?? '—' }}</p>

    <p style="margin: 14px 0 6px;"><strong>Message:</strong></p>
    <p style="margin: 0 0 16px;">{{ $contact['message'] ?: '—' }}</p>

    <p style="margin: 0; color: #666; font-size: 13px;">
        Submitted at {{ now()->format('d M Y, h:i A') }}
    </p>
</body>
</html>

