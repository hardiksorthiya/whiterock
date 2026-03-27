<div class="card shadow-sm p-4">

    <h5 class="mb-2">Update Password</h5>

    <p class="text-muted mb-3">
        Ensure your account is using a long, random password to stay secure.
    </p>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <!-- Current Password -->
        <div class="mb-3">
            <label class="form-label">Current Password</label>

            <input type="password" name="current_password" class="form-control" autocomplete="current-password">

            @error('current_password', 'updatePassword')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- New Password -->
        <div class="mb-3">
            <label class="form-label">New Password</label>

            <input type="password" name="password" class="form-control" autocomplete="new-password">

            @error('password', 'updatePassword')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-3">
            <label class="form-label">Confirm Password</label>

            <input type="password" name="password_confirmation" class="form-control" autocomplete="new-password">

            @error('password_confirmation', 'updatePassword')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- Submit -->
        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-dark">
                Save
            </button>

            @if (session('status') === 'password-updated')
                <span class="text-success">Saved successfully.</span>
            @endif
        </div>

    </form>

</div>
