<div class="d-flex">
    <a href="{{ $editRoute }}" class="btn btn-sm btn-primary me-1">
        <i class="fa fa-edit"></i>
    </a>
    <form method="POST" action="{{ $deleteRoute }}" class="d-inline delete-form">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger delete-btn">
            <i class="fa fa-trash"></i>
        </button>
    </form>
</div>