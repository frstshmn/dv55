@if (Auth::user()->is_admin != 1)
    @php header("Location: " . URL::to('/cabinet'), true, 302); exit(); @endphp
@endif

@extends('layouts.admin_new')

@section('title', 'Тести')
@section('topbar-title', 'Керування тестами')

@section('content')

<div class="page-header">
    <div>
        <h1>Тести</h1>
        <div class="page-header-sub">Керування тестами та запитаннями за модулями</div>
    </div>
</div>

<div class="courses-split">

    {{-- Left: course list --}}
    <div class="course-list-panel">
        <input type="text" class="form-input-new course-list-search" placeholder="Пошук курсів..." oninput="filterTestCourseList(this.value)">
        <div class="course-list-body">
            @foreach($courses as $course)
            <div class="course-list-item" data-id="{{ $course->id }}" data-title="{{ $course->title }}" onclick="selectTestCourse({{ $course->id }})">
                <div class="course-list-item-title">{{ $course->title }}</div>
                <div class="course-list-item-meta">
                    <span>{{ count($course->modules) }} модулів</span>
                    <span>{{ $course->modules->sum(fn($m) => count($m->tests)) }} тестів</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Right: course content --}}
    <div class="course-content-panel">
        <div id="no-test-course-selected" class="empty-state" style="padding:80px 20px">
            <div class="empty-state-icon">👈</div>
            <div class="empty-state-text">Оберіть курс для перегляду</div>
        </div>

        @foreach($courses as $course)
        <div class="course-content" id="test_course_content_{{ $course->id }}" style="display:none">

            {{-- Course header --}}
            <div class="course-content-header">
                <div style="flex:1;min-width:0">
                    <div style="font-size:1.2rem;font-weight:700;color:var(--text-primary);margin-bottom:5px">{{ $course->title }}</div>
                    <div style="display:flex;gap:20px">
                        <div class="course-stat">
                            <div class="course-stat-value">{{ count($course->modules) }}</div>
                            <div class="course-stat-label">Модулів</div>
                        </div>
                        <div class="course-stat">
                            <div class="course-stat-value">{{ $course->modules->sum(fn($m) => count($m->tests)) }}</div>
                            <div class="course-stat-label">Тестів</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Modules with tests --}}
            <div>
                <div class="modules-section-header">
                    <span class="panel-card-title">Модулі</span>
                </div>

                @forelse($course->modules as $module)
                <div class="module-block" id="test_module_block_{{ $module->id }}">
                    <div class="module-block-header">
                        <div style="display:flex;align-items:center;gap:10px;min-width:0;overflow:hidden">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;color:var(--accent)"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>
                            <span style="font-weight:600;color:var(--text-primary);overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ $module->title }}</span>
                            <span style="font-size:0.72rem;color:var(--text-muted);flex-shrink:0">{{ count($module->tests) }} тестів</span>
                        </div>
                    </div>
                    <div class="module-block-materials">
                        @php $i = 1; @endphp
                        @forelse($module->tests as $test)
                        <div class="material-row">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;color:var(--text-muted)"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
                            <span class="material-row-title">Тест {{ $i }}</span>
                            <span style="font-size:0.78rem;color:var(--text-muted);margin-right:8px">⏱ {{ $test->time }} хв</span>
                            <button class="list-action-btn edit" onclick="viewTestProgress({{ $test->id }}, {{ $i }})" title="Прогрес">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                            </button>
                            <button class="list-action-btn edit" onclick="openEditTest({{ $test->id }})" title="Редагувати">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </button>
                            <button class="list-action-btn delete" onclick="deleteTest({{ $test->id }}, this)" title="Видалити">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                            </button>
                        </div>
                        @php $i++; @endphp
                        @empty
                        <div style="font-size:0.8rem;color:var(--text-muted);padding:10px 4px;font-style:italic">Тестів немає</div>
                        @endforelse

                        <button class="btn-new btn-primary-new btn-sm-new" style="margin-top:10px;justify-content:center" onclick="openAddTest({{ $module->id }})">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            Додати тест
                        </button>
                    </div>
                </div>
                @empty
                <div class="empty-state" style="padding:40px 20px">
                    <div class="empty-state-icon">📂</div>
                    <div class="empty-state-text">Модулів немає.</div>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Store progress data per test --}}
        @foreach($course->modules as $module)
            @foreach($module->tests as $test)
            <script>
            window._testProgressData = window._testProgressData || {};
            window._testProgressData[{{ $test->id }}] = {
                users: [
                    @foreach($users as $user)
                        @if($user->isRegistered($course->id))
                        {
                            name: @json($user->name),
                            answered: {{ $test->isAnswered($user->id) ? 'true' : 'false' }},
                            score: {{ $test->isAnswered($user->id) ? $test->userResult($user->id) : 0 }},
                            user_id: {{ $user->id }},
                            test_id: {{ $test->id }}
                        },
                        @endif
                    @endforeach
                ]
            };
            </script>
            @endforeach
        @endforeach

        @endforeach
    </div>
