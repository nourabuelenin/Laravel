<h1>welcome to admin dashboard</h1>
<form action="{{ route('admin.logout') }}" method="POST">
    @csrf
    <button class="btn btn-danger">Logout</button>
</form>