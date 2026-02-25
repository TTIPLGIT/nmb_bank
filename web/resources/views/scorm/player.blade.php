@extends('layouts.adminnav')

@section('content')

<style>
.scorm-frame {
    width: 100%;
    height: 85vh;
    border: none;
}
</style>

<div class="main-content">
    <section class="section">
        <a href="{{ route('scorm.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Back to Courses
        </a>
        <div class="col-lg-12 text-center">
            <h4 style="color:darkblue;">{{ $scorm->title }}</h4>
        </div>

        <div class="section-body mt-3">
            <div class="card">
                <div class="card-body p-0">

                    {{-- IMPORTANT: iframe AFTER API definition --}}
                    <iframe id="scormFrame" src="{{ asset($scorm->entry_url) }}" class="scorm-frame">
                    </iframe>

                </div>
            </div>
        </div>
    </section>
</div>

@endsection


{{-- 🔥 DO NOT PUSH THIS TO STACK --}}
<script>
var scormData = {};

/* ===== SCORM 1.2 API ===== */
window.API = {

    LMSInitialize: function() {
        console.log("SCORM 1.2 Initialized");
        return "true";
    },

    LMSSetValue: function(key, value) {
        console.log("Set:", key, value);
        scormData[key] = value;
        return "true";
    },

    LMSGetValue: function(key) {
        return scormData[key] || "";
    },

    LMSCommit: function() {
        console.log("Committing...");

        fetch("{{ route('scorm.commit') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                scorm_id: "{{ $scorm->id }}",
                data: scormData
            })
        });

        return "true";
    },

    LMSFinish: function() {
        console.log("SCORM Finished");
        return "true";
    },

    LMSGetLastError: function() {
        return "0";
    },
    LMSGetErrorString: function() {
        return "";
    },
    LMSGetDiagnostic: function() {
        return "";
    }
};
</script>