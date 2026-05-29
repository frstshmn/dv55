@if (Auth::user()->is_admin != 1)
    @php header("Location: " . URL::to('/cabinet'), true, 302); exit(); @endphp
@endif

@extends('layouts.admin_new')

@section('title', 'Курси')
@section('topbar-title', 'Керування курсами')

@section('head')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.10.9/tinymce.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.2/Sortable.min.js"></script>
<style>
.drag-handle { cursor: grab; color: var(--text-muted); flex-shrink:0; padding: 0 4px; opacity:.5; transition: opacity .15s; }
.drag-handle:hover { opacity:1; }
.drag-handle:active { cursor: grabbing; }
.module-block.sortable-ghost { opacity:.4; background: var(--accent-light); }
.material-row.sortable-ghost { opacity:.4; background: var(--accent-light); }
.material-row.sortable-chosen { box-shadow: 0 4px 16px rgba(166,25,46,.25); }
.module-block.sortable-chosen { box-shadow: 0 4px 20px rgba(166,25,46,.2); }
</style>
@endsection

@section('content')

<div class="page-header">
    <div>
        <h1>Курси</h1>
        <div class="page-header-sub">Керування курсами, модулями та навчальними матеріалами</div>
    </div>
    <button class="btn-new btn-primary-new" onclick="openModal('addCourseModal')">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Новий курс
    </button>
</div>

@if($courses->isEmpty())
<div class="empty-state" style="padding:80px 20px">
    <div class="empty-state-icon">🎓</div>
    <div class="empty-state-text">Курсів немає.<br>Натисніть "Новий курс" для початку.</div>
