@if (Auth::user()->is_admin != 1)
    @php header("Location: " . URL::to('/cabinet'), true, 302); exit(); @endphp
@endif

@extends('layouts.admin_new')

@section('title', 'Користувачі')
@section('topbar-title', 'Керування користувачами')

@section('content')

<div class="page-header">
    <div>
        <h1>Користувачі</h1>
        <div class="page-header-sub">Керування обліковими записами слухачів та адміністраторів</div>
    </div>
    <button class="btn-new btn-primary-new" onclick="openModal('addUserModal')">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Новий користувач
    </button>
</div>

<div class="users-grid">
    {{-- Regular Users --}}
    <div class="user-card">
        <div class="user-card-header">
            <span style="display:flex;align-items:center;gap:8px">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--accent)"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                Слухачі
                <span style="font-size:0.78rem;background:var(--accent-light);color:var(--accent);padding:2px 8px;border-radius:20px;font-weight:600">{{ $users->where('is_admin', 0)->count() }}</span>
            </span>
        </div>
        <div class="user-card-body">
            @php $colors = ['#A6192E','#7c3aed','#2563eb','#059669','#d97706','#dc2626']; $ci = 0; @endphp
            @foreach($users as $user)
                @if($user->is_admin == 0)
                <div class="user-item">
                    <div class="user-avatar" style="background:{{ $colors[$ci % count($colors)] }}">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
                    @php $ci++; @endphp
                    <div class="user-info">
                        <div class="user-name">{{ $user->name }}</div>
                        <div class="user-email">{{ $user->email }}</div>
                    </div>
                    <div class="list-item-actions">
                        <button class="list-action-btn edit" onclick="openEditUser({{ $user->id }})" title="Редагувати">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        </button>
                        <button class="list-action-btn delete" onclick="deleteUser({{ $user->id }}, this)" title="Видалити">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                        </button>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>

    {{-- Administrators --}}
    <div class="user-card">
        <div class="user-card-header">
            <span style="display:flex;align-items:center;gap:8px">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--warning)"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                Адміністратори
                <span style="font-size:0.78rem;background:rgba(245,158,11,0.12);color:var(--warning);padding:2px 8px;border-radius:20px;font-weight:600">{{ $users->where('is_admin', 1)->count() }}</span>
            </span>
        </div>
        <div class="user-card-body">
            @foreach($users as $user)
                @if($user->is_admin == 1)
                <div class="user-item">
                    <div class="user-avatar" style="background:#d97706">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
                    <div class="user-info">
                        <div class="user-name">
                            {{ $user->name }}
                            @if($user->id == Auth::user()->id)
                                <span class="user-you-badge">● ви</span>
                            @endif
                        </div>
                        <div class="user-email">{{ $user->email }}</div>
                    </div>
                    <div class="list-item-actions">
                        <button class="list-action-btn edit" onclick="openEditUser({{ $user->id }})" title="Редагувати">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        </button>
                        @if($user->id != Auth::user()->id)
                        <button class="list-action-btn delete" onclick="deleteUser({{ $user->id }}, this)" title="Видалити">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                        </button>
                        @endif
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>
</div>


{{-- ===== MODALS ===== --}}

{{-- Add User --}}
<div class="modal-overlay" id="addUserModal">
    <div class="modal-box">
        <div class="modal-header-new">
            <h5>Новий користувач</h5>
            <button class="modal-close" onclick="closeModal('addUserModal')">✕</button>
        </div>
        <form method="POST" action="/users" autocomplete="off">
            @csrf
            <div class="modal-body-new">
                <div class="form-group-new">
                    <label class="form-label-new">Повне ім'я</label>
                    <input type="text" name="name" placeholder="Ім'я та прізвище" class="form-input-new" required>
                </div>
                <div class="form-group-new">
                    <label class="form-label-new">Email</label>
                    <input type="email" name="email" placeholder="Email для входу" class="form-input-new" required>
                </div>
                <div class="form-group-new">
                    <label class="form-label-new">Пароль</label>
                    <input type="password" name="password" placeholder="Мінімум 8 символів" class="form-input-new" required>
                </div>
                <div class="form-group-new">
                    <label class="form-label-new">Підтвердити пароль</label>
                    <input type="password" name="password_confirmation" placeholder="Повторіть пароль" class="form-input-new" required>
                </div>
                <div class="form-group-new">
                    <label class="form-label-new">Роль</label>
                    <select name="is_admin" class="form-input-new">
                        <option value="0">Слухач</option>
                        <option value="1">Адміністратор</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer-new">
                <button type="button" class="btn-new btn-secondary-new" onclick="closeModal('addUserModal')">Скасувати</button>
                <button type="submit" class="btn-new btn-primary-new">Створити користувача</button>
            </div>
        </form>
    </div>
</div>

