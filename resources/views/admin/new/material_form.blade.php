@if (Auth::user()->is_admin != 1)
    @php header("Location: " . URL::to('/cabinet'), true, 302); exit(); @endphp
@endif

@extends('layouts.admin_new')

@section('title', $material ? 'Редагувати матеріал' : 'Новий матеріал')
@section('topbar-title', $material ? 'Редагувати матеріал' : 'Новий матеріал')

@section('head')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.10.9/tinymce.min.js"></script>
<style>
    .mf-wrap { display: flex; flex-direction: column; gap: 16px; height: calc(100vh - var(--topbar-height) - 80px); }
    .mf-topbar { display: flex; align-items: center; gap: 12px; flex-shrink: 0; }
    .mf-breadcrumb { display: flex; align-items: center; gap: 6px; font-size: 0.82rem; color: var(--text-muted); }
    .mf-breadcrumb a { color: var(--accent); text-decoration: none; }
    .mf-breadcrumb a:hover { text-decoration: underline; }
    .mf-breadcrumb-sep { color: var(--border-color); }
    .mf-title-input {
        flex: 1; font-size: 1.15rem; font-weight: 600;
        background: var(--bg-card); border: 1px solid var(--border-color);
        border-radius: var(--radius-md); padding: 10px 16px;
        color: var(--text-primary); outline: none;
        transition: border-color .2s, box-shadow .2s;
    }
    .mf-title-input:focus { border-color: var(--accent); box-shadow: 0 0 0 3px var(--accent-light); }
    .mf-editor-wrap { flex: 1; display: flex; flex-direction: column; min-height: 0; }
    .mf-editor-tabs { display: flex; gap: 4px; margin-bottom: 8px; }
    .mf-editor-panel { display: none; flex: 1; flex-direction: column; min-height: 0; }
    .mf-editor-panel.active { display: flex; }
    .mf-editor-panel .tox-tinymce { flex: 1 !important; }
    .mf-html-area { flex: 1; resize: none; font-family: 'Fira Code', 'Consolas', monospace; font-size: 0.85rem; }
    .mf-actions { display: flex; align-items: center; gap: 10px; flex-shrink: 0; padding-top: 4px; }
</style>
@endsection

@section('content')
<div class="mf-wrap">

    {{-- Breadcrumb + title --}}
    <div>
        <div class="mf-breadcrumb" style="margin-bottom:10px">
            <a href="/admin?course={{ $course->id }}">Курси</a>
            <span class="mf-breadcrumb-sep">›</span>
            <span>{{ $course->title }}</span>
            <span class="mf-breadcrumb-sep">›</span>
            <span>{{ $module->title }}</span>
            <span class="mf-breadcrumb-sep">›</span>
            <span>{{ $material ? $material->title : 'Новий матеріал' }}</span>
        </div>
        <div class="mf-topbar">
            <input type="text" id="mf_title" class="mf-title-input"
                placeholder="Назва матеріалу..."
                value="{{ $material ? $material->title : '' }}" autofocus>
            <div class="mf-editor-tabs" style="margin:0">
                <button type="button" class="editor-tab active" onclick="mfSwitchTab(this,'wysiwyg')">WYSIWYG</button>
                <button type="button" class="editor-tab" onclick="mfSwitchTab(this,'html')">HTML</button>
            </div>
        </div>
    </div>

    {{-- Editor --}}
    <div class="mf-editor-wrap">
        <div class="mf-editor-panel active" id="mf_wysiwyg_panel">
            <textarea id="mf_tinymce"></textarea>
        </div>
        <div class="mf-editor-panel" id="mf_html_panel">
            <textarea id="mf_html_area" class="form-input-new mf-html-area" rows="30"
                placeholder="<h2>Заголовок</h2><p>HTML-зміст...</p>"></textarea>
        </div>
    </div>

    {{-- Actions --}}
    <div class="mf-actions">
        <a href="/admin?course={{ $course->id }}" class="btn-new btn-secondary-new">
            ← Повернутись до курсу
        </a>
        <div style="flex:1"></div>
        @if($material)
        <button type="button" class="btn-new btn-danger-new" onclick="mfDelete()">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
            Видалити
        </button>
        @endif
        <button type="button" class="btn-new btn-primary-new" id="mf_save_btn" onclick="mfSave()">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
            Зберегти
        </button>
    </div>

</div>

{{-- Hidden forms --}}
@if($material)
<form id="mf_update_form" method="POST" action="/materials" style="display:none">
    @csrf @method('PUT')
    <input type="hidden" name="id" value="{{ $material->id }}">
    <input type="hidden" name="title" id="mf_form_title">
    <input type="hidden" name="code"  id="mf_form_code">
</form>
<form id="mf_delete_form" method="POST" action="/materials" style="display:none">
    @csrf @method('DELETE')
    <input type="hidden" name="id" value="{{ $material->id }}">
</form>
@else
<form id="mf_create_form" method="POST" action="/materials" style="display:none">
    @csrf
    <input type="hidden" name="module_id" value="{{ $module->id }}">
    <input type="hidden" name="title" id="mf_form_title">
    <input type="hidden" name="code"  id="mf_form_code">
