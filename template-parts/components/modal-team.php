<?php

/**
 * Componente: Modal da Equipe e Scripts
 * @var array $args Espera receber $args['team_data'] (Array com os dados para o JS)
 */
$js_team_data = $args['team_data'] ?? [];
?>

<style>
    .modal-backdrop {
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease;
    }

    .modal-backdrop.active {
        opacity: 1;
        pointer-events: auto;
    }

    .modal-content {
        transform: scale(0.95);
        opacity: 0;
        transition: all 0.3s ease;
    }

    .modal-backdrop.active .modal-content {
        transform: scale(1);
        opacity: 1;
    }
</style>

<div id="profile-modal" class="fixed inset-0 z-[100] hidden modal-backdrop bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto relative modal-content flex flex-col md:flex-row overflow-hidden">
        <button onclick="closeProfile()" class="absolute top-4 right-4 z-50 w-10 h-10 bg-white/80 hover:bg-white rounded-full flex items-center justify-center text-gray-500 hover:text-durham transition-colors shadow-sm">
            <i class="ph-bold ph-x text-xl"></i>
        </button>
        <div class="md:w-1/3 bg-neutral-50 p-8 flex flex-col items-center text-center border-r border-gray-100">
            <div class="w-40 h-40 rounded-full overflow-hidden border-4 border-white shadow-lg mb-6" id="modal-img-container"></div>
            <h3 id="modal-name" class="font-serif font-bold text-2xl text-neutral-900 mb-2 leading-tight"></h3>
            <p id="modal-role" class="text-sm font-bold text-durham uppercase tracking-wider mb-6"></p>
            <div class="w-full text-left">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Research Interests</p>
                <div id="modal-tags" class="flex flex-wrap gap-2"></div>
            </div>
        </div>
        <div class="md:w-2/3 p-8 md:p-12 overflow-y-auto">
            <div class="mb-8">
                <h4 class="font-serif font-bold text-xl text-neutral-900 mb-4 border-b border-gray-100 pb-2">Biography</h4>
                <div id="modal-bio" class="prose prose-sm text-gray-600 leading-relaxed space-y-4"></div>
            </div>
            <div>
                <h4 class="font-serif font-bold text-xl text-neutral-900 mb-4 border-b border-gray-100 pb-2">Selected Publications</h4>
                <ul id="modal-pubs" class="space-y-4 text-sm text-gray-600"></ul>
            </div>
        </div>
    </div>
</div>

<script>
    const teamData = <?php echo wp_json_encode($js_team_data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;
    const modal = document.getElementById('profile-modal');
    // ... [O restante do JS do Modal exatamente como no arquivo anterior] ...
    function openProfile(key) {
        const data = teamData[key];
        if (!data) return;
        document.getElementById('modal-img-container').innerHTML = data.img ? `<img src="${data.img}" class="w-full h-full object-cover">` : `<div class="w-full h-full bg-gray-100 flex items-center justify-center"><i class="ph-fill ph-user text-5xl text-gray-300"></i></div>`;
        document.getElementById('modal-name').innerText = data.name;
        document.getElementById('modal-role').innerText = data.role;
        document.getElementById('modal-bio').innerHTML = data.bio;
        document.getElementById('modal-tags').innerHTML = data.interests.map(tag => `<span class="px-2 py-1 bg-purple-50 text-durham text-xs font-bold uppercase rounded border border-purple-100">${tag}</span>`).join('');
        document.getElementById('modal-pubs').innerHTML = (data.pubs && data.pubs.length > 0) ? data.pubs.map(pub => `<li class="pl-4 border-l-2 border-durham/30 leading-snug">${pub}</li>`).join('') : '<li class="text-gray-400 italic">No recent publications listed.</li>';
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.add('active');
        }, 10);
        document.body.style.overflow = 'hidden';
    }

    function closeProfile() {
        modal.classList.remove('active');
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }, 300);
    }
    modal.addEventListener('click', (e) => {
        if (e.target === modal) closeProfile();
    });
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) closeProfile();
    });
</script>