</div>
@else
<div class="courses-split">

    {{-- Left: course list --}}
    <div class="course-list-panel">
        <input type="text" class="form-input-new course-list-search" placeholder="Пошук курсів..." oninput="filterCourseList(this.value)">
        <div class="course-list-body">
            @foreach($courses as $course)
            <div class="course-list-item" data-id="{{ $course->id }}" data-title="{{ $course->title }}" onclick="selectCourse({{ $course->id }})">
                <div class="course-list-item-title">{{ $course->title }}</div>
                <div class="course-list-item-meta">
                    <span>{{ count($course->modules) }} модулів</span>
                    <span>{{ $course->modules->sum(fn($m) => count($m->materials)) }} матеріалів</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Right: course content --}}
    <div class="course-content-panel">
        <div id="no-course-selected" class="empty-state" style="padding:80px 20px">
            <div class="empty-state-icon">👈</div>
            <div class="empty-state-text">Оберіть курс для перегляду</div>
        </div>

        @foreach($courses as $course)
        <div class="course-content" id="course_content_{{ $course->id }}" style="display:none">

            {{-- Course header --}}
            <div class="course-content-header">
                <div style="flex:1;min-width:0">
                    <div style="font-size:1.2rem;font-weight:700;color:var(--text-primary);margin-bottom:5px">{{ $course->title }}</div>
                    <div style="font-size:0.83rem;color:var(--text-secondary);line-height:1.5;margin-bottom:14px">{{ $course->description }}</div>
                    <div style="display:flex;gap:20px">
                        <div class="course-stat">
                            <div class="course-stat-value">{{ count($course->modules) }}</div>
                            <div class="course-stat-label">Модулів</div>
                        </div>
                        <div class="course-stat">
                            <div class="course-stat-value">{{ $course->modules->sum(fn($m) => count($m->materials)) }}</div>
                            <div class="course-stat-label">Матеріалів</div>
                        </div>
                        <div class="course-stat">
                            <div class="course-stat-value">{{ $course->modules->sum(fn($m) => count($m->tests)) }}</div>
                            <div class="course-stat-label">Тестів</div>
                        </div>
                    </div>
                </div>
                <div style="display:flex;gap:6px;align-items:flex-start;flex-shrink:0">
                    <button class="list-action-btn edit" onclick="openEditCourse({{ $course->id }})" title="Редагувати">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    </button>
                    <button class="list-action-btn delete" onclick="deleteCourse({{ $course->id }}, this)" title="Видалити">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/></svg>
                    </button>
                    <button class="list-action-btn edit" onclick="openCourseProgress({{ $course->id }})" title="Прогрес">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                    </button>
                </div>
            </div>

            {{-- Modules with materials --}}
            <div id="modules_list_{{ $course->id }}" data-course="{{ $course->id }}">
                <div class="modules-section-header">
                    <span class="panel-card-title">Модулі</span>
                    <button class="btn-new btn-primary-new btn-sm-new" onclick="openAddModule({{ $course->id }})">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Додати модуль
                    </button>
                </div>

                @forelse($course->modules as $module)
                <div class="module-block" id="module_block_{{ $module->id }}" data-id="{{ $module->id }}">
                    <div class="module-block-header">
                        <div style="display:flex;align-items:center;gap:10px;min-width:0;overflow:hidden">
                            <span class="drag-handle module-drag-handle" title="Перетягнути модуль">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="5" r="1" fill="currentColor"/><circle cx="9" cy="12" r="1" fill="currentColor"/><circle cx="9" cy="19" r="1" fill="currentColor"/><circle cx="15" cy="5" r="1" fill="currentColor"/><circle cx="15" cy="12" r="1" fill="currentColor"/><circle cx="15" cy="19" r="1" fill="currentColor"/></svg>
                            </span>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;color:var(--accent)"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>
                            <span style="font-weight:600;color:var(--text-primary);overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ $module->title }}</span>
                            <span style="font-size:0.72rem;color:var(--text-muted);flex-shrink:0">{{ count($module->materials) }} матеріалів</span>
                        </div>
                        <div style="display:flex;gap:4px;align-items:center;flex-shrink:0">
                            <button class="btn-new btn-primary-new btn-sm-new" onclick="openAddMaterial({{ $module->id }})">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                Матеріал
                            </button>
                            <button class="list-action-btn edit" onclick="openEditModule({{ $module->id }})" title="Редагувати">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </button>
                            <button class="list-action-btn delete" onclick="deleteModule({{ $module->id }}, this)" title="Видалити">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                            </button>
                        </div>
                    </div>
                    <div class="module-block-materials" id="materials_list_{{ $module->id }}" data-module="{{ $module->id }}">
                        @forelse($module->materials as $material)
                        <div class="material-row" data-id="{{ $material->id }}">
                            <span class="drag-handle material-drag-handle" title="Перетягнути матеріал">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="5" r="1" fill="currentColor"/><circle cx="9" cy="12" r="1" fill="currentColor"/><circle cx="9" cy="19" r="1" fill="currentColor"/><circle cx="15" cy="5" r="1" fill="currentColor"/><circle cx="15" cy="12" r="1" fill="currentColor"/><circle cx="15" cy="19" r="1" fill="currentColor"/></svg>
                            </span>
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;color:var(--text-muted)"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            <span class="material-row-title">{{ $material->title }}</span>
                            <button class="list-action-btn edit" onclick="openEditMaterial({{ $material->id }})" title="Редагувати">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </button>
                        </div>
                        @empty
                        <div style="font-size:0.8rem;color:var(--text-muted);padding:10px 4px;font-style:italic">Матеріалів немає</div>
                        @endforelse
                    </div>
                </div>
                @empty
                <div class="empty-state" style="padding:40px 20px">
                    <div class="empty-state-icon">📂</div>
                    <div class="empty-state-text">Модулів немає.<br>Натисніть "Додати модуль" для створення.</div>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Hidden progress data --}}
        <script>
        window._courseProgressData = window._courseProgressData || {};
        window._courseProgressData[{{ $course->id }}] = {
            title: @json($course->title),
            users: [
                @foreach($users as $user)
                { name: @json($user->name), score: {{ $course->totalScore($user->id) }} },
                @endforeach
            ]
        };
        </script>
        @endforeach
    </div>
</div>
@endif


{{-- ===== MODALS ===== --}}

