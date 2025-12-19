<!DOCTYPE html>
<html>

<head>
    <title>Negative Feedback Alert</title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6;">
    <h2 style="color: #d9534f;">Negative Feedback Received</h2>

    <p>You have received new feedback that requires attention.</p>

    <div style="background: #f9f9f9; padding: 15px; border-left: 4px solid #d9534f;">
        <p><strong>Feedback ID:</strong> {{ $feedback->id }}</p>
        <p><strong>Source:</strong> {{ $feedback->qrCode->name ?? 'Unknown' }}</p>
        <p><strong>Date:</strong> {{ $feedback->created_at->format('M d, Y H:i') }}</p>

        @if($feedback->feedback_text)
            <p><strong>Comment:</strong></p>
            <p style="font-style: italic;">"{{ $feedback->feedback_text }}"</p>
        @endif

        <p><strong>Ratings:</strong></p>
        <ul>
            @foreach($feedback->ratings as $qId => $score)
                <li>Question ID {{ $qId }}: {{ $score }} / 5</li>
            @endforeach
        </ul>
    </div>

    <p>Please log in to your dashboard to review and resolve this issue.</p>

    <a href="{{ route('feedback-inbox.show', $feedback->id) }}"
        style="background: #0275d8; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px;">View
        Feedback</a>
</body>

</html>