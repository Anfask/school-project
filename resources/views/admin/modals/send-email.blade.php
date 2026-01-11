<div class="modal fade" id="sendEmailModal" tabindex="-1" aria-labelledby="sendEmailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="sendEmailModalLabel">
                    <i class="fas fa-paper-plane me-2"></i>
                    Send Application Details to Student
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8">
                        <!-- Preview Card -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="fas fa-eye me-2"></i>Email Preview</h6>
                            </div>
                            <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                                <div class="email-preview">
                                    <div style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); color: white; padding: 20px; border-radius: 8px 8px 0 0;">
                                        <h4 style="margin: 0;">{{ config('app.name', 'Admission System') }}</h4>
                                        <p style="margin: 5px 0 0 0; opacity: 0.9;">Application Status Update</p>
                                    </div>

                                    <div style="padding: 20px; background: {{
                                        $application->status == 'accepted' ? '#10b981' :
                                        ($application->status == 'rejected' ? '#ef4444' :
                                        ($application->status == 'reviewed' ? '#3b82f6' : '#f59e0b'))
                                    }}; color: white; text-align: center;">
                                        <h5 style="margin: 0;">
                                            @if($application->status == 'accepted')
                                                Congratulations!
                                            @else
                                                Application Update
                                            @endif
                                        </h5>
                                        <p style="margin: 5px 0 0 0; opacity: 0.9;">
                                            Status: <strong>{{ ucfirst($application->status) }}</strong>
                                        </p>
                                    </div>

                                    <div style="padding: 20px; background: #f8fafc;">
                                        <p style="margin: 0 0 15px 0;">
                                            Dear <strong>{{ $application->first_name }} {{ $application->surname }}</strong>,
                                        </p>
                                        <p style="margin: 0 0 15px 0; color: #64748b;">
                                            This email contains your application details and current status.
                                            A PDF copy of your application is attached.
                                        </p>

                                        <div style="background: white; border-radius: 8px; padding: 15px; margin: 15px 0; border-left: 4px solid #3b82f6;">
                                            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px;">
                                                <div>
                                                    <small style="color: #64748b;">Application ID</small>
                                                    <p style="margin: 5px 0; font-weight: 600;">#{{ $application->id }}</p>
                                                </div>
                                                <div>
                                                    <small style="color: #64748b;">Class Applied</small>
                                                    <p style="margin: 5px 0; font-weight: 600;">{{ $application->admission_sought_for_class ?? 'N/A' }}</p>
                                                </div>
                                                <div>
                                                    <small style="color: #64748b;">Status</small>
                                                    <p style="margin: 5px 0;">
                                                        <span style="display: inline-block; padding: 3px 10px; background: {{
                                                            $application->status == 'accepted' ? '#10b981' :
                                                            ($application->status == 'rejected' ? '#ef4444' :
                                                            ($application->status == 'reviewed' ? '#3b82f6' : '#f59e0b'))
                                                        }}; color: white; border-radius: 20px; font-size: 12px;">
                                                            {{ ucfirst($application->status) }}
                                                        </span>
                                                    </p>
                                                </div>
                                                <div>
                                                    <small style="color: #64748b;">Date</small>
                                                    <p style="margin: 5px 0; font-weight: 600;">{{ $application->created_at->format('M d, Y') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <!-- Recipient Info -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="fas fa-user me-2"></i>Recipient</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label"><strong>Student Name</strong></label>
                                    <p>{{ $application->first_name }} {{ $application->surname }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label"><strong>Email Address</strong></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        <input type="text" class="form-control" value="{{ $application->email }}" readonly>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label"><strong>Application ID</strong></label>
                                    <p>#{{ $application->id }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Attachments -->
                        <div class="card">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="fas fa-paperclip me-2"></i>Attachments</h6>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="me-3">
                                        <div style="width: 40px; height: 40px; background: #3b82f6; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white;">
                                            <i class="fas fa-file-pdf"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <p style="margin: 0; font-weight: 600;">Application-{{ $application->id }}.pdf</p>
                                        <small style="color: #64748b;">Application details PDF</small>
                                    </div>
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="includeRemarks" checked>
                                    <label class="form-check-label" for="includeRemarks">
                                        Include status remarks
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="sendCopy" checked>
                                    <label class="form-check-label" for="sendCopy">
                                        Send copy to admin
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Message -->
                <div class="mb-3">
                    <label for="additionalMessage" class="form-label">Additional Message (Optional)</label>
                    <textarea class="form-control" id="additionalMessage" rows="3"
                              placeholder="Add a personal message to the student..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancel
                </button>
                <button type="button" class="btn btn-primary" id="sendEmailBtn">
                    <i class="fas fa-paper-plane me-2"></i>Send Email
                </button>
            </div>
        </div>
    </div>
</div>
