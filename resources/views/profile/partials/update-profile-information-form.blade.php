<div class="card shadow-sm p-4">

    <h5 class="mb-2">Profile Information</h5>

    <p class="text-muted mb-3">
        Update your account's profile information and email address.
    </p>

    <!-- Verification Form -->
    <form id="send-verification" method="POST" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <!-- Profile Update Form -->
    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <!-- Name -->
        <div class="mb-3">
            <label class="form-label">Name</label>

            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required
                autofocus>

            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label class="form-label">Email</label>

            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>

            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- Email Verification Notice -->
        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
            <div class="alert alert-warning">
                Your email address is not verified.

                <button form="send-verification" class="btn btn-link p-0 ms-2">
                    Click here to resend verification email
                </button>
            </div>

            @if (session('status') === 'verification-link-sent')
                <div class="alert alert-success">
                    A new verification link has been sent to your email address.
                </div>
            @endif
        @endif

        <!-- Submit -->
        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-dark">
                Save
            </button>

            @if (session('status') === 'profile-updated')
                <span class="text-success">Saved successfully.</span>
            @endif
        </div>

    </form>

</div>