</div>


{{-- ===== MODALS ===== --}}

{{-- Add Test --}}
<div class="modal-overlay" id="addTestModal">
    <div class="modal-box modal-lg">
        <div class="modal-header-new">
            <h5>Новий тест</h5>
            <button class="modal-close" onclick="closeModal('addTestModal')">✕</button>
        </div>
        <form method="POST" action="/tests" autocomplete="off" id="addTestForm">
            @csrf
            <input type="hidden" id="addTestModuleId" name="module_id">
            <input type="hidden" id="addTestQuestionCount" name="count" value="0">
            <div class="modal-body-new">
                <div class="form-group-new">
                    <label class="form-label-new">Час (хвилини)</label>
                    <input type="number" name="time" placeholder="напр. 30" class="form-input-new" required min="1">
                </div>
                <div class="form-group-new" style="display:flex;align-items:center;gap:10px">
                    <input type="checkbox" name="duplicate" id="addDuplicate" style="accent-color:var(--accent);width:16px;height:16px;cursor:pointer">
                    <label for="addDuplicate" style="font-size:0.85rem;font-weight:500;color:var(--text-secondary);cursor:pointer">Дублювати тест для всіх модулів курсу</label>
                </div>
                <div id="addQuestionList"></div>
                <button type="button" class="btn-new btn-secondary-new" onclick="addQuestion('add')">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Додати запитання
                </button>
            </div>
            <div class="modal-footer-new">
                <button type="button" class="btn-new btn-secondary-new" onclick="closeModal('addTestModal')">Скасувати</button>
                <button type="submit" class="btn-new btn-primary-new">Створити тест</button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Test --}}
<div class="modal-overlay" id="editTestModal">
    <div class="modal-box modal-lg">
        <div class="modal-header-new">
            <h5>Редагувати тест</h5>
            <button class="modal-close" onclick="closeModal('editTestModal')">✕</button>
        </div>
        <form method="POST" action="/tests" autocomplete="off" id="editTestForm">
            @csrf @method('PUT')
            <input type="hidden" id="editTestId" name="test_id">
            <input type="hidden" id="editTestModuleId" name="module_id">
            <input type="hidden" id="editTestQuestionCount" name="count" value="0">
            <div class="modal-body-new">
                <div class="form-group-new">
                    <label class="form-label-new">Час (хвилини)</label>
                    <input type="number" id="editTestTime" name="time" class="form-input-new" required min="1">
                </div>
                <div id="editQuestionList"></div>
                <button type="button" class="btn-new btn-secondary-new" onclick="addQuestion('edit')">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Додати запитання
                </button>
            </div>
            <div class="modal-footer-new">
                <button type="button" class="btn-new btn-secondary-new" onclick="closeModal('editTestModal')">Скасувати</button>
                <button type="submit" class="btn-new btn-primary-new">Зберегти тест</button>
            </div>
        </form>
    </div>
</div>

