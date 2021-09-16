Login
<form method="post" action="/login">
    @csrf
    <input name="login">
    <input name="password" type="password">
    <button>Войти</button>
</form>
<div style="color: red;">
    @error('login')
    {{ $message }}
    @enderror
</div>