{{-- Add Course --}}
<div class="modal-overlay" id="addCourseModal">
    <div class="modal-box">
        <div class="modal-header-new">
            <h5>Новий курс</h5>
            <button class="modal-close" onclick="closeModal('addCourseModal')">✕</button>
        </div>
        <form method="POST" action="/courses" autocomplete="off">
            @csrf
            <div class="modal-body-new">
                <div class="form-group-new">
                    <label class="form-label-new">Назва</label>
                    <input type="text" name="title" placeholder="Назва курсу" class="form-input-new" required>
                </div>
                <div class="form-group-new">
                    <label class="form-label-new">Опис</label>
                    <textarea name="description" placeholder="Короткий опис курсу" class="form-input-new" rows="3" required></textarea>
                </div>
            </div>
            <div class="modal-footer-new">
                <button type="button" class="btn-new btn-secondary-new" onclick="closeModal('addCourseModal')">Скасувати</button>
                <button type="submit" class="btn-new btn-primary-new">Створити курс</button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Course --}}
<div class="modal-overlay" id="editCourseModal">
    <div class="modal-box">
        <div class="modal-header-new">
            <h5>Редагувати курс</h5>
            <button class="modal-close" onclick="closeModal('editCourseModal')">✕</button>
        </div>
        <form method="POST" action="/courses" autocomplete="off">
            @csrf @method('PUT')
            <input type="hidden" id="editCourseId" name="identifier">
            <div class="modal-body-new">
                <div class="form-group-new">
                    <label class="form-label-new">Назва</label>
                    <input type="text" id="editCourseTitle" name="title" class="form-input-new" required>
                </div>
                <div class="form-group-new">
                    <label class="form-label-new">Опис</label>
                    <textarea id="editCourseDesc" name="description" class="form-input-new" rows="3" required></textarea>
                </div>
            </div>
            <div class="modal-footer-new">
                <button type="button" class="btn-new btn-secondary-new" onclick="closeModal('editCourseModal')">Скасувати</button>
                <button type="submit" class="btn-new btn-primary-new">Зберегти зміни</button>
            </div>
        </form>
    </div>
</div>

{{-- Add Module --}}
<div class="modal-overlay" id="addModuleModal">
    <div class="modal-box">
        <div class="modal-header-new">
            <h5>Новий модуль</h5>
            <button class="modal-close" onclick="closeModal('addModuleModal')">✕</button>
        </div>
        <form method="POST" action="/modules" autocomplete="off">
            @csrf
            <input type="hidden" id="addModuleCourseId" name="course_id">
            <div class="modal-body-new">
                <div class="form-group-new">
                    <label class="form-label-new">Назва</label>
                    <input type="text" name="title" placeholder="Назва модуля" class="form-input-new" required>
                </div>
            </div>
            <div class="modal-footer-new">
                <button type="button" class="btn-new btn-secondary-new" onclick="closeModal('addModuleModal')">Скасувати</button>
                <button type="submit" class="btn-new btn-primary-new">Створити модуль</button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Module --}}
<div class="modal-overlay" id="editModuleModal">
    <div class="modal-box">
        <div class="modal-header-new">
            <h5>Редагувати модуль</h5>
            <button class="modal-close" onclick="closeModal('editModuleModal')">✕</button>
        </div>
        <form method="POST" action="/modules" autocomplete="off">
            @csrf @method('PUT')
            <input type="hidden" id="editModuleId" name="identifier">
            <input type="hidden" id="editModuleCourseId" name="course_id">
            <div class="modal-body-new">
                <div class="form-group-new">
                    <label class="form-label-new">Назва</label>
                    <input type="text" id="editModuleTitle" name="title" class="form-input-new" required>
                </div>
            </div>
            <div class="modal-footer-new">
                <button type="button" class="btn-new btn-secondary-new" onclick="closeModal('editModuleModal')">Скасувати</button>
                <button type="submit" class="btn-new btn-primary-new">Зберегти зміни</button>
            </div>
        </form>
    </div>
</div>


