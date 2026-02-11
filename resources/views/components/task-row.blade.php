@props(['task', 'today'])

@php
    $entry = $task->entries->where('date', $today)->first();
    $status = $entry ? $entry->status : 'blank';
    
    // Status styles logic:
    // blank: white inner, gray border
    // complete: green filled
    // incomplete: red filled
    // exempt: gray filled
    
    $statusClasses = match($status) {
        'complete' => 'bg-emerald-500 border-emerald-500',
        'incomplete' => 'bg-rose-500 border-rose-500',
        'exempt' => 'bg-gray-300 border-gray-300',
        default => 'bg-transparent border-gray-300 hover:border-indigo-400',
    };
@endphp

<div class="flex items-center justify-between p-4 bg-white rounded-2xl shadow-sm hover:shadow-md transition-all duration-200 mb-3 border border-gray-100 group" data-task-id="{{ $task->id }}">
    <div class="flex items-center space-x-4 flex-1">
        <button 
            type="button" 
            class="w-6 h-6 rounded-full border-2 {{ $statusClasses }} transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 toggle-status-btn flex-shrink-0"
            data-status="{{ $status }}"
            data-url="{{ route('tasks.toggle', $task) }}"
            aria-label="Toggle task status"
        ></button>
        
        <div class="flex-1 min-w-0">
            <h3 class="text-gray-900 font-medium truncate {{ $status === 'exempt' ? 'line-through text-gray-400' : '' }} {{ $status === 'complete' ? 'text-gray-500' : '' }}">
                {{ $task->title }}
            </h3>
            
            <div class="flex items-center space-x-3 mt-1.5">
                <span class="flex items-center space-x-1.5 text-xs text-gray-500 bg-gray-50 px-2 py-0.5 rounded-full border border-gray-100">
                    <span class="w-2 h-2 rounded-full" style="background-color: {{ $task->category->color }}"></span>
                    <span class="truncate">{{ $task->category->name }}</span>
                </span>

                @if($task->notification_time)
                    <span class="flex items-center text-xs text-gray-400" title="Notification time">
                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ \Carbon\Carbon::parse($task->notification_time)->format('h:i A') }}
                    </span>
                @endif
                
                @if($task->recurring_days)
                     <span class="flex items-center text-xs text-gray-400" title="Recurring days">
                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                        Recurring
                    </span>
                @endif
            </div>
        </div>
    </div>
    
    <div class="flex items-center space-x-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
        <button 
            type="button"
            class="p-2 text-gray-400 hover:text-indigo-600 rounded-full hover:bg-gray-50 edit-task-btn" 
            data-task-id="{{ $task->id }}"
            data-title="{{ $task->title }}"
            data-category="{{ $task->category_id }}"
            data-time="{{ $task->notification_time ? \Carbon\Carbon::parse($task->notification_time)->format('H:i') : '' }}"
            data-days="{{ json_encode($task->recurring_days) }}"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
        </button>
        
        <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('Delete this task?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="p-2 text-gray-400 hover:text-red-500 rounded-full hover:bg-red-50">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            </button>
        </form>
    </div>
</div>