{{-- Edit User --}}
<div class="modal-overlay" id="editUserModal">
    <div class="modal-box modal-lg">
        <div class="modal-header-new">
            <h5>Редагувати користувача</h5>
            <button class="modal-close" onclick="closeModal('editUserModal')">✕</button>
        </div>
        <div class="modal-body-new" style="display:grid;grid-template-columns:1fr 1fr;gap:24px">
            {{-- Left: User form --}}
            <div>
                <form method="POST" action="/users" autocomplete="off" id="editUserForm">
                    @csrf @method('PUT')
                    <input type="hidden" id="editUserId" name="id">
                    <div class="form-group-new">
                        <label class="form-label-new">Повне ім'я</label>
                        <input type="text" id="editUserName" name="name" class="form-input-new" required>
                    </div>
                    <div class="form-group-new">
                        <label class="form-label-new">Email</label>
                        <input type="email" id="editUserEmail" name="email" class="form-input-new" required>
                    </div>
                    <div class="form-group-new">
                        <label class="form-label-new">Новий пароль <span style="font-weight:400;text-transform:none">(залиште порожнім для збереження)</span></label>
                        <input type="password" name="password" placeholder="Новий пароль" class="form-input-new">
                    </div>
                    <div class="form-group-new">
                        <label class="form-label-new">Підтвердити пароль</label>
                        <input type="password" name="password_confirmation" placeholder="Повторіть новий пароль" class="form-input-new">
                    </div>
                    <div class="form-group-new">
                        <label class="form-label-new">Роль</label>
                        <select id="editUserIsAdmin" name="is_admin" class="form-input-new">
                            <option value="0">Слухач</option>
                            <option value="1">Адміністратор</option>
                        </select>
                    </div>
                    <button type="submit" class="btn-new btn-primary-new" style="width:100%">Зберегти зміни</button>
                </form>
            </div>
            {{-- Right: Course enrollment --}}
            <div>
                <div style="font-size:0.82rem;font-weight:600;color:var(--text-secondary);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:12px">Записи на курси</div>
                <div style="margin-bottom:12px">
                    <div style="font-size:0.8rem;color:var(--text-muted);margin-bottom:8px">Додати курс:</div>
                    <div style="display:flex;flex-wrap:wrap;gap:6px">
                        @foreach($courses as $course)
                        <form method="POST" action="/usercourses">
                            @csrf
                            <input type="hidden" name="user_id" class="enroll-user-id" value="">
                            <input type="hidden" name="course_id" value="{{ $course->id }}">
                            <button type="submit" class="btn-new btn-secondary-new btn-sm-new">+ {{ $course->title }}</button>
                        </form>
                        @endforeach
                    </div>
                </div>
                <div style="font-size:0.8rem;color:var(--text-muted);margin-bottom:8px">Записані курси:</div>
                <div id="editUserCoursesList"></div>
            </div>
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

function deleteUser(id, btn){
    if(!confirm('Видалити цього користувача та всі його дані?')) return;
    const form = document.createElement('form');
    form.method = 'POST'; form.action = '/users';
    form.innerHTML = '<input name="_token" value="{{ csrf_token() }}" type="hidden"><input name="_method" value="DELETE" type="hidden"><input name="id" value="'+id+'" type="hidden">';
    document.body.appendChild(form); form.submit();
}

let _editingUserId = null;

function openEditUser(id){
    _editingUserId = id;
    $.get('/users/json/' + id, function(data){
        const d = JSON.parse(data);
        document.getElementById('editUserId').value = d.id;
        document.getElementById('editUserName').value = d.name;
        document.getElementById('editUserEmail').value = d.email;
        document.getElementById('editUserIsAdmin').value = d.is_admin;
        document.querySelectorAll('.enroll-user-id').forEach(el => el.value = d.id);
    });

    $.get('/users/json/' + id + '/courses', function(data){
        const courses = JSON.parse(data);
        const list = document.getElementById('editUserCoursesList');
        if(courses.length === 0){
            list.innerHTML = '<div style="font-size:0.8rem;color:var(--text-muted)">Немає записаних курсів.</div>';
        } else {
            list.innerHTML = courses.map(c => `
                <div class="user-course-chip">
                    <span>${c.title}</span>
                    <button type="button" onclick="removeCourseFromUser(${c.id}, ${id})" class="list-action-btn delete" title="Видалити">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </button>
                </div>
            `).join('');
        }
    });

    openModal('editUserModal');
}

function removeCourseFromUser(courseId, userId){
    if(!confirm('Видалити доступ користувача до цього курсу?')) return;
    $.ajax({
        url: '/usercourses', type: 'DELETE',
        data: { user_id: userId, course_id: courseId },
        success: function(){ openEditUser(userId); showToast('Курс видалено'); },
        error: function(){ showToast('Помилка видалення курсу', 'error'); }
    });
}
</script>
@endsection
