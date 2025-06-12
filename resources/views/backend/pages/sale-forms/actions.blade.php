<div class="d-flex">
    <a href="{{ $showRoute }}" class="btn btn-sm btn-primary me-2">
        <i class="fas fa-eye"></i>
    </a>
    <form action="{{ $deleteRoute }}" method="POST" onsubmit="return confirm('Bu brendi silmək istədiyinizə əminsiniz?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger">
            <i class="fas fa-trash"></i>
        </button>
    </form>
</div>