{{-- Test Progress --}}
<div class="modal-overlay" id="testProgressModal">
    <div class="modal-box modal-lg">
        <div class="modal-header-new">
            <h5 id="testProgressTitle">Прогрес тесту</h5>
            <button class="modal-close" onclick="closeModal('testProgressModal')">✕</button>
        </div>
        <div class="modal-body-new">
            <input type="text" class="table-search" id="testProgressSearch" placeholder="Пошук за ім'ям..." oninput="filterTestProgress()">
            <table class="progress-table">
                <thead>
                    <tr><th>Слухач</th><th>Результат</th><th>Статус</th><th>Відповіді</th></tr>
                </thead>
                <tbody id="testProgressBody"></tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
function openModal(id){ document.getElementById(id).classList.add('active'); }
function closeModal(id){ document.getElementById(id).classList.remove('active'); }
document.querySelectorAll('.modal-overlay').forEach(function(el){
    el.addEventListener('click', function(e){ if(e.target === el) closeModal(el.id); });
});

let addQCount = 0, editQCount = 0;

function buildQuestionHTML(prefix, num, q){
    const qId = prefix === 'add' ? 'q'+num : (q ? 'q'+q.id : 'new_q'+num);
    const questionName = prefix === 'add' ? 'question_'+num : (q ? 'question_'+q.id : 'new_question_'+num);
    const correctName = prefix === 'add' ? 'correct_answer_'+num : (q ? 'correct_answer_'+q.id : 'new_correct_answer_'+num);

    const qText = q ? q.question : '';
    const ca = q ? q.correct_answer : null;
    const esc = s => s ? s.replace(/"/g, '&quot;').replace(/</g, '&lt;') : '';

    return `<div class="question-card" id="${qId}">
        <div class="question-card-header">
            <span class="question-card-label">Запитання ${q ? q.id : num}</span>
            <button type="button" onclick="removeQuestion('${qId}')" style="background:none;border:none;cursor:pointer;color:var(--danger);font-size:1.1rem;line-height:1">✕</button>
        </div>
        <input type="text" name="${questionName}" value="${esc(qText)}" placeholder="Введіть запитання тут..." class="form-input-new" required style="margin-bottom:10px">
        <div class="question-answers">
            ${[1,2,3,4].map(i => {
                const vname = prefix === 'add' ? 'variant_'+i+'_'+num : (q ? 'variant_'+i+'_'+q.id : 'new_variant_'+i+'_'+num);
                const vval = q ? esc(q['v_'+i]) : '';
                const checked = (ca && ca == i) ? 'checked' : '';
                return `<div class="answer-option">
                    <input type="radio" name="${correctName}" value="${i}" id="${qId}_r${i}" ${checked} required>
                    <label for="${qId}_r${i}">${i}.</label>
                    <input type="text" name="${vname}" value="${vval}" placeholder="Варіант ${i}" class="form-input-new" required style="flex:1">
                </div>`;
            }).join('')}
        </div>
    </div>`;
}

function addQuestion(context){
    if(context === 'add'){
        addQCount++;
        document.getElementById('addQuestionList').insertAdjacentHTML('beforeend', buildQuestionHTML('add', addQCount, null));
        document.getElementById('addTestQuestionCount').value = document.querySelectorAll('#addQuestionList .question-card').length;
    } else {
        editQCount++;
        document.getElementById('editQuestionList').insertAdjacentHTML('beforeend', buildQuestionHTML('edit_new', editQCount, null));
        document.getElementById('editTestQuestionCount').value = document.querySelectorAll('#editQuestionList .question-card').length;
    }
}

function removeQuestion(id){
    const el = document.getElementById(id);
    if(el){ el.remove(); }
    document.getElementById('addTestQuestionCount').value = document.querySelectorAll('#addQuestionList .question-card').length;
    if(document.getElementById('editTestQuestionCount'))
        document.getElementById('editTestQuestionCount').value = document.querySelectorAll('#editQuestionList .question-card').length;
}

function openAddTest(moduleId){
    addQCount = 0;
    document.getElementById('addTestModuleId').value = moduleId;
    document.getElementById('addQuestionList').innerHTML = '';
    document.getElementById('addTestQuestionCount').value = 0;
    document.getElementById('addTestForm').reset();
    document.getElementById('addTestModuleId').value = moduleId;
    openModal('addTestModal');
}

function openEditTest(testId){
    editQCount = 0;
    $.get('/tests/json/' + testId, function(data){
        const d = JSON.parse(data);
        document.getElementById('editTestId').value = d.id;
        document.getElementById('editTestModuleId').value = d.module_id;
        document.getElementById('editTestTime').value = d.time;
    });
    $.get('/questions/json/' + testId, function(data){
        const questions = JSON.parse(data);
        const list = document.getElementById('editQuestionList');
        list.innerHTML = '';
        questions.forEach(function(q){
            list.insertAdjacentHTML('beforeend', buildQuestionHTML('edit', 0, q));
        });
        document.getElementById('editTestQuestionCount').value = questions.length;
    });
    openModal('editTestModal');
}

function deleteTest(id, btn){
    if(!confirm('Видалити цей тест та всі відповіді до нього?')) return;
    const form = document.createElement('form');
    form.method = 'POST'; form.action = '/tests';
    form.innerHTML = '<input name="_token" value="{{ csrf_token() }}" type="hidden"><input name="_method" value="DELETE" type="hidden"><input name="id" value="'+id+'" type="hidden">';
    document.body.appendChild(form); form.submit();
}

let _currentTestProgressUsers = [];

function viewTestProgress(testId, num){
    const data = window._testProgressData[testId];
    if(!data) return;
    document.getElementById('testProgressTitle').textContent = 'Прогрес: Тест ' + num;
    _currentTestProgressUsers = data.users;
    renderTestProgressTable(data.users);
    openModal('testProgressModal');
}

function renderTestProgressTable(users){
    const tbody = document.getElementById('testProgressBody');
    tbody.innerHTML = users.map(u => `
        <tr>
            <td>${u.name}</td>
            <td>${u.answered ? '<div class="progress-bar-new"><div class="progress-bar-fill" style="width:'+u.score+'%"></div></div> '+u.score+'%' : '<span style="color:var(--text-muted)">—</span>'}</td>
            <td>${u.answered ? '<span class="'+(u.score>=70?'badge-pass':'badge-fail')+'">'+(u.score>=70?'Пройдено':'Не пройдено')+'</span>' : '<span style="color:var(--text-muted);font-size:0.78rem">Не відповів</span>'}</td>
            <td>${u.answered ? '<a href="/results?user_id='+u.user_id+'&test_id='+u.test_id+'" style="font-size:0.78rem;color:var(--accent)">Переглянути</a>' : '<span style="color:var(--text-muted);font-size:0.78rem">—</span>'}</td>
        </tr>
    `).join('');
}

function filterTestProgress(){
    const q = document.getElementById('testProgressSearch').value.toLowerCase();
    renderTestProgressTable(_currentTestProgressUsers.filter(u => u.name.toLowerCase().includes(q)));
}

// ===== Course selection =====
function selectTestCourse(id){
    document.querySelectorAll('.course-list-item').forEach(el => el.classList.remove('active'));
    document.querySelectorAll('.course-content').forEach(el => el.style.display = 'none');
    const noSel = document.getElementById('no-test-course-selected');
    if(noSel) noSel.style.display = 'none';

    const item = document.querySelector('.course-list-item[data-id="'+id+'"]');
    if(item) item.classList.add('active');
    const content = document.getElementById('test_course_content_' + id);
    if(content) content.style.display = 'block';

    localStorage.setItem('selectedTestCourse', id);
}

function filterTestCourseList(q){
    const term = q.toLowerCase();
    document.querySelectorAll('.course-list-item').forEach(function(el){
        el.style.display = el.getAttribute('data-title').toLowerCase().includes(term) ? '' : 'none';
    });
}

document.addEventListener('DOMContentLoaded', function(){
    const saved = localStorage.getItem('selectedTestCourse');
    if(saved && document.getElementById('test_course_content_' + saved)){
        selectTestCourse(saved);
    }
});
</script>
@endsection
