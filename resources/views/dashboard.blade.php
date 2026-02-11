<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <!-- Progress Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl mb-6 p-6">
                <div class="flex justify-between items-end mb-2">
                    <div>
                        <h3 class="text-3xl font-bold text-gray-900">{{ $completionPercentage }}%</h3>
                        <p class="text-gray-500 text-sm">Daily Goal Progress</p>
                    </div>
                    <div class="text-sm text-gray-400">{{ now()->format('l, M j') }}</div>
                </div>
                <!-- Progress Bar -->
                <div class="w-full bg-gray-100 rounded-full h-2.5 overflow-hidden">
                    <div class="bg-indigo-600 h-2.5 rounded-full transition-all duration-500 ease-out" style="width: {{ $completionPercentage }}%"></div>
                </div>
            </div>

            <!-- Tasks List -->
            <div class="space-y-4">
                <div class="flex justify-between items-center px-2">
                    <h2 class="text-lg font-semibold text-gray-800">Today's Tasks</h2>
                    <button 
                        onclick="document.dispatchEvent(new CustomEvent('open-modal', { detail: 'create-task-modal' }))"
                        class="text-indigo-600 hover:text-indigo-800 text-sm font-medium flex items-center transition-colors"
                    >
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        New Task
                    </button>
                    <!-- Trigger Categories Modal -->
                     <button 
                        onclick="document.dispatchEvent(new CustomEvent('open-modal', { detail: 'create-category-modal' }))"
                        class="text-gray-500 hover:text-gray-700 text-sm font-medium flex items-center transition-colors ml-4"
                    >
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                        Categories
                    </button>
                </div>

                @if($tasks->isEmpty())
                    <div class="text-center py-12 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No tasks today</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by creating a new task.</p>
                        <div class="mt-6">
                            <button 
                                onclick="document.dispatchEvent(new CustomEvent('open-modal', { detail: 'create-task-modal' }))"
                                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                New Task
                            </button>
                        </div>
                    </div>
                @else
                    @foreach($tasks as $task)
                        <x-task-row :task="$task" :today="$today" />
                    @endforeach
                @endif
            </div>

            <div class="mt-8 text-center text-sm text-gray-400">
                <a href="{{ route('history') }}" class="hover:text-gray-600 underline">View Monthly History</a>
            </div>
        </div>
    </div>


    <!-- Create Task Modal -->
    <x-plain-modal name="create-task-modal" :show="$errors->taskCreation->isNotEmpty()">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">
                Create New Task
            </h2>

            <form method="POST" action="{{ route('tasks.store') }}">
                @csrf
                <div class="mb-4">
                    <x-input-label for="create_title" :value="__('Title')" />
                    <x-text-input id="create_title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                    <x-input-error :messages="$errors->taskCreation->get('title')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <x-input-label for="create_category_id" :value="__('Category')" />
                    <select id="create_category_id" name="category_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <x-input-label for="create_notification_time" :value="__('Notification Time (Optional)')" />
                    <x-text-input id="create_notification_time" class="block mt-1 w-full" type="time" name="notification_time" :value="old('notification_time')" />
                </div>

                <div class="mb-4">
                    <x-input-label for="create_recurring_days" :value="__('Recur on Days (Optional, select none for daily)')" />
                    <div class="grid grid-cols-4 gap-2 mt-2">
                        @foreach(['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'] as $day)
                            <label class="flex items-center space-x-2 text-sm text-gray-600">
                                <input type="checkbox" name="recurring_days[]" value="{{ $day }}" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ in_array($day, old('recurring_days', [])) ? 'checked' : '' }}>
                                <span class="capitalize">{{ $day }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <x-secondary-button onclick="closeModal('create-task-modal')" type="button">
                        {{ __('Cancel') }}
                    </x-secondary-button>

                    <x-primary-button class="ml-3">
                        {{ __('Create Task') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </x-plain-modal>

    <!-- Create Category Modal -->
    <x-plain-modal name="create-category-modal" :show="$errors->categoryCreation->isNotEmpty()">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">
                Manage Categories
            </h2>

            <ul class="mb-6 space-y-2 max-h-48 overflow-y-auto">
                @foreach($categories as $category)
                    <li class="flex justify-between items-center bg-gray-50 px-3 py-2 rounded-lg">
                        <div class="flex items-center space-x-2">
                            <span class="w-3 h-3 rounded-full" style="background-color: {{ $category->color }}"></span>
                            <span class="text-gray-700">{{ $category->name }}</span>
                        </div>
                        <form method="POST" action="{{ route('categories.destroy', $category) }}" onsubmit="return confirm('Delete category?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-gray-400 hover:text-red-500">&times;</button>
                        </form>
                    </li>
                @endforeach
            </ul>

            <h3 class="font-medium text-gray-800 mb-2">Add New</h3>
            <form method="POST" action="{{ route('categories.store') }}">
                @csrf
                <div class="flex space-x-2 mb-4">
                    <div class="flex-1">
                        <x-text-input placeholder="Name" class="w-full" type="text" name="name" required />
                    </div>
                    <div>
                        <input type="color" name="color" class="h-10 w-10 p-1 rounded-md border border-gray-300 cursor-pointer" value="#6366f1" required />
                    </div>
                </div>
                
                <div class="flex justify-end">
                    <x-secondary-button onclick="closeModal('create-category-modal')" type="button">
                        {{ __('Close') }}
                    </x-secondary-button>
                     <x-primary-button class="ml-3">
                        {{ __('Add Category') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </x-plain-modal>

    <!-- Edit Task Modal -->
    <x-plain-modal name="edit-task-modal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">
                Edit Task
            </h2>

            <form method="POST" id="edit-task-form" action="">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <x-input-label for="edit_title" :value="__('Title')" />
                    <x-text-input id="edit_title" class="block mt-1 w-full" type="text" name="title" required />
                </div>

                <div class="mb-4">
                    <x-input-label for="edit_category_id" :value="__('Category')" />
                    <select id="edit_category_id" name="category_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <x-input-label for="edit_notification_time" :value="__('Notification Time (Optional)')" />
                    <x-text-input id="edit_notification_time" class="block mt-1 w-full" type="time" name="notification_time" />
                </div>

                <div class="mb-4">
                    <x-input-label for="edit_recurring_days" :value="__('Recur on Days (Optional)')" />
                    <div class="grid grid-cols-4 gap-2 mt-2">
                        @foreach(['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'] as $day)
                            <label class="flex items-center space-x-2 text-sm text-gray-600">
                                <input type="checkbox" name="recurring_days[]" value="{{ $day }}" class="edit-recurring-day rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                <span class="capitalize">{{ $day }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <x-secondary-button onclick="closeModal('edit-task-modal')" type="button">
                        {{ __('Cancel') }}
                    </x-secondary-button>

                    <x-primary-button class="ml-3">
                        {{ __('Update Task') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </x-plain-modal>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Modal Logic
            window.openModal = function(name) {
                const modal = document.getElementById(name);
                if(modal) modal.classList.remove('hidden');
            }

            window.closeModal = function(name) {
                const modal = document.getElementById(name);
                if(modal) modal.classList.add('hidden');
            }

            document.addEventListener('open-modal', function(e) {
                openModal(e.detail);
            });

            // Edit Task Logic
            document.body.addEventListener('click', function(e) {
                const btn = e.target.closest('.edit-task-btn');
                if (btn) {
                    const taskId = btn.dataset.taskId;
                    const title = btn.dataset.title;
                    const categoryId = btn.dataset.category;
                    const time = btn.dataset.time;
                    const days = JSON.parse(btn.dataset.days || '[]');

                    // Populate form
                    const form = document.getElementById('edit-task-form');
                    form.action = `/tasks/${taskId}`;
                    
                    document.getElementById('edit_title').value = title;
                    document.getElementById('edit_category_id').value = categoryId;
                    document.getElementById('edit_notification_time').value = time;

                    // Reset checkboxes
                    document.querySelectorAll('.edit-recurring-day').forEach(cb => {
                        cb.checked = days && days.includes(cb.value);
                    });

                    openModal('edit-task-modal');
                }
            });

            // Task Toggle Logic
            const csrfTokenElement = document.querySelector('meta[name="csrf-token"]');
            const csrfToken = csrfTokenElement ? csrfTokenElement.getAttribute('content') : '';

            document.body.addEventListener('click', function(e) {
                if (e.target.classList.contains('toggle-status-btn')) {
                    const btn = e.target;
                    const url = btn.dataset.url;
                    
                    // Optimistic update
                    let currentStatus = btn.dataset.status;
                    let nextStatus;
                    
                    // blank -> complete -> incomplete -> exempt -> blank
                    if (currentStatus === 'blank') nextStatus = 'complete';
                    else if (currentStatus === 'complete') nextStatus = 'incomplete';
                    else if (currentStatus === 'incomplete') nextStatus = 'exempt';
                    else nextStatus = 'blank';
                    
                    updateStatusUI(btn, nextStatus);

                    fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({})
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status !== nextStatus) {
                            updateStatusUI(btn, data.status);
                        }
                        location.reload(); 
                    });
                }
            });

            function updateStatusUI(btn, status) {
                btn.dataset.status = status;
                // Remove all possible classes
                btn.className = 'w-6 h-6 rounded-full border-2 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 toggle-status-btn flex-shrink-0';
                
                const classes = {
                    'complete': 'bg-emerald-500 border-emerald-500',
                    'incomplete': 'bg-rose-500 border-rose-500',
                    'exempt': 'bg-gray-300 border-gray-300',
                    'blank': 'bg-transparent border-gray-300 hover:border-indigo-400'
                };
                
                const newClasses = classes[status] || classes['blank'];
                newClasses.split(' ').forEach(c => btn.classList.add(c));

                const row = btn.closest('.group');
                const title = row.querySelector('h3');
                if (title) {
                    if (status === 'exempt') {
                        title.classList.add('line-through', 'text-gray-400');
                        title.classList.remove('text-gray-900', 'text-gray-500');
                    } else if (status === 'complete') {
                        title.classList.remove('line-through', 'text-gray-400', 'text-gray-900');
                        title.classList.add('text-gray-500');
                    } else {
                        title.classList.remove('line-through', 'text-gray-400', 'text-gray-500');
                        title.classList.add('text-gray-900');
                    }
                }
            }
        });
    </script>
</x-app-layout>
