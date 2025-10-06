<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tablero Kanban</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        
        /* --- INICIO: CAMBIOS PARA DISEÑO RESPONSIVO --- */

        /* Estilos por defecto (Móvil) */
        .kanban-board { 
            display: block; /* Las columnas se apilan por defecto */
            padding: 1rem; 
        }
        .kanban-column { 
            width: 100%; /* Ocupan todo el ancho */
            margin-bottom: 1.5rem; /* Espacio entre columnas apiladas */
            max-height: none; /* Quitamos la altura máxima en móvil */
            display: flex; 
            flex-direction: column;
            background-color: #f8f9fa; 
            border-radius: 0.75rem; 
        }

        /* Estilos para pantallas medianas y grandes (768px en adelante) */
        @media (min-width: 768px) {
            .kanban-board {
                display: flex;
                gap: 1.5rem;
                padding: 1.5rem;
                overflow-x: auto;
                min-height: calc(100vh - 100px);
                align-items: flex-start;
            }
            .kanban-column {
                flex: 0 0 340px; /* Vuelve al ancho fijo */
                margin-bottom: 0;
                max-height: calc(100vh - 150px);
            }
        }
        
        /* --- FIN: CAMBIOS PARA DISEÑO RESPONSIVO --- */

        .column-header { padding: 0.75rem 1rem; font-weight: 600; border-top-left-radius: 0.75rem; border-top-right-radius: 0.75rem; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(0,0,0,0.05); cursor: grab; }
        .column-header:active { cursor: grabbing; }
        .column-header.wip-exceeded { background-color: #fee2e2 !important; color: #b91c1c; }
        .tasks-container { padding: 0.5rem; overflow-y: auto; flex-grow: 1; }
        .kanban-task { background-color: white; padding: 1rem; border-radius: 0.5rem; margin-bottom: 0.75rem; box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1); cursor: grab; }
        .sortable-ghost { opacity: 0.4; background: #c8ebfb; }
        .tasks-container::-webkit-scrollbar { width: 8px; }
        .tasks-container::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
        .tasks-container::-webkit-scrollbar-thumb { background: #ccc; border-radius: 10px; }
        .modal-body::-webkit-scrollbar { width: 6px; }
        .modal-body::-webkit-scrollbar-thumb { background: #ddd; border-radius: 10px; }
        .tab-button { padding: 0.5rem 1rem; border-bottom: 2px solid transparent; }
        .tab-button.active { border-color: #3b82f6; color: #3b82f6; }
        .tag { padding: 2px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 500; }
        #appContainer.hidden, #authContainer.hidden { display: none; }
    </style>
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/phosphor-icons/1.4.2/css/phosphor.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <div id="authContainer" class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div><h2 id="authTitle" class="mt-6 text-center text-3xl font-extrabold text-gray-900">Iniciar sesión</h2></div>
            <form id="authForm" class="mt-8 space-y-6" onsubmit="return false;">
                <div class="rounded-md shadow-sm -space-y-px">
                    <div><label for="username" class="sr-only">Nombre de usuario</label><input id="username" name="name" type="text" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Nombre de usuario"></div>
                    <div><label for="password" class="sr-only">Contraseña</label><input id="password" name="password" type="password" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Contraseña"></div>
                </div>
                <div id="authMessage" class="text-sm text-red-600"></div>
                <div><button id="submitAuthBtn" type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Entrar</button></div>
            </form>
            <p class="text-center text-sm"><a href="#" id="toggleAuthMode" class="font-medium text-indigo-600 hover:text-indigo-500">¿No tienes cuenta? Regístrate</a></p>
        </div>
    </div>
    <div id="appContainer" class="hidden">
        <header class="bg-white shadow-md p-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Mi Tablero Kanban</h1>
            <div class="flex items-center gap-4">
                <div class="relative"><i class="ph-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i><input type="text" id="searchInput" placeholder="Buscar tareas..." class="pl-10 pr-4 py-2 border rounded-lg"></div>
                <button id="addColumnBtn" class="bg-blue-600 text-white font-semibold px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center gap-2"><i class="ph-plus"></i> Nueva Columna</button>
                <div id="userInfo" class="text-sm font-semibold text-gray-700"></div>
                <button id="logoutBtn" class="text-sm text-red-600 hover:underline">Cerrar Sesión</button>
            </div>
        </header>
        <main id="kanbanBoard" class="kanban-board"></main>
    </div>
    <div id="taskModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl h-[90vh] flex flex-col relative">
            <form id="taskForm" class="flex flex-col flex-grow">
                <div class="flex justify-between items-center p-4 border-b"><h2 id="taskModalTitle" class="text-2xl font-bold"></h2><button type="button" id="closeTaskModal" class="text-gray-500 text-2xl">&times;</button></div>
                <div class="flex flex-grow overflow-hidden pb-20">
                    <div class="w-2/3 p-6 overflow-y-auto modal-body">
                        <input type="hidden" id="taskId" name="id"><input type="hidden" id="taskColumnId" name="column_id">
                        <div class="mb-4"><label for="taskTitle" class="block text-sm font-medium text-gray-700 mb-1">Título</label><input type="text" id="taskTitle" name="title" class="w-full border-gray-300 rounded-lg" required></div>
                        <div class="mb-4"><label for="taskDescription" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label><textarea id="taskDescription" name="description" rows="5" class="w-full border-gray-300 rounded-lg"></textarea></div>
                        <div class="border-t pt-4">
                            <div class="flex border-b mb-4">
                                <button type="button" class="tab-button active" data-tab="subtasks"><i class="ph-check-square-offset mr-1"></i> Subtareas</button>
                                <button type="button" class="tab-button" data-tab="attachments"><i class="ph-paperclip mr-1"></i> Adjuntos</button>
                                <button type="button" class="tab-button" data-tab="comments"><i class="ph-chats mr-1"></i> Comentarios</button>
                            </div>
                            <div id="tab-content">
                                <div id="subtasks-tab" class="tab-pane">
                                    <div id="subtaskList" class="space-y-2"></div>
                                    <div class="mt-4 flex gap-2"><input type="text" id="newSubtaskTitle" placeholder="Nueva subtarea..." class="flex-grow border-gray-300 rounded-lg"><button type="button" id="addSubtaskBtn" class="bg-gray-200 px-3 py-1 rounded-md">Añadir</button></div>
                                </div>
                                <div id="attachments-tab" class="tab-pane hidden">
                                    <div id="attachmentList" class="space-y-2"></div>
                                    <div class="mt-4"></div>
                                </div>
                                <div id="comments-tab" class="tab-pane hidden">
                                    <div class="mt-4 flex gap-2"><textarea id="newCommentText" placeholder="Escribe un comentario..." rows="2" class="flex-grow border-gray-300 rounded-lg"></textarea><button type="button" id="addCommentBtn" class="bg-blue-600 text-white font-semibold px-4 rounded-lg">Enviar</button></div>
                                    <div id="commentList" class="space-y-4 mt-4 max-h-60 overflow-y-auto"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-1/3 bg-gray-50 p-6 border-l overflow-y-auto modal-body">
                        <h3 class="font-semibold text-gray-800 mb-4">Detalles</h3>
                        <div class="space-y-4">
                            <div><label for="taskUser" class="block text-sm font-medium text-gray-700 mb-1">Asignar a</label><select id="taskUser" name="user_id" class="w-full border-gray-300 rounded-lg"></select></div>
                            <div><label for="taskDueDate" class="block text-sm font-medium text-gray-700 mb-1">Fecha de Vencimiento</label><input type="date" id="taskDueDate" name="due_date" class="w-full border-gray-300 rounded-lg"></div>
                            <div><label for="taskPriority" class="block text-sm font-medium text-gray-700 mb-1">Prioridad</label><select id="taskPriority" name="priority" class="w-full border-gray-300 rounded-lg"><option value="Baja">Baja</option><option value="Media">Media</option><option value="Alta">Alta</option></select></div>
                            <div><label for="taskColor" class="block text-sm font-medium text-gray-700 mb-1">Color de Tarea</label><input type="color" id="taskColor" name="color" value="#FFFFFF" class="w-full h-10 border-gray-300 rounded-lg"></div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Etiquetas</label>
                                <div id="taskTags" class="flex flex-wrap gap-2 mb-2"></div>
                                <select id="tagSelector" class="w-full border-gray-300 rounded-lg"><option value="">Añadir etiqueta...</option></select>
                            </div>
                            <div class="text-xs text-gray-500 border-t pt-4">
                                <p>Creada: <span id="createdAtDate"></span></p>
                                <p>Actualizada: <span id="updatedAtDate"></span></p>
                            </div>
                            <div id="activity-log-container" class="border-t pt-4">
                                <h4 class="font-semibold text-sm mb-2">Historial de Actividad</h4>
                                <div id="activityLog" class="space-y-2 text-xs text-gray-600 max-h-48 overflow-y-auto"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="absolute bottom-0 left-0 right-0 flex justify-end gap-3 p-4 bg-gray-50 border-t"><button type="button" id="deleteTaskBtn" class="bg-red-600 text-white font-semibold px-4 py-2 rounded-lg">Eliminar</button><button type="submit" id="saveTaskBtn" class="bg-blue-600 text-white font-semibold px-4 py-2 rounded-lg">Guardar Cambios</button></div>
            </form>
            <form id="attachmentForm" class="hidden"><input type="file" id="attachmentFile" name="attachmentFile"/></form>
        </div>
    </div>
    <div id="columnModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md">
            <form id="columnForm">
                <div class="flex justify-between items-center mb-4"><h2 id="columnModalTitle" class="text-2xl font-bold"></h2><button type="button" id="closeColumnModal" class="text-gray-500 hover:text-gray-800 text-2xl">&times;</button></div>
                <input type="hidden" id="columnId" name="id">
                <div class="mb-4"><label for="columnTitle" class="block text-sm font-medium text-gray-700 mb-1">Título</label><input type="text" id="columnTitle" name="title" class="w-full border-gray-300 rounded-lg" required></div>
                <div class="mb-4"><label for="columnColor" class="block text-sm font-medium text-gray-700 mb-1">Color de cabecera</label><input type="color" id="columnColor" name="color" value="#E0E0E0" class="w-full h-10 border-gray-300 rounded-lg"></div>
                <div class="mb-4"><label for="wipLimit" class="block text-sm font-medium text-gray-700 mb-1">Límite de Tareas (WIP)</label><input type="number" id="wipLimit" name="wip_limit" min="0" placeholder="0 = sin límite" class="w-full border-gray-300 rounded-lg"></div>
                <div class="flex justify-end gap-3 mt-6"><button type="button" id="deleteColumnBtn" class="bg-red-600 text-white font-semibold px-4 py-2 rounded-lg">Eliminar</button><button type="submit" class="bg-blue-600 text-white font-semibold px-4 py-2 rounded-lg">Guardar</button></div>
            </form>
        </div>
    </div>
    
<script>
// El JavaScript no cambia, es idéntico al de la versión anterior
document.addEventListener('DOMContentLoaded', () => {
    let boardData = { columns: [], users: [], tags: [] };
    let currentUser = null;
    let currentTask = null;
    let sortableInstances = [];
    const appContainer = document.getElementById('appContainer');
    const authContainer = document.getElementById('authContainer');
    const authForm = document.getElementById('authForm');
    const kanbanBoard = document.getElementById('kanbanBoard');
    const taskModal = document.getElementById('taskModal');
    const columnModal = document.getElementById('columnModal');
    const searchInput = document.getElementById('searchInput');
    let isLoginMode = true;

    function showApp() {
        authContainer.classList.add('hidden');
        appContainer.classList.remove('hidden');
        document.getElementById('userInfo').innerHTML = `Usuario: <b class="text-indigo-600">${currentUser.name}</b>`;
        initializeBoard();
    }
    
    function showLogin() {
        appContainer.classList.add('hidden');
        authContainer.classList.remove('hidden');
        currentUser = null;
        localStorage.removeItem('kanban_user');
    }
    
    document.getElementById('toggleAuthMode').addEventListener('click', (e) => {
        e.preventDefault();
        isLoginMode = !isLoginMode;
        document.getElementById('authTitle').textContent = isLoginMode ? 'Iniciar sesión' : 'Crear una cuenta';
        document.getElementById('submitAuthBtn').textContent = isLoginMode ? 'Entrar' : 'Registrar';
        document.getElementById('toggleAuthMode').innerHTML = isLoginMode ? '¿No tienes cuenta? Regístrate' : '¿Ya tienes cuenta? Inicia sesión';
        document.getElementById('authMessage').textContent = '';
    });

    authForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(authForm);
        const data = Object.fromEntries(formData.entries());
        const action = isLoginMode ? 'login' : 'register_user';
        try {
            const responseData = await apiCall(action, 'POST', data); 
            if (isLoginMode) {
                if (responseData && responseData.status === 'success') {
                    currentUser = responseData.user;
                    localStorage.setItem('kanban_user', JSON.stringify(currentUser));
                    showApp();
                }
            } else {
                 if (responseData && responseData.status === 'success') {
                    document.getElementById('authMessage').className = 'text-sm text-green-600';
                    document.getElementById('authMessage').textContent = '¡Registro exitoso! Por favor, inicia sesión.';
                    document.getElementById('toggleAuthMode').click();
                }
            }
        } catch (error) {
            document.getElementById('authMessage').className = 'text-sm text-red-600';
            document.getElementById('authMessage').textContent = error.message;
        }
    });

    document.getElementById('logoutBtn').addEventListener('click', async () => {
        await apiCall('logout', 'POST');
        showLogin();
    });

    async function apiCall(action, method = 'POST', body = null) {
        try {
            const options = { method, body: body ? JSON.stringify(body) : null };
            if (method !== 'GET' && body) { options.headers = { 'Content-Type': 'application/json' }; }
            const response = await fetch(`api.php?action=${action}`, options);
            const responseData = await response.json();
            if (!response.ok) { throw new Error(responseData.message || `Error del servidor (HTTP ${response.status})`); }
            if(responseData.status === 'error') { throw new Error(responseData.message); }
            return responseData;
        } catch (error) {
            console.error('API Call Error:', action, error);
            if (error.message.includes('Debes iniciar sesión')) { showLogin(); }
            throw error; 
        }
    }

    function checkLoginStatus() {
        const storedUser = localStorage.getItem('kanban_user');
        if (storedUser) {
            currentUser = JSON.parse(storedUser);
            apiCall('get_board_data', 'GET').then(() => { showApp(); }).catch(() => { showLogin(); });
        } else { showLogin(); }
    }
    
    async function initializeBoard() {
        try {
            const response = await apiCall('get_board_data', 'GET');
            if (response) {
                boardData = response.data;
                renderBoard();
            }
        } catch(error) { console.error(error); }
    }
    async function fetchBoardData() { return initializeBoard(); }
    
    function renderBoard() {
        kanbanBoard.innerHTML = '';
        sortableInstances.forEach(sortable => sortable.destroy());
        sortableInstances = [];
        if (!boardData.columns || boardData.columns.length === 0) {
            kanbanBoard.innerHTML = '<p class="text-center text-gray-500 w-full mt-10">El tablero está vacío. ¡Añade una nueva columna para empezar!</p>';
            return;
        }
        Sortable.create(kanbanBoard, {
            animation: 150,
            handle: '.column-header',
            ghostClass: 'sortable-ghost',
            onEnd: handleColumnMove,
        });
        boardData.columns.forEach(column => {
            const wipLimit = column.wip_limit || 0;
            const taskCount = column.tasks.length;
            const wipExceeded = wipLimit > 0 && taskCount > wipLimit;
            const columnEl = document.createElement('div');
            columnEl.className = 'kanban-column';
            columnEl.dataset.columnId = column.id;
            columnEl.innerHTML = `
                <div class="column-header ${wipExceeded ? 'wip-exceeded' : ''}" style="background-color: ${column.color};">
                    <span class="column-title-text">${column.title}</span>
                    <div class="flex items-center gap-2">
                         <span class="text-sm font-normal bg-black bg-opacity-10 rounded-full px-2 py-0.5">${taskCount}${wipLimit > 0 ? '/' + wipLimit : ''}</span>
                        <button type="button" class="edit-column-btn text-gray-600 hover:text-black p-1"><i class="ph-pencil-simple"></i></button>
                    </div>
                </div>
                <div class="tasks-container" data-column-id="${column.id}">${column.tasks.map(renderTask).join('')}</div>
                <button type="button" class="add-task-btn p-2 m-2 text-gray-500 hover:text-blue-600 hover:bg-blue-100 rounded-md transition-colors flex items-center justify-center gap-2"><i class="ph-plus"></i> Añadir tarea</button>`;
            kanbanBoard.appendChild(columnEl);
            const tasksContainer = columnEl.querySelector('.tasks-container');
            sortableInstances.push(Sortable.create(tasksContainer, { group: 'tasks', animation: 150, ghostClass: 'sortable-ghost', onEnd: handleTaskMove }));
        });
    }

    function renderTask(task) {
        const completedSubtasks = task.subtasks.filter(st => st.is_completed == 1).length;
        const totalSubtasks = task.subtasks.length;
        const isOverdue = task.due_date && new Date(task.due_date) < new Date().setHours(0, 0, 0, 0);
        return `<div class="kanban-task" data-task-id="${task.id}" style="border-left: 5px solid ${task.color};"><div class="flex flex-wrap gap-1 mb-2">${task.tags.map(tag => `<span class="tag text-white" style="background-color:${tag.color}">${tag.name}</span>`).join('')}</div><p class="font-semibold mb-2">${task.title}</p><div class="flex justify-between items-center text-sm text-gray-600"><div class="flex items-center gap-2 flex-wrap">${task.due_date ? `<span class="flex items-center gap-1 ${isOverdue ? 'text-red-600 font-semibold' : ''}"><i class="ph-calendar"></i> ${new Date(task.due_date).toLocaleDateString()}</span>` : ''}${totalSubtasks > 0 ? `<span class="flex items-center gap-1 ${completedSubtasks === totalSubtasks ? 'text-green-600' : ''}"><i class="ph-check-square-offset"></i> ${completedSubtasks}/${totalSubtasks}</span>` : ''}${task.attachments.length > 0 ? `<span class="flex items-center gap-1"><i class="ph-paperclip"></i> ${task.attachments.length}</span>` : ''}${task.comments.length > 0 ? `<span class="flex items-center gap-1"><i class="ph-chats"></i> ${task.comments.length}</span>` : ''}</div>${task.user_name ? `<span class="bg-gray-200 rounded-full px-2 py-0.5 text-xs whitespace-nowrap">${task.user_name}</span>` : ''}</div></div>`;
    }
    
    function openTaskModal(task = null, columnId = null) {
        currentTask = task;
        document.getElementById('taskForm').reset();
        const userSelect = document.getElementById('taskUser');
        userSelect.innerHTML = '<option value="">Sin asignar</option>' + boardData.users.map(u => `<option value="${u.id}">${u.name}</option>`).join('');
        const tagSelect = document.getElementById('tagSelector');
        tagSelect.innerHTML = '<option value="">Añadir etiqueta...</option>' + boardData.tags.map(t => `<option value="${t.id}">${t.name}</option>`).join('');
        if (task) {
            document.getElementById('taskModalTitle').textContent = 'Editar Tarea';
            document.getElementById('taskId').value = task.id;
            document.getElementById('taskColumnId').value = task.column_id;
            document.getElementById('taskTitle').value = task.title;
            document.getElementById('taskDescription').value = task.description || '';
            userSelect.value = task.user_id || '';
            document.getElementById('taskDueDate').value = task.due_date || '';
            document.getElementById('taskPriority').value = task.priority;
            document.getElementById('taskColor').value = task.color || '#FFFFFF';
            document.getElementById('deleteTaskBtn').style.display = 'inline-flex';
            renderSubtasks(task.subtasks); renderAttachments(task.attachments); renderComments(task.comments); renderTaskTags(task.tags); renderActivityLog(task.activity_log);
            document.getElementById('createdAtDate').textContent = new Date(task.created_at).toLocaleString();
            document.getElementById('updatedAtDate').textContent = new Date(task.updated_at).toLocaleString();
        } else {
            document.getElementById('taskModalTitle').textContent = 'Nueva Tarea';
            document.getElementById('taskId').value = '';
            document.getElementById('taskColumnId').value = columnId;
            document.getElementById('deleteTaskBtn').style.display = 'none';
            renderSubtasks([]); renderAttachments([]); renderComments([]); renderTaskTags([]); renderActivityLog([]);
            document.getElementById('createdAtDate').textContent = 'N/A';
            document.getElementById('updatedAtDate').textContent = 'N/A';
        }
        taskModal.classList.remove('hidden');
        taskModal.classList.add('flex');
        switchTab('subtasks');
    }

    function closeTaskModal() { taskModal.classList.add('hidden'); taskModal.classList.remove('flex'); currentTask = null; }
    function openColumnModal(column = null) {
        document.getElementById('columnForm').reset();
        if (column) {
            document.getElementById('columnModalTitle').textContent = 'Editar Columna';
            document.getElementById('columnId').value = column.id;
            document.getElementById('columnTitle').value = column.title;
            document.getElementById('columnColor').value = column.color;
            document.getElementById('wipLimit').value = column.wip_limit || 0;
            document.getElementById('deleteColumnBtn').style.display = 'inline-flex';
        } else {
            document.getElementById('columnModalTitle').textContent = 'Nueva Columna';
            document.getElementById('columnId').value = '';
            document.getElementById('deleteColumnBtn').style.display = 'none';
        }
        columnModal.classList.remove('hidden');
        columnModal.classList.add('flex');
    }
    function closeColumnModal() { columnModal.classList.add('hidden'); columnModal.classList.remove('flex'); }

    function switchTab(tabName) {
        document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.add('hidden'));
        document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
        document.getElementById(`${tabName}-tab`).classList.remove('hidden');
        document.querySelector(`[data-tab="${tabName}"]`).classList.add('active');
    }
    
    function renderSubtasks(subtasks) { document.getElementById('subtaskList').innerHTML = subtasks.map(s => `<div class="flex items-center justify-between bg-gray-100 p-2 rounded" data-subtask-id="${s.id}"><div class="flex items-center gap-2"><input type="checkbox" class="subtask-checkbox rounded" ${s.is_completed == 1 ? 'checked' : ''}><span class="subtask-title ${s.is_completed == 1 ? 'line-through text-gray-500' : ''}">${s.title}</span></div><button type="button" class="delete-subtask-btn text-red-500 hover:text-red-700 text-lg">&times;</button></div>`).join('') || '<p class="text-sm text-gray-500">No hay subtareas.</p>'; }
    function renderAttachments(attachments) {
        const attachmentList = document.getElementById('attachmentList');
        attachmentList.innerHTML = attachments.map(a => `<div class="flex items-center justify-between bg-gray-100 p-2 rounded" data-attachment-id="${a.id}"><a href="${a.file_path}" target="_blank" class="flex items-center gap-2 text-blue-600 hover:underline"><i class="ph-file"></i> ${a.file_name}</a><button type="button" class="delete-attachment-btn text-red-500 hover:text-red-700 text-lg">&times;</button></div>`).join('') || '<p class="text-sm text-gray-500">No hay archivos adjuntos.</p>';
        const uploadButton = document.createElement('button');
        uploadButton.type = 'button';
        uploadButton.id = 'uploadAttachmentBtn';
        uploadButton.className = 'mt-4 w-full text-sm p-2 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100';
        uploadButton.textContent = 'Seleccionar o arrastrar un archivo';
        attachmentList.parentElement.querySelector('.mt-4').innerHTML = '';
        attachmentList.parentElement.querySelector('.mt-4').appendChild(uploadButton);
    }
    function renderComments(comments) { document.getElementById('commentList').innerHTML = comments.map(c => `<div class="flex items-start gap-3"><div class="w-8 h-8 rounded-full bg-indigo-200 text-indigo-700 flex items-center justify-center font-bold text-sm">${c.user_name ? c.user_name.charAt(0).toUpperCase() : 'S'}</div><div class="flex-1"><p class="font-semibold text-sm">${c.user_name || 'Sistema'}<span class="text-gray-500 font-normal ml-2 text-xs">${new Date(c.created_at).toLocaleString()}</span></p><p class="text-gray-700">${c.comment}</p></div></div>`).join('') || '<p class="text-sm text-gray-500">No hay comentarios.</p>'; }
    function renderTaskTags(tags) { document.getElementById('taskTags').innerHTML = tags.map(tag => `<span class="tag text-white flex items-center gap-1" style="background-color:${tag.color}" data-tag-id="${tag.id}">${tag.name} <button type="button" class="remove-tag-btn text-xs font-bold leading-none">&times;</button></span>`).join(''); }
    function renderActivityLog(log) { document.getElementById('activityLog').innerHTML = log.map(item => `<div class="flex items-start gap-2"><i class="ph-info mt-1"></i><div><p><b>${item.user_name || 'Alguien'}</b> ${item.activity}</p><p class="text-gray-400">${new Date(item.activity_date).toLocaleString()}</p></div></div>`).join('') || '<p class="text-sm text-gray-500">No hay actividad registrada.</p>';}

    async function handleTaskMove(event) {
        const taskId = event.item.dataset.taskId;
        const newColumnId = event.to.dataset.columnId;
        const oldColumnId = event.from.dataset.columnId;
        const newIndex = event.newIndex;
        const oldIndex = event.oldIndex;
        const task = findTask(taskId);
        findColumn(oldColumnId).tasks.splice(oldIndex, 1);
        findColumn(newColumnId).tasks.splice(newIndex, 0, task);
        await apiCall('move_task', 'POST', { taskId: Number(taskId), newColumnId: Number(newColumnId), oldColumnId: Number(oldColumnId), newIndex, oldIndex });
        await fetchBoardData();
    }

    async function handleColumnMove(event) {
        const { oldIndex, newIndex } = event;
        const [movedColumn] = boardData.columns.splice(oldIndex, 1);
        boardData.columns.splice(newIndex, 0, movedColumn);
        const columnOrder = boardData.columns.map(col => col.id);
        try {
            await apiCall('update_column_order', 'POST', { order: columnOrder });
        } catch (error) {
            await fetchBoardData();
        }
    }

    async function handleSaveTask(e) {
        e.preventDefault();
        const formData = new FormData(e.target);
        const taskData = Object.fromEntries(formData.entries());
        const action = taskData.id ? 'update_task' : 'add_task';
        const response = await apiCall(action, 'POST', taskData);
        if (response) { closeTaskModal(); await fetchBoardData(); }
    }

    document.getElementById('addColumnBtn').addEventListener('click', () => openColumnModal());
    searchInput.addEventListener('input', e => {
        const searchTerm = e.target.value.toLowerCase();
        document.querySelectorAll('.kanban-task').forEach(taskEl => {
            const title = taskEl.querySelector('p').textContent.toLowerCase();
            taskEl.style.display = title.includes(searchTerm) ? '' : 'none';
        });
    });
    kanbanBoard.addEventListener('click', (e) => {
        if (e.target.closest('.add-task-btn')) { openTaskModal(null, e.target.closest('.kanban-column').dataset.columnId); return; }
        if (e.target.closest('.edit-column-btn')) { openColumnModal(findColumn(e.target.closest('.kanban-column').dataset.columnId)); return; }
        if (e.target.closest('.kanban-task')) { openTaskModal(findTask(e.target.closest('.kanban-task').dataset.taskId)); }
    });
    document.getElementById('columnForm').addEventListener('submit', async e => {
        e.preventDefault();
        const columnData = Object.fromEntries(new FormData(e.target).entries());
        const action = columnData.id ? 'update_column' : 'add_column';
        if (await apiCall(action, 'POST', columnData)) { closeColumnModal(); await fetchBoardData(); }
    });
    document.getElementById('closeColumnModal').addEventListener('click', closeColumnModal);
    document.getElementById('deleteColumnBtn').addEventListener('click', async () => {
        if (confirm('¿Estás seguro? Eliminar una columna también eliminará todas sus tareas.')) {
            const columnId = document.getElementById('columnId').value;
            if (await apiCall('delete_column', 'POST', { id: columnId })) { closeColumnModal(); await fetchBoardData(); }
        }
    });
    document.getElementById('taskForm').addEventListener('submit', handleSaveTask);
    document.getElementById('closeTaskModal').addEventListener('click', closeTaskModal);
    document.getElementById('deleteTaskBtn').addEventListener('click', async () => {
        if (confirm('¿Estás seguro de que quieres eliminar esta tarea?')) {
            const taskId = document.getElementById('taskId').value;
            if (await apiCall('delete_task', 'POST', { id: taskId })) { closeTaskModal(); await fetchBoardData(); }
        }
    });
    document.querySelectorAll('.tab-button').forEach(btn => btn.addEventListener('click', () => switchTab(btn.dataset.tab)));
    document.getElementById('addSubtaskBtn').addEventListener('click', async () => {
        const titleInput = document.getElementById('newSubtaskTitle');
        const title = titleInput.value.trim();
        if (title && currentTask && await apiCall('add_subtask', 'POST', { task_id: currentTask.id, title })) {
            titleInput.value = '';
            await fetchBoardData(); openTaskModal(findTask(currentTask.id));
        }
    });
    document.getElementById('subtaskList').addEventListener('click', async e => {
        const subtaskEl = e.target.closest('[data-subtask-id]');
        if (!subtaskEl) return;
        const subtaskId = subtaskEl.dataset.subtaskId;
        const subtask = currentTask.subtasks.find(s => s.id == subtaskId);
        if (e.target.matches('.delete-subtask-btn')) {
            if (await apiCall('delete_subtask', 'POST', { id: subtaskId })) { await fetchBoardData(); openTaskModal(findTask(currentTask.id)); }
        } else if (e.target.matches('.subtask-checkbox')) {
            subtask.is_completed = e.target.checked ? 1 : 0;
            await apiCall('update_subtask', 'POST', { id: subtask.id, title: subtask.title, is_completed: subtask.is_completed });
            renderSubtasks(currentTask.subtasks);
            await fetchBoardData();
        }
    });
    document.getElementById('attachments-tab').addEventListener('click', e => {
        if(e.target.id === 'uploadAttachmentBtn') { document.getElementById('attachmentFile').click(); }
    });
    document.getElementById('attachmentFile').addEventListener('change', async () => {
        const fileInput = document.getElementById('attachmentFile');
        if (fileInput.files.length === 0) return;
        const formData = new FormData();
        formData.append('action', 'upload_attachment');
        formData.append('task_id', currentTask.id);
        const res = await fetch('api.php', { method: 'POST', body: formData });
        const resData = await res.json();
        document.getElementById('attachmentForm').reset();
        if (resData.status === 'success') {
            await fetchBoardData(); 
            openTaskModal(findTask(currentTask.id));
        } else { alert('Error al subir archivo: ' + resData.message); }
    });
    document.getElementById('attachmentList').addEventListener('click', async e => {
        const attEl = e.target.closest('[data-attachment-id]');
        if (attEl && e.target.matches('.delete-attachment-btn')) {
            if (confirm('¿Eliminar este archivo adjunto?') && await apiCall('delete_attachment', 'POST', {id: attEl.dataset.attachmentId})) {
                await fetchBoardData(); openTaskModal(findTask(currentTask.id));
            }
        }
    });
    document.getElementById('addCommentBtn').addEventListener('click', async () => {
        const textInput = document.getElementById('newCommentText');
        const comment = textInput.value.trim();
        if (comment && currentTask && await apiCall('add_comment', 'POST', { task_id: currentTask.id, comment })) {
            textInput.value = '';
            await fetchBoardData(); openTaskModal(findTask(currentTask.id));
        }
    });
    document.getElementById('tagSelector').addEventListener('change', async e => {
        const tagId = e.target.value;
        if (tagId && currentTask) {
            const currentTagIds = currentTask.tags.map(t => t.id);
            if (!currentTagIds.includes(Number(tagId))) {
                const newTagIds = [...currentTagIds, Number(tagId)];
                if (await apiCall('update_task_tags', 'POST', { task_id: currentTask.id, tag_ids: newTagIds })) {
                    e.target.value = ''; await fetchBoardData(); openTaskModal(findTask(currentTask.id));
                }
            }
        }
    });
    document.getElementById('taskTags').addEventListener('click', async e => {
        const tagEl = e.target.closest('[data-tag-id]');
        if (tagEl && e.target.matches('.remove-tag-btn')) {
            const tagIdToRemove = tagEl.dataset.tagId;
            const newTagIds = currentTask.tags.map(t => t.id).filter(id => id != tagIdToRemove);
            if (await apiCall('update_task_tags', 'POST', { task_id: currentTask.id, tag_ids: newTagIds })) {
                await fetchBoardData(); openTaskModal(findTask(currentTask.id));
            }
        }
    });
    
    function findTask(taskId) { for (const col of boardData.columns) { const task = col.tasks.find(t => t.id == taskId); if (task) return task; } return null; }
    function findColumn(columnId) { return boardData.columns.find(c => c.id == columnId); }
    
    checkLoginStatus();
});
</script>

</body>
</html>