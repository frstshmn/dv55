<div class="test-intro-card">
    <div class="test-intro-icon">📋</div>
    <h2 class="test-intro-title">Тест: {{ $test->module->title }}</h2>
    <p class="test-intro-meta">Час на проходження: <strong>{{ $test->time }} хв.</strong></p>
    <p class="test-intro-meta">4 варіанти відповідей, серед яких <strong style="color:var(--danger)">ТІЛЬКИ 1</strong> правильний</p>
    <p class="test-intro-warning">⚠️ Під час тесту доступ до матеріалів буде заблокований. Якщо виникли технічні проблеми — зверніться до інструктора.</p>
    <button class="btn-start-test" id="start_test" data-id="{{ $test->id }}" data-time="{{ $test->time }}">
        Почати тест
    </button>
</div>
