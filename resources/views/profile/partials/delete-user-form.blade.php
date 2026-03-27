<div class="card shadow-sm p-4 border-danger">

    <h5 class="text-danger mb-2">Delete Account</h5>

    <p class="text-muted">
        Once your account is deleted, all of its resources and data will be permanently deleted.
        Please download any important data before proceeding.
    </p>

    <!-- Delete Button -->
    <button class="btn btn-danger mt-3" data-bs-toggle="modal" data-bs-target="#deleteModal">
        Delete Account
    </button>

</div>


<!-- Bootstrap Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form method="POST" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')

                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">

                    <p class="text-muted">
                        Are you sure you want to delete your account? This action cannot be undone.
                        Please enter your password to confirm.
                    </p>

                    <!-- Password -->
                    <div class="mb-3">
                        <label class="form-label">Password</label>

                        <input type="password" name="password" class="form-control" placeholder="Enter your password">

                        @error('password', 'userDeletion')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button type="submit" class="btn btn-danger">
                        Delete Account
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
