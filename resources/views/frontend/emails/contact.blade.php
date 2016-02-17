<ul>
    <li>Name: {{ $name }}</li>
    <li>Phone: {{ $phone }}</li>
    <li>Email: {{ $email }}</li>
    @if(!empty($subject))
        <li>Subject: {{ $subject }}</li>
    @endif
    @if(!empty($content))
        <li>Message: {{ $content }}</li>
    @endif
</ul>