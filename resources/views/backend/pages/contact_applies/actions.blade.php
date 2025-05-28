<div class="d-flex">
    <form method="POST" action="{{ $deleteRoute }}" class="d-inline delete-form">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger delete-btn" onclick="return confirm('Silmək istədiyinizə əminsiniz?')">
            <i class="fa fa-trash"></i>
        </button>
    </form>
</div>