<!-- Change Photo Modal -->
<div class="modal fade" id="changePhotoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-camera me-2 text-primary"></i>Change Profile Photo
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <div class="avatar-preview mb-3 mx-auto">
                        <div id="photoPreview" class="avatar-circle">
                            @if(Auth::user()->profile_photo_path)
                                <img src="{{ Storage::url(Auth::user()->profile_photo_path) }}"
                                     alt="Preview"
                                     class="rounded-circle"
                                     style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            @endif
                        </div>
                    </div>
                    <p class="text-muted">Click below to upload a new photo</p>
                </div>

                <form id="photoForm" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="profile_photo" class="form-label">Choose Image</label>
                        <input class="form-control"
                               type="file"
                               id="profile_photo"
                               name="profile_photo"
                               accept="image/*"
                               onchange="previewImage(event)">
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            Maximum file size: 2MB. Supported formats: JPG, PNG, GIF, WebP
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                @if(Auth::user()->profile_photo_path)
                <button type="button" class="btn btn-outline-danger me-auto" onclick="removePhoto()">
                    <i class="fas fa-trash me-1"></i>Remove Photo
                </button>
                @endif
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="uploadPhoto()">
                    <i class="fas fa-upload me-1"></i>Upload Photo
                </button>
            </div>
        </div>
    </div>
</div>
