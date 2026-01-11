<!-- Two-Factor Authentication Modal -->
<div class="modal fade" id="twoFactorModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-shield-alt me-2 text-primary"></i>
                    @if(Auth::user()->hasTwoFactorEnabled())
                        Manage Two-Factor Authentication
                    @else
                        Enable Two-Factor Authentication
                    @endif
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            @if(Auth::user()->hasTwoFactorEnabled())
            <!-- 2FA Enabled View -->
            <div class="modal-body">
                <div class="text-center mb-4">
                    <div class="avatar-circle bg-success bg-opacity-10 text-success mx-auto mb-3" style="width: 80px; height: 80px;">
                        <i class="fas fa-shield-alt" style="font-size: 2rem;"></i>
                    </div>
                    <h5 class="text-success">Two-Factor Authentication Enabled</h5>
                    <p class="text-muted">
                        <i class="fas fa-{{ Auth::user()->two_factor_method == 'app' ? 'mobile-alt' : 'sms' }} me-1"></i>
                        Method: {{ strtoupper(Auth::user()->two_factor_method) }}
                    </p>
                </div>

                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Two-factor authentication adds an extra layer of security to your account.
                </div>

                <div class="text-center mt-4">
                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#disableTwoFactorModal">
                        <i class="fas fa-ban me-1"></i>Disable 2FA
                    </button>
                </div>
            </div>
            @else
            <!-- 2FA Setup View -->
            <div class="modal-body">
                <div class="text-center mb-4">
                    <div class="avatar-circle bg-primary bg-opacity-10 text-primary mx-auto mb-3" style="width: 80px; height: 80px;">
                        <i class="fas fa-shield-alt" style="font-size: 2rem;"></i>
                    </div>
                    <h5>Enhance Account Security</h5>
                    <p class="text-muted">Add an extra layer of security to your account</p>
                </div>

                <div class="mb-4">
                    <label class="form-label">Choose 2FA Method</label>
                    <div class="list-group mb-3">
                        <label class="list-group-item" id="methodApp">
                            <input class="form-check-input me-2" type="radio" name="twoFactorMethod" value="app" checked>
                            <i class="fas fa-mobile-alt me-2 text-primary"></i>
                            <div>
                                <strong>Authenticator App</strong>
                                <small class="d-block text-muted">Use apps like Google Authenticator or Authy</small>
                            </div>
                        </label>
                        <label class="list-group-item" id="methodSms">
                            <input class="form-check-input me-2" type="radio" name="twoFactorMethod" value="sms">
                            <i class="fas fa-sms me-2 text-info"></i>
                            <div>
                                <strong>SMS Verification</strong>
                                <small class="d-block text-muted">Receive verification codes via SMS</small>
                            </div>
                        </label>
                    </div>

                    <!-- App Setup Instructions -->
                    <div id="appInstructions" class="d-none">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="mb-3"><i class="fas fa-info-circle me-2 text-primary"></i>Setup Instructions</h6>
                                <ol class="small">
                                    <li>Install Google Authenticator or Authy on your phone</li>
                                    <li>Click "Enable 2FA" to generate a QR code</li>
                                    <li>Scan the QR code with your authenticator app</li>
                                    <li>Enter the 6-digit code from the app to verify</li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <!-- SMS Instructions -->
                    <div id="smsInstructions" class="d-none">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="mb-3"><i class="fas fa-info-circle me-2 text-info"></i>Setup Instructions</h6>
                                <ol class="small">
                                    <li>Make sure your phone number is verified in your profile</li>
                                    <li>Click "Enable 2FA" to send a verification code</li>
                                    <li>Enter the code sent to your phone to verify</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Make sure to save your backup codes in a secure location!
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="enableTwoFactor()">
                    <i class="fas fa-shield-alt me-1"></i>Enable 2FA
                </button>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- QR Code Modal (for app setup) -->
<div class="modal fade" id="qrCodeModal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">
                    <i class="fas fa-qrcode me-2 text-primary"></i>Scan QR Code
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <div id="qrCodeContainer" class="mb-3"></div>
                <p class="small text-muted">Scan this QR code with your authenticator app</p>

                <div class="mb-3">
                    <label class="form-label small">Or enter this code manually:</label>
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control text-center" id="manualSecret" readonly>
                        <button class="btn btn-outline-secondary" type="button" onclick="copySecret()">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                </div>

                <form id="verifyTwoFactorForm">
                    @csrf
                    <div class="mb-3">
                        <label for="verificationCode" class="form-label small">Enter 6-digit code:</label>
                        <input type="text"
                               class="form-control text-center"
                               id="verificationCode"
                               name="code"
                               placeholder="000000"
                               maxlength="6"
                               pattern="\d{6}">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="verifyTwoFactor()">
                    <i class="fas fa-check me-1"></i>Verify
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Disable 2FA Modal -->
<div class="modal fade" id="disableTwoFactorModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-danger">
                <h5 class="modal-title text-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>Disable Two-Factor Authentication
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <div class="avatar-circle bg-danger bg-opacity-10 text-danger mx-auto mb-3" style="width: 80px; height: 80px;">
                        <i class="fas fa-shield-slash" style="font-size: 2rem;"></i>
                    </div>
                    <h5 class="text-danger">Are you sure?</h5>
                    <p class="text-muted">Disabling 2FA will reduce your account security.</p>
                </div>

                <form id="disableTwoFactorForm">
                    @csrf
                    <div class="mb-3">
                        <label for="disablePassword" class="form-label">Enter your password to confirm:</label>
                        <div class="input-group">
                            <input type="password"
                                   class="form-control"
                                   id="disablePassword"
                                   name="password"
                                   placeholder="Current password"
                                   required>
                            <button class="btn btn-outline-secondary toggle-password" type="button" data-target="disablePassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="disableTwoFactor()">
                    <i class="fas fa-ban me-1"></i>Disable 2FA
                </button>
            </div>
        </div>
    </div>
</div>