</form>
@endif

@endsection

@section('scripts')
<script>
var _mfTab = 'wysiwyg';
var _mfInitialContent = {!! json_encode($material?->code ?? '') !!};

// ── Init TinyMCE ──────────────────────────────────────────────────
function getYouTubeId(url) {
    var m = String(url).match(/(?:youtube\.com\/(?:watch\?(?:.*&)?v=|embed\/|shorts\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/);
    return m ? m[1] : null;
}
function youtubeEmbedHtml(id) {
    return '<div class="yt-embed" style="position:relative;padding-bottom:56.25%;height:0;overflow:hidden;margin:14px 0;border-radius:8px">' +
           '<iframe src="https://www.youtube.com/embed/' + id + '" style="position:absolute;top:0;left:0;width:100%;height:100%;border:0;border-radius:8px" allowfullscreen loading="lazy" title="YouTube video"></iframe></div>';
}
function convertYouTubeInNode(node) {
    node.querySelectorAll('a[href]').forEach(function(a) {
        var id = getYouTubeId(a.getAttribute('href'));
        if(!id) return;
        var t = document.createElement('div'); t.innerHTML = youtubeEmbedHtml(id);
        a.parentNode.replaceChild(t.firstChild, a);
    });
    var walker = document.createTreeWalker(node, NodeFilter.SHOW_TEXT, null, false), nodes = [];
    while(walker.nextNode()) nodes.push(walker.currentNode);
    nodes.forEach(function(n) {
        var text = n.textContent.trim();
        if(!/^https?:\/\//i.test(text)) return;
        var id = getYouTubeId(text); if(!id) return;
        var t = document.createElement('div'); t.innerHTML = youtubeEmbedHtml(id);
        var p = n.parentNode;
        if(p && p !== node && p.textContent.trim() === text) p.parentNode.replaceChild(t.firstChild, p);
        else n.parentNode.replaceChild(t.firstChild, n);
    });
}

tinymce.init({
    selector: '#mf_tinymce',
    plugins: 'table link image lists media hr wordcount code paste autolink',
    toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image media | spoiler uploadvideo | hr | code',
    menubar: false,
    height: '100%',
    resize: false,
    branding: false,
    promotion: false,
    convert_urls: false,
    paste_data_images: true,
    extended_valid_elements: 'iframe[src|frameborder|style|scrolling|class|width|height|name|align|allowfullscreen|loading|title]',
    content_style: [
        'body { font-family: Inter, system-ui, sans-serif; font-size: 15px; line-height: 1.7; padding: 16px 24px; }',
        'details.spoiler { border:1px solid #e2e8f0; border-radius:6px; padding:4px 14px; margin:10px 0; background:#f8fafc; }',
        'details.spoiler summary { cursor:pointer; font-weight:600; padding:6px 0; user-select:none; color:#A6192E; }',
        'video { max-width:100%; border-radius:6px; }'
    ].join(' '),
    paste_postprocess: function(plugin, args) { convertYouTubeInNode(args.node); },
    images_upload_handler: function(blobInfo, success, failure) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/upload/image');
        xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        xhr.onload = function() {
            if(xhr.status !== 200) { failure('HTTP Error: ' + xhr.status); return; }
            var json; try { json = JSON.parse(xhr.responseText); } catch(e) { failure('Invalid JSON'); return; }
            if(!json || typeof json.location !== 'string') { failure('Invalid response'); return; }
            success(json.location);
        };
        xhr.onerror = function() { failure('Network error'); };
        var fd = new FormData(); fd.append('file', blobInfo.blob(), blobInfo.filename()); xhr.send(fd);
    },
    setup: function(editor) {
        editor.ui.registry.addButton('spoiler', {
            text: '▼ Спойлер', tooltip: 'Вставити прихований блок',
            onAction: function() {
                editor.insertContent('<details class="spoiler"><summary>Натисніть, щоб розгорнути</summary><p>Вміст...</p></details><p></p>');
            }
        });
        editor.ui.registry.addButton('uploadvideo', {
            text: '🎬 Відео', tooltip: 'Завантажити відео',
            onAction: function() {
                var input = document.createElement('input');
                input.type = 'file'; input.accept = 'video/mp4,video/webm,video/ogg,video/*';
                input.style.cssText = 'position:fixed;top:-9999px;left:-9999px;opacity:0';
                document.body.appendChild(input);
                input.onchange = function() {
                    var file = input.files[0]; document.body.removeChild(input); if(!file) return;
                    var toast = showVideoProgressToast(file.name);
                    var fd = new FormData(); fd.append('file', file);
                    var xhr = new XMLHttpRequest(); xhr.open('POST', '/upload/video');
                    xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                    xhr.upload.onprogress = function(e) { if(e.lengthComputable) updateVideoProgressToast(toast, Math.round(e.loaded/e.total*100)); };
                    xhr.onload = function() {
                        if(xhr.status !== 200) { finishVideoProgressToast(toast, 'error', 'Помилка: ' + xhr.status); return; }
                        var json; try { json = JSON.parse(xhr.responseText); } catch(e) { finishVideoProgressToast(toast,'error','Помилка'); return; }
                        finishVideoProgressToast(toast, 'success', 'Відео завантажено');
                        editor.insertContent('<p><video controls style="max-width:100%;border-radius:6px"><source src="' + json.location + '" type="' + file.type + '">Ваш браузер не підтримує відео.</video></p><p></p>');
                    };
                    xhr.onerror = function() { finishVideoProgressToast(toast,'error','Помилка мережі'); };
                    xhr.send(fd);
                };
                input.click();
            }
        });
        editor.on('ExecCommand', function(e) { if(e.command === 'mceAutoLink') convertYouTubeInNode(editor.getBody()); });
        editor.on('init', function() { editor.setContent(_mfInitialContent); });
    }
});

// ── Tab switching ─────────────────────────────────────────────────
function mfSwitchTab(btn, tab) {
    document.querySelectorAll('.mf-topbar .editor-tab').forEach(t => t.classList.remove('active'));
    btn.classList.add('active');
    if(tab === 'wysiwyg') {
        var html = document.getElementById('mf_html_area').value;
        var ed = tinymce.get('mf_tinymce'); if(ed) ed.setContent(html);
        document.getElementById('mf_wysiwyg_panel').classList.add('active');
        document.getElementById('mf_html_panel').classList.remove('active');
    } else {
        var ed = tinymce.get('mf_tinymce');
        document.getElementById('mf_html_area').value = ed ? ed.getContent() : '';
        document.getElementById('mf_wysiwyg_panel').classList.remove('active');
        document.getElementById('mf_html_panel').classList.add('active');
    }
    _mfTab = tab;
}

// ── Save ──────────────────────────────────────────────────────────
function mfSave() {
    var title = document.getElementById('mf_title').value.trim();
    if(!title) { document.getElementById('mf_title').focus(); showToast('Введіть назву матеріалу', 'error'); return; }

    var btn = document.getElementById('mf_save_btn');
    btn.disabled = true; btn.textContent = 'Збереження...';

    var ed = tinymce.get('mf_tinymce');
    var doSubmit = function(code) {
        document.getElementById('mf_form_title').value = title;
        document.getElementById('mf_form_code').value  = code;
        var form = document.getElementById('mf_update_form') || document.getElementById('mf_create_form');
        form.submit();
    };

    if(_mfTab === 'wysiwyg' && ed) {
        ed.uploadImages().then(function() { doSubmit(ed.getContent()); });
    } else {
        doSubmit(document.getElementById('mf_html_area').value);
    }
}

// ── Delete ────────────────────────────────────────────────────────
function mfDelete() {
    if(confirm('Видалити цей матеріал? Дію не можна скасувати.')) {
        document.getElementById('mf_delete_form').submit();
    }
}

// ── Progress toast helpers (same as courses page) ─────────────────
function showVideoProgressToast(filename) {
    var container = document.getElementById('toastContainer');
    var toast = document.createElement('div'); toast.className = 'toast info';
    toast.style.cssText = 'min-width:280px;cursor:default;transition:none';
    var shortName = filename.length > 28 ? filename.slice(0,25) + '…' : filename;
    toast.innerHTML = '<div style="display:flex;align-items:center;gap:8px;margin-bottom:8px"><span style="font-size:1rem">🎬</span><span style="flex:1;font-size:0.85rem;font-weight:600">Завантаження відео</span><span class="vp-pct" style="font-size:0.85rem;font-weight:700;color:var(--accent)">0%</span></div><div style="font-size:0.75rem;color:var(--text-muted);margin-bottom:8px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">' + shortName + '</div><div style="background:var(--border-color);border-radius:99px;height:6px;overflow:hidden"><div class="vp-bar" style="height:100%;width:0%;background:var(--accent);border-radius:99px;transition:width 0.25s ease"></div></div>';
    container.appendChild(toast); return toast;
}
function updateVideoProgressToast(toast, percent) {
    var bar = toast.querySelector('.vp-bar'), pct = toast.querySelector('.vp-pct');
    if(bar) bar.style.width = percent + '%'; if(pct) pct.textContent = percent + '%';
}
function finishVideoProgressToast(toast, type, message) {
    updateVideoProgressToast(toast, 100);
    var icon = type === 'success' ? '✓' : '✕', color = type === 'success' ? 'var(--success)' : 'var(--danger)';
    toast.className = 'toast ' + type; toast.style.cssText = 'min-width:280px';
    toast.innerHTML = '<div style="display:flex;align-items:center;gap:8px"><span style="font-size:1rem;color:' + color + '">' + icon + '</span><span style="font-size:0.88rem">' + message + '</span></div>';
    setTimeout(function() { toast.style.opacity='0'; toast.style.transition='opacity 0.4s'; setTimeout(function(){toast.remove();},400); }, 3000);
}

// ── Keyboard shortcut: Ctrl+S / Cmd+S ────────────────────────────
document.addEventListener('keydown', function(e) {
    if((e.ctrlKey || e.metaKey) && e.key === 's') { e.preventDefault(); mfSave(); }
});
</script>
@endsection