{{-- Course Progress --}}
<div class="modal-overlay" id="courseProgressModal">
    <div class="modal-box modal-lg">
        <div class="modal-header-new">
            <h5 id="progressModalTitle">Прогрес курсу</h5>
            <button class="modal-close" onclick="closeModal('courseProgressModal')">✕</button>
        </div>
        <div class="modal-body-new">
            <input type="text" class="table-search" id="progressSearch" placeholder="Пошук за ім'ям..." oninput="filterProgress()">
            <table class="progress-table">
                <thead>
                    <tr>
                        <th>Слухач</th>
                        <th>Прогрес</th>
                        <th>Результат</th>
                    </tr>
                </thead>
                <tbody id="progressTableBody"></tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
// ===== Video upload progress toast =====
function showVideoProgressToast(filename) {
    const container = document.getElementById('toastContainer');
    const toast = document.createElement('div');
    toast.className = 'toast info';
    toast.style.cssText = 'min-width:280px;cursor:default;transition:none';
    var shortName = filename.length > 28 ? filename.slice(0,25) + '…' : filename;
    toast.innerHTML =
        '<div style="display:flex;align-items:center;gap:8px;margin-bottom:8px">' +
            '<span style="font-size:1rem">🎬</span>' +
            '<span style="flex:1;font-size:0.85rem;font-weight:600">Завантаження відео</span>' +
            '<span class="vp-pct" style="font-size:0.85rem;font-weight:700;color:var(--accent)">0%</span>' +
        '</div>' +
        '<div style="font-size:0.75rem;color:var(--text-muted);margin-bottom:8px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">' + shortName + '</div>' +
        '<div style="background:var(--border-color);border-radius:99px;height:6px;overflow:hidden">' +
            '<div class="vp-bar" style="height:100%;width:0%;background:var(--accent);border-radius:99px;transition:width 0.25s ease"></div>' +
        '</div>';
    container.appendChild(toast);
    return toast;
}

function updateVideoProgressToast(toast, percent) {
    var bar = toast.querySelector('.vp-bar');
    var pct = toast.querySelector('.vp-pct');
    if(bar) bar.style.width = percent + '%';
    if(pct) pct.textContent = percent + '%';
}

function finishVideoProgressToast(toast, type, message) {
    updateVideoProgressToast(toast, 100);
    var icon = type === 'success' ? '✓' : '✕';
    var color = type === 'success' ? 'var(--success)' : 'var(--danger)';
    toast.className = 'toast ' + type;
    toast.style.cssText = 'min-width:280px';
    toast.innerHTML =
        '<div style="display:flex;align-items:center;gap:8px">' +
            '<span style="font-size:1rem;color:' + color + '">' + icon + '</span>' +
            '<span style="font-size:0.88rem">' + message + '</span>' +
        '</div>';
    setTimeout(function(){
        toast.style.opacity = '0';
        toast.style.transition = 'opacity 0.4s';
        setTimeout(function(){ toast.remove(); }, 400);
    }, 3000);
}

// ===== TinyMCE (used only by initTinyMCE helper, no longer for materials) =====

