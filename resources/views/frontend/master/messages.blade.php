@if(\Illuminate\Support\Facades\Session::has('messages') || count($errors) > 0)
    <div class="global-messages">
        <ul>
            @foreach(\Illuminate\Support\Facades\Session::get('messages', []) as $message)
                <li>{{ $message }}</li>
            @endforeach
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif