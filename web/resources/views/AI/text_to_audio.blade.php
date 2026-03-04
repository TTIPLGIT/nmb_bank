@extends('layouts.adminnav')

@section('content')
<style type="text/css">
.audio-player {
    width: 100%;
    height: 40px;
    margin-top: 5px;
}

.text-preview {
    max-width: 200px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.audio-actions {
    display: flex;
    gap: 5px;
}

.audio-card {
    margin-bottom: 15px;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.audio-card:hover {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
</style>

<div class="main-content">
    <!-- Success/Error Messages -->
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <section class="section">
        <div class="col-lg-12 text-center">
            <h4 style="color:darkblue;">Text to Audio Converter</h4>
        </div>

        <div class="section-body mt-2">
            <!-- Audio Generation Form -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Generate New Audio</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('text_to_audio') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="text" class="form-label">Text Content <span
                                                class="text-danger">*</span></label>
                                        <textarea class="form-control" id="text" name="text" rows="5"
                                            placeholder="Enter text to convert to audio (max 5000 characters)"
                                            required>{{ old('text') }}</textarea>
                                    </div>
                                    <input type="hidden" name="language" value="en">
                                    <input type="hidden" name="speaker" value="female-en-5">

                                    <!-- <div class="col-md-6 mb-3">
                                        <label for="language" class="form-label">Language</label>
                                        <select class="form-control" id="language" name="language" required>
                                            <option value="en" {{ old('language') == 'en' ? 'selected' : '' }}>English
                                            </option>
                                            <option value="es" {{ old('language') == 'es' ? 'selected' : '' }}>Spanish
                                            </option>
                                            <option value="fr" {{ old('language') == 'fr' ? 'selected' : '' }}>French
                                            </option>
                                            <option value="de" {{ old('language') == 'de' ? 'selected' : '' }}>German
                                            </option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="speaker" class="form-label">Speaker Voice</label>
                                        <select class="form-control" id="speaker" name="speaker" required>
                                            <option value="female-en-5"
                                                {{ old('speaker') == 'female-en-5' ? 'selected' : '' }}>Female English 5
                                            </option>
                                            <option value="male-en-3"
                                                {{ old('speaker') == 'male-en-3' ? 'selected' : '' }}>Male English 3
                                            </option>
                                            <option value="female-es-2"
                                                {{ old('speaker') == 'female-es-2' ? 'selected' : '' }}>Female Spanish 2
                                            </option>
                                            <option value="male-fr-1"
                                                {{ old('speaker') == 'male-fr-1' ? 'selected' : '' }}>Male French 1
                                            </option>
                                        </select>
                                    </div> -->
                                </div>

                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-play-circle me-1"></i> Generate Audio
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Audio Files List -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Generated Audio Files</h5>
                            <span class="badge badge-primary">{{ count($audioFiles) }} files</span>
                        </div>
                        <div class="card-body">
                            @if(count($audioFiles) > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Sl. No.</th>
                                            <th>Text Preview</th>
                                            <!-- <th>Language</th>
                                            <th>Speaker</th> -->
                                            <th>Generated On</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($audioFiles as $index => $audio)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <div class="text-preview" title="{{ $audio->text }}">
                                                    {{ Str::limit($audio->text, 80) }}
                                                </div>
                                            </td>
                                            <!-- <td>
                                                <span class="badge badge-info">{{ strtoupper($audio->language) }}</span>
                                            </td>
                                            <td>
                                                <span class="badge badge-secondary">{{ $audio->speaker }}</span>
                                            </td> -->
                                            <td>{{ \Carbon\Carbon::parse($audio->created_at)->format('d M Y, h:i A') }}
                                            </td>
                                            <td>
                                                <div class="audio-actions d-flex" style="gap: 5px;">
                                                    <!-- Play Button - Direct Link -->
                                                    @if($audio->audio_url)
                                                    <a href="http://20.164.0.23:3300{{ $audio->audio_url }}"
                                                        target="_blank" class="btn btn-info btn-sm" title="Play Audio">
                                                        <i class="fas fa-play"></i>
                                                    </a>

                                                    <!-- Download Button - Direct Link -->
                                                    <a href="http://20.164.0.23:3300{{ $audio->audio_url }}" download
                                                        class="btn btn-success btn-sm" title="Download Audio">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                    @endif

                                                    <!-- Delete Button -->
                                                    <form action="{{ route('delete_audio', $audio->id) }}" method="POST"
                                                        onsubmit="return confirm('Are you sure you want to delete this audio?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="text-center py-5">
                                <i class="fas fa-music fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No audio files generated yet</h5>
                                <p class="text-muted">Convert your first text to audio using the form above</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-dismiss alerts after 5 seconds
    setTimeout(function() {
        $('.alert').alert('close');
    }, 5000);

    // Textarea character counter
    const textarea = document.getElementById('text');
    if (textarea) {
        textarea.addEventListener('input', function() {
            const maxLength = 5000;
            const currentLength = this.value.length;
            const counter = document.getElementById('charCounter') ||
                (function() {
                    const counter = document.createElement('div');
                    counter.id = 'charCounter';
                    counter.className = 'text-muted small mt-1';
                    this.parentNode.appendChild(counter);
                    return counter;
                }).call(textarea);

            counter.textContent = `${currentLength}/${maxLength} characters`;

            if (currentLength > maxLength) {
                counter.classList.add('text-danger');
                counter.classList.remove('text-muted');
            } else {
                counter.classList.remove('text-danger');
                counter.classList.add('text-muted');
            }
        });

        // Trigger input event to show initial counter
        textarea.dispatchEvent(new Event('input'));
    }
});
</script>
@endsection