<!-- Activity Log Modal -->
<div class="modal fade" id="activityModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-history me-2 text-info"></i>Account Activity Log
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Activity</th>
                                <th>IP Address</th>
                                <th>Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <i class="fas fa-sign-in-alt text-success me-2"></i>
                                    Login
                                </td>
                                <td>{{ Auth::user()->last_login_ip ?? 'N/A' }}</td>
                                <td>{{ Auth::user()->last_login_at ? Auth::user()->last_login_at->diffForHumans() : 'N/A' }}</td>
                                <td><span class="badge bg-success">Success</span></td>
                            </tr>
                            @if(Auth::user()->password_changed_at)
                            <tr>
                                <td>
                                    <i class="fas fa-key text-warning me-2"></i>
                                    Password Changed
                                </td>
                                <td>N/A</td>
                                <td>{{ Auth::user()->password_changed_at->diffForHumans() }}</td>
                                <td><span class="badge bg-success">Success</span></td>
                            </tr>
                            @endif
                            @if(Auth::user()->hasTwoFactorEnabled() && Auth::user()->two_factor_confirmed_at)
                            <tr>
                                <td>
                                    <i class="fas fa-shield-alt text-primary me-2"></i>
                                    2FA Enabled
                                </td>
                                <td>N/A</td>
                                <td>{{ Auth::user()->two_factor_confirmed_at->diffForHumans() }}</td>
                                <td><span class="badge bg-success">Success</span></td>
                            </tr>
                            @endif
                            <!-- Add more activity rows as needed -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-info" onclick="exportActivityLog()">
                    <i class="fas fa-download me-1"></i>Export Logs
                </button>
            </div>
        </div>
    </div>
</div>
