<!-- Delete Account Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-danger">
            <div class="modal-header border-danger">
                <h5 class="modal-title text-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>Delete Account
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <div class="avatar-circle bg-danger text-white mx-auto mb-3" style="width: 80px; height: 80px;">
                        <i class="fas fa-exclamation" style="font-size: 2rem;"></i>
                    </div>
                    <h5 class="text-danger mb-2">Are you absolutely sure?</h5>
                    <p class="text-muted">This action cannot be undone. All your data will be permanently removed.</p>
                </div>

                <form method="POST" action="{{ route('profile.destroy') }}" id="deleteAccountForm">
                    @csrf
                    @method('DELETE')

                    <div class="mb-3">
                        <label for="confirmDelete" class="form-label">
                            To confirm, type <code>DELETE {{ Auth::user()->email }}</code>
                        </label>
                        <input type="text"
                               class="form-control"
                               id="confirmDelete"
                               name="confirm"
                               placeholder="Type to confirm">
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="understandConsequences" required>
                        <label class="form-check-label text-danger" for="understandConsequences">
                            I understand that this will permanently delete my account and all associated data
                        </label>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-danger">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                    <i class="fas fa-trash-alt me-1"></i>Delete Account
                </button>
            </div>
        </div>
    </div>
</div>