function getYouTubeId(url) {
    var m = String(url).match(
        /(?:youtube\.com\/(?:watch\?(?:.*&)?v=|embed\/|shorts\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/
    );
    return m ? m[1] : null;
}

function youtubeEmbedHtml(videoId) {
    return '<div class="yt-embed" style="position:relative;padding-bottom:56.25%;height:0;overflow:hidden;margin:14px 0;border-radius:8px">' +
           '<iframe src="https://www.youtube.com/embed/' + videoId + '" ' +
           'style="position:absolute;top:0;left:0;width:100%;height:100%;border:0;border-radius:8px" ' +
           'allowfullscreen loading="lazy" title="YouTube video"></iframe>' +
           '</div>';
}

function convertYouTubeInNode(node) {
    // 1. Replace <a href="youtube…"> links
    node.querySelectorAll('a[href]').forEach(function(a) {
        var id = getYouTubeId(a.getAttribute('href'));
        if (!id) return;
        var tmp = document.createElement('div');
        tmp.innerHTML = youtubeEmbedHtml(id);
        a.parentNode.replaceChild(tmp.firstChild, a);
    });
    // 2. Replace bare-text YouTube URLs sitting alone in a block
    var walker = document.createTreeWalker(node, NodeFilter.SHOW_TEXT, null, false);
    var nodes = [];
    while (walker.nextNode()) nodes.push(walker.currentNode);
    nodes.forEach(function(n) {
        var text = n.textContent.trim();
        if (!/^https?:\/\//i.test(text)) return;
        var id = getYouTubeId(text);
        if (!id) return;
        var tmp = document.createElement('div');
        tmp.innerHTML = youtubeEmbedHtml(id);
        // replace the parent block element if it contains only this text
        var parent = n.parentNode;
        if (parent && parent !== node && parent.textContent.trim() === text) {
            parent.parentNode.replaceChild(tmp.firstChild, parent);
        } else {
            n.parentNode.replaceChild(tmp.firstChild, n);
        }
    });
}

function initTinyMCE(selector, onReady){
    tinymce.init({
        selector: selector,
        plugins: 'table link image lists media hr preview wordcount code paste autolink',
        toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image media | spoiler uploadvideo | hr | code preview',
        menubar: false,
        height: 380,
        branding: false,
        promotion: false,
        paste_data_images: true,
        convert_urls: false,
        // allow iframes so YouTube embeds survive save/load
        extended_valid_elements: 'iframe[src|frameborder|style|scrolling|class|width|height|name|align|allowfullscreen|loading|title]',
        paste_postprocess: function(plugin, args) {
            convertYouTubeInNode(args.node);
        },
        content_style: [
            'details.spoiler { border:1px solid #e2e8f0; border-radius:6px; padding:4px 14px; margin:10px 0; background:#f8fafc; }',
            'details.spoiler summary { cursor:pointer; font-weight:600; padding:6px 0; user-select:none; color:#A6192E; }',
            'details.spoiler p { margin:8px 0; }',
            'video { max-width:100%; border-radius:6px; }'
        ].join(' '),
        images_upload_handler: function(blobInfo, success, failure){
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '/upload/image');
            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            xhr.onload = function(){
                if(xhr.status !== 200){ failure('HTTP Error: ' + xhr.status); return; }
                var json;
                try { json = JSON.parse(xhr.responseText); } catch(e){ failure('Invalid JSON'); return; }
                if(!json || typeof json.location !== 'string'){ failure('Invalid response'); return; }
                success(json.location);
            };
            xhr.onerror = function(){ failure('Network error'); };
            var fd = new FormData();
            fd.append('file', blobInfo.blob(), blobInfo.filename());
            xhr.send(fd);
        },
        setup: function(editor){
            // Spoiler / hideable dropdown button
            editor.ui.registry.addButton('spoiler', {
                text: '▼ Спойлер',
                tooltip: 'Вставити прихований блок',
                onAction: function(){
                    editor.insertContent(
                        '<details class="spoiler"><summary>Натисніть, щоб розгорнути</summary>' +
                        '<p>Вміст прихованого блоку...</p></details><p></p>'
                    );
                }
            });

            // Video upload button
            editor.ui.registry.addButton('uploadvideo', {
                text: '🎬 Відео',
                tooltip: 'Завантажити відео з комп\'ютера',
                onAction: function(){
                    var input = document.createElement('input');
                    input.type = 'file';
                    input.accept = 'video/mp4,video/webm,video/ogg,video/*';
                    input.style.cssText = 'position:fixed;top:-9999px;left:-9999px;opacity:0';
                    document.body.appendChild(input);
                    input.onchange = function(){
                        var file = input.files[0];
                        document.body.removeChild(input);
                        if(!file) return;

                        var progressToast = showVideoProgressToast(file.name);

                        var fd = new FormData();
                        fd.append('file', file);
                        var xhr = new XMLHttpRequest();
                        xhr.open('POST', '/upload/video');
                        xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

                        xhr.upload.onprogress = function(e){
                            if(e.lengthComputable){
                                updateVideoProgressToast(progressToast, Math.round(e.loaded / e.total * 100));
                            }
                        };
                        xhr.onload = function(){
                            if(xhr.status !== 200){
                                finishVideoProgressToast(progressToast, 'error', 'Помилка сервера: ' + xhr.status);
                                return;
                            }
                            var json;
                            try { json = JSON.parse(xhr.responseText); } catch(e){
                                finishVideoProgressToast(progressToast, 'error', 'Невірна відповідь сервера');
                                return;
                            }
                            finishVideoProgressToast(progressToast, 'success', 'Відео завантажено');
                            editor.insertContent(
                                '<p><video controls style="max-width:100%;border-radius:6px">' +
                                '<source src="' + json.location + '" type="' + file.type + '">' +
                                'Ваш браузер не підтримує відео.</video></p><p></p>'
                            );
                        };
                        xhr.onerror = function(){
                            finishVideoProgressToast(progressToast, 'error', 'Помилка мережі');
                        };
                        xhr.send(fd);
                    };
                    input.click();
                }
            });

            // Convert auto-linked YouTube URLs (typed then space/enter)
            editor.on('ExecCommand', function(e) {
                if (e.command === 'mceAutoLink') {
                    convertYouTubeInNode(editor.getBody());
                }
            });

            editor.on('init', function(){ if(onReady) onReady(editor); });
        }
    });
}


// ===== Modal helpers =====
function openModal(id){ document.getElementById(id).classList.add('active'); }
function closeModal(id){ document.getElementById(id).classList.remove('active'); }
document.querySelectorAll('.modal-overlay').forEach(function(el){
    el.addEventListener('click', function(e){ if(e.target === el) closeModal(el.id); });
});

// ===== Course selection =====
var _currentCourseId = null;
function selectCourse(id){
    document.querySelectorAll('.course-list-item').forEach(el => el.classList.remove('active'));
    document.querySelectorAll('.course-content').forEach(el => el.style.display = 'none');
    const noSel = document.getElementById('no-course-selected');
    if(noSel) noSel.style.display = 'none';

    const item = document.querySelector('.course-list-item[data-id="'+id+'"]');
    if(item) item.classList.add('active');
    const content = document.getElementById('course_content_' + id);
    if(content) content.style.display = 'block';

    _currentCourseId = id;
    localStorage.setItem('selectedCourse', id);
    initSortable(id);
}

function filterCourseList(q){
    const term = q.toLowerCase();
    document.querySelectorAll('.course-list-item').forEach(function(el){
        el.style.display = el.getAttribute('data-title').toLowerCase().includes(term) ? '' : 'none';
    });
}

document.addEventListener('DOMContentLoaded', function(){
    // Prefer ?course= param (returned from material save), fall back to localStorage
    const params = new URLSearchParams(window.location.search);
    const fromUrl = params.get('course');
    const saved = fromUrl || localStorage.getItem('selectedCourse');
    if(saved && document.getElementById('course_content_' + saved)){
        selectCourse(parseInt(saved));
    }
    // Clean the URL without triggering a reload
    if(fromUrl) history.replaceState({}, '', '/admin');
});

// ===== Course Actions =====
function openEditCourse(id){
    $.get('/courses/json/' + id, function(data){
        const d = JSON.parse(data);
        document.getElementById('editCourseId').value = d.id;
        document.getElementById('editCourseTitle').value = d.title;
        document.getElementById('editCourseDesc').value = d.description;
        openModal('editCourseModal');
    });
}

function deleteCourse(id, btn){
    if(!confirm('Видалити цей курс та весь його вміст?')) return;
    const form = document.createElement('form');
    form.method = 'POST'; form.action = '/courses';
    form.innerHTML = '<input name="_token" value="{{ csrf_token() }}" type="hidden"><input name="_method" value="DELETE" type="hidden"><input name="id" value="'+id+'" type="hidden">';
    document.body.appendChild(form); form.submit();
}

function openCourseProgress(courseId){
    const data = window._courseProgressData[courseId];
    if(!data) return;
    document.getElementById('progressModalTitle').textContent = 'Прогрес: ' + data.title;
    renderProgressTable(data.users);
    openModal('courseProgressModal');
    window._currentProgressUsers = data.users;
}

function renderProgressTable(users){
    const tbody = document.getElementById('progressTableBody');
    tbody.innerHTML = users.map(u => `
        <tr class="progress-row">
            <td>${u.name}</td>
            <td><div class="progress-bar-new"><div class="progress-bar-fill" style="width:${u.score}%"></div></div></td>
            <td><span class="${u.score >= 70 ? 'badge-pass' : (u.score > 0 ? 'badge-fail' : '')}">${u.score}%</span></td>
        </tr>
    `).join('');
}

function filterProgress(){
    const q = document.getElementById('progressSearch').value.toLowerCase();
    if(!window._currentProgressUsers) return;
    renderProgressTable(window._currentProgressUsers.filter(u => u.name.toLowerCase().includes(q)));
}

// ===== Module Actions =====
function openAddModule(courseId){
    document.getElementById('addModuleCourseId').value = courseId;
    openModal('addModuleModal');
}

function openEditModule(moduleId){
    $.get('/modules/json/' + moduleId, function(data){
        const d = JSON.parse(data);
        document.getElementById('editModuleId').value = d.id;
        document.getElementById('editModuleCourseId').value = d.course_id;
        document.getElementById('editModuleTitle').value = d.title;
        openModal('editModuleModal');
    });
}

function deleteModule(id, btn){
    if(!confirm('Видалити цей модуль та всі його матеріали?')) return;
    const form = document.createElement('form');
    form.method = 'POST'; form.action = '/modules';
    form.innerHTML = '<input name="_token" value="{{ csrf_token() }}" type="hidden"><input name="_method" value="DELETE" type="hidden"><input name="id" value="'+id+'" type="hidden">';
    document.body.appendChild(form); form.submit();
}

// ===== Drag & Drop (SortableJS) =====
var _sortableInstances = [];

function initSortable(courseId) {
    // Destroy previous instances
    _sortableInstances.forEach(function(s){ s.destroy(); });
    _sortableInstances = [];

    // --- Module order ---
    var modulesList = document.getElementById('modules_list_' + courseId);
    if (modulesList) {
        _sortableInstances.push(new Sortable(modulesList, {
            animation: 150,
            handle: '.module-drag-handle',
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            onEnd: function() { saveModuleOrder(courseId); }
        }));
    }

    // --- Material order + cross-module move ---
    document.querySelectorAll('#course_content_' + courseId + ' .module-block-materials').forEach(function(list) {
        _sortableInstances.push(new Sortable(list, {
            group: 'materials_' + courseId,   // same group = cross-module drag allowed
            animation: 150,
            handle: '.material-drag-handle',
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            onEnd: function() { saveMaterialOrder(courseId); }
        }));
    });
}

function saveModuleOrder(courseId) {
    var list = document.getElementById('modules_list_' + courseId);
    var order = Array.from(list.querySelectorAll(':scope > .module-block')).map(function(el) {
        return { id: el.getAttribute('data-id') };
    });
    $.ajax({
        url: '/modules/reorder', type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ order: order }),
        success: function(){ showToast('Порядок модулів збережено'); },
        error:   function(){ showToast('Помилка збереження', 'error'); }
    });
}

function saveMaterialOrder(courseId) {
    var modules = [];
    document.querySelectorAll('#course_content_' + courseId + ' .module-block-materials').forEach(function(list) {
        var moduleId = list.getAttribute('data-module');
        var materials = Array.from(list.querySelectorAll(':scope > .material-row')).map(function(el) {
            return { id: el.getAttribute('data-id') };
        });
        modules.push({ module_id: moduleId, materials: materials });
    });
    $.ajax({
        url: '/materials/reorder', type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ modules: modules }),
        success: function(){ showToast('Порядок матеріалів збережено'); },
        error:   function(){ showToast('Помилка збереження', 'error'); }
    });
}

// ===== Material Actions =====
function openAddMaterial(moduleId){
    const courseId = _currentCourseId || localStorage.getItem('selectedCourse') || '';
    window.open('/materials/create?module_id=' + moduleId + '&course_id=' + courseId, '_blank');
}

function openEditMaterial(id){
    window.open('/materials/' + id + '/edit', '_blank');
}
</script>
@endsection
