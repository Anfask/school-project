<!-- Backup Codes Modal -->
<div class="modal fade" id="backupCodesModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-key me-2 text-warning"></i>Backup Codes
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                @if(Auth::user()->hasTwoFactorEnabled())
                    <div class="alert alert-warning mb-3">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Save these codes in a secure location. Each code can be used only once.
                    </div>

                    <div id="backupCodesList" class="text-center mb-3">
                        @if(Auth::user()->two_factor_backup_codes)
                            @foreach(Auth::user()->two_factor_backup_codes as $code)
                                <code class="d-block mb-1">{{ $code }}</code>
                            @endforeach
                        @else
                            <p class="text-muted">No backup codes generated yet.</p>
                        @endif
                    </div>

                    <div class="text-center">
                        <button type="button" class="btn btn-outline-warning btn-sm" onclick="regenerateBackupCodes()">
                            <i class="fas fa-redo me-1"></i>Regenerate Codes
                        </button>
                    </div>
                @else
                    <div class="text-center">
                        <div class="avatar-circle bg-light text-muted mx-auto mb-3" style="width: 80px; height: 80px;">
                            <i class="fas fa-key" style="font-size: 2rem;"></i>
                        </div>
                        <h5>2FA Not Enabled</h5>
                        <p class="text-muted">Enable two-factor authentication to generate backup codes.</p>
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                @if(Auth::user()->hasTwoFactorEnabled() && Auth::user()->two_factor_backup_codes)
                <button type="button" class="btn btn-warning" onclick="downloadBackupCodes()">
                    <i class="fas fa-download me-1"></i>Download
                </button>
                @endif
            </div>
        </div>
    </div>
</div>
