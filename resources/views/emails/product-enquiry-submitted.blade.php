<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Product Enquiry</title>
</head>
<body style="font-family: Arial, sans-serif; color: #222;">
    <h2 style="margin-bottom: 12px;">New Product Enquiry</h2>
    <p style="margin: 0 0 6px;"><strong>Product:</strong> {{ $enquiry->product_name }}</p>
    <p style="margin: 0 0 6px;"><strong>Name:</strong> {{ $enquiry->name }}</p>
    <p style="margin: 0 0 6px;"><strong>Phone:</strong> {{ $enquiry->phone }}</p>
    <p style="margin: 0 0 6px;"><strong>Quantity:</strong> {{ $enquiry->quantity }}</p>
    <p style="margin: 0 0 6px;"><strong>Message:</strong></p>
    <p style="margin: 0 0 16px;">{{ $enquiry->message ?: '—' }}</p>
    <p style="margin: 0; color: #666; font-size: 13px;">
        Submitted at {{ optional($enquiry->created_at)->format('d M Y, h:i A') }}
    </p>
</body>
</html>
