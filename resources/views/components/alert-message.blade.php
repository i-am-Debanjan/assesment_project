@if (session('success') || session('error') || session('status'))
    <div id="alert-message"
        class="mt-4 p-4 bg-white shadow-md rounded-md border
               {{ session('success') ? 'border-green-400 text-green-600' : (session('error') ? 'border-red-400 text-red-600' : 'border-blue-400 text-blue-600') }}">
        {{ session('success') ? __(session('success')) : (session('error') ? __(session('error')) : __(session('status'))) }}
    </div>
@endif
