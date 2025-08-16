<div class="max-w-2xl mx-auto p-6" x-data="habitForm()">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    @switch($step)
                        @case('type')
                            What would you like to create?
                            @break
                        @case('habit-config')
                            Configure Your Habit
                            @break
                        @case('skill-config')
                            Configure Your Skill
                            @break
                        @case('goal-config')
                            Set Your Goal
                            @break
                    @endswitch
                </h1>
                <p class="text-gray-600 mt-2">
                    @switch($step)
                        @case('type')
                            Choose whether you want to build a habit or learn a skill
                            @break
                        @case('habit-config')
                            Set up the details for your new habit
                            @break
                        @case('skill-config')
                            Set up the details for your new skill
                            @break
                        @case('goal-config')
                            Define how you'll track your progress
                            @break
                    @endswitch
                </p>
            </div>
            <a href="{{ route('habits') }}" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </a>
        </div>
    </div>

    <!-- Progress Steps -->
    <div class="mb-8">
        <div class="flex items-center space-x-4">
            <div class="flex items-center">
                <div class="w-8 h-8 rounded-full {{ $step === 'type' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-600' }} flex items-center justify-center text-sm font-medium">
                    1
                </div>
                <span class="ml-2 text-sm {{ $step === 'type' ? 'text-blue-600 font-medium' : 'text-gray-500' }}">Type</span>
            </div>
            <div class="flex-1 h-px bg-gray-200"></div>
            <div class="flex items-center">
                <div class="w-8 h-8 rounded-full {{ in_array($step, ['habit-config', 'skill-config']) ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-600' }} flex items-center justify-center text-sm font-medium">
                    2
                </div>
                <span class="ml-2 text-sm {{ in_array($step, ['habit-config', 'skill-config']) ? 'text-blue-600 font-medium' : 'text-gray-500' }}">Configure</span>
            </div>
            <div class="flex-1 h-px bg-gray-200"></div>
            <div class="flex items-center">
                <div class="w-8 h-8 rounded-full {{ $step === 'goal-config' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-600' }} flex items-center justify-center text-sm font-medium">
                    3
                </div>
                <span class="ml-2 text-sm {{ $step === 'goal-config' ? 'text-blue-600 font-medium' : 'text-gray-500' }}">Goal</span>
            </div>
        </div>
    </div>

    <!-- Step 1: Type Selection -->
    @if($step === 'type')
        <div class="space-y-4">
            <button
                @click="$wire.selectType('HABIT'); clearError();"
                class="w-full p-6 border-2 border-gray-200 rounded-lg hover:border-blue-300 hover:bg-blue-50 transition-all duration-200 text-left"
            >
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Build a Habit</h3>
                        <p class="text-gray-600">Create a recurring action you want to establish</p>
                    </div>
                </div>
            </button>

            <button
                @click="$wire.selectType('SKILL'); clearError();"
                class="w-full p-6 border-2 border-gray-200 rounded-lg hover:border-purple-300 hover:bg-purple-50 transition-all duration-200 text-left"
            >
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Learn a Skill</h3>
                        <p class="text-gray-600">Create a larger goal with component habits</p>
                    </div>
                </div>
            </button>
        </div>
    @endif

    <!-- Step 2: Configuration -->
    @if(in_array($step, ['habit-config', 'skill-config']))
        <form wire:submit="save" class="space-y-6">
            <!-- Basic Information -->
            <div class="space-y-4">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                    <input
                        type="text"
                        id="title"
                        wire:model="title"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="e.g., {{ $type === 'HABIT' ? 'Morning Meditation' : 'Learn Guitar' }}"
                    >
                    @error('title') 
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description (optional)</label>
                    <textarea
                        id="description"
                        wire:model="description"
                        rows="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Add more details about your {{ strtolower($type) }}..."
                    ></textarea>
                    @error('description') 
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Habit-specific configuration -->
            @if($type === 'HABIT')
                <div class="space-y-4">
                    <div>
                        <label for="frequency" class="block text-sm font-medium text-gray-700 mb-2">Frequency</label>
                        <select
                            id="frequency"
                            wire:model="frequency"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                            <option value="">Select frequency</option>
                            <option value="daily">Daily</option>
                            <option value="weekly">Weekly</option>
                            <option value="monthly">Monthly</option>
                        </select>
                        @error('frequency') 
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    @if($frequency === 'weekly')
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Days of the week</label>
                            <div class="grid grid-cols-7 gap-2">
                                @foreach($this->weekDays as $dayNum => $dayName)
                                    <button
                                        type="button"
                                        @click="$wire.toggleFrequencyDay({{ $dayNum }}); clearError();"
                                        class="p-2 text-xs rounded-lg border transition-colors {{ in_array($dayNum, $frequencyDays) ? 'bg-blue-100 border-blue-300 text-blue-700' : 'bg-gray-50 border-gray-300 text-gray-700 hover:bg-gray-100' }}"
                                    >
                                        {{ substr($dayName, 0, 3) }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($frequency === 'monthly')
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Days of the month</label>
                            <div class="grid grid-cols-7 gap-2">
                                @foreach($this->monthDays as $dayNum => $day)
                                    <button
                                        type="button"
                                        @click="$wire.toggleFrequencyDay({{ $dayNum }}); clearError();"
                                        class="p-2 text-xs rounded-lg border transition-colors {{ in_array($dayNum, $frequencyDays) ? 'bg-blue-100 border-blue-300 text-blue-700' : 'bg-gray-50 border-gray-300 text-gray-700 hover:bg-gray-100' }}"
                                    >
                                        {{ $day }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($this->availableSkills->count() > 0)
                        <div>
                            <label for="parentSkillId" class="block text-sm font-medium text-gray-700 mb-2">Part of a skill (optional)</label>
                            <select
                                id="parentSkillId"
                                wire:model="parentSkillId"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                                <option value="">No parent skill</option>
                                @foreach($this->availableSkills as $skill)
                                    <option value="{{ $skill->id }}">{{ $skill->title }}</option>
                                @endforeach
                            </select>
                            @error('parentSkillId') 
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif
                </div>
            @endif

            <!-- Skill-specific configuration -->
            @if($type === 'SKILL')
                <div>
                    <label for="targetCompletionDate" class="block text-sm font-medium text-gray-700 mb-2">Target completion date (optional)</label>
                    <input
                        type="date"
                        id="targetCompletionDate"
                        wire:model="targetCompletionDate"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                    @error('targetCompletionDate') 
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            @endif

            <!-- Navigation -->
            <div class="flex justify-between pt-6">
                <button
                    type="button"
                    @click="$wire.backToType(); clearError();"
                    class="px-4 py-2 text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 transition-colors"
                >
                    Back
                </button>
                <button
                    type="button"
                    @click="if (validateStep2()) { $wire.selectGoalMetric('checkbox'); clearError(); }"
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                >
                    Continue
                </button>
            </div>
        </form>
    @endif

    <!-- Step 3: Goal Configuration -->
    @if($step === 'goal-config')
        <form wire:submit="save" class="space-y-6">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">How will you track this {{ strtolower($type) }}?</label>
                    <div class="space-y-3">
                        <button
                            type="button"
                            @click="$wire.selectGoalMetric('checkbox'); clearError();"
                            class="w-full p-4 border-2 rounded-lg text-left transition-all duration-200 {{ $goalMetric === 'checkbox' ? 'border-blue-300 bg-blue-50' : 'border-gray-200 hover:border-gray-300' }}"
                        >
                            <div class="flex items-center space-x-3">
                                <div class="w-6 h-6 rounded border-2 flex items-center justify-center {{ $goalMetric === 'checkbox' ? 'bg-blue-600 border-blue-600' : 'border-gray-300' }}">
                                    @if($goalMetric === 'checkbox')
                                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    @endif
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900">Checkbox</div>
                                    <div class="text-sm text-gray-600">Simple yes/no completion</div>
                                </div>
                            </div>
                        </button>

                        <button
                            type="button"
                            @click="$wire.selectGoalMetric('duration'); clearError();"
                            class="w-full p-4 border-2 rounded-lg text-left transition-all duration-200 {{ $goalMetric === 'duration' ? 'border-blue-300 bg-blue-50' : 'border-gray-200 hover:border-gray-300' }}"
                        >
                            <div class="flex items-center space-x-3">
                                <div class="w-6 h-6 rounded border-2 flex items-center justify-center {{ $goalMetric === 'duration' ? 'bg-blue-600 border-blue-600' : 'border-gray-300' }}">
                                    @if($goalMetric === 'duration')
                                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    @endif
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900">Duration</div>
                                    <div class="text-sm text-gray-600">Track time spent (e.g., 30 minutes)</div>
                                </div>
                            </div>
                        </button>

                        <button
                            type="button"
                            @click="$wire.selectGoalMetric('count'); clearError();"
                            class="w-full p-4 border-2 rounded-lg text-left transition-all duration-200 {{ $goalMetric === 'count' ? 'border-blue-300 bg-blue-50' : 'border-gray-200 hover:border-gray-300' }}"
                        >
                            <div class="flex items-center space-x-3">
                                <div class="w-6 h-6 rounded border-2 flex items-center justify-center {{ $goalMetric === 'count' ? 'bg-blue-600 border-blue-600' : 'border-gray-300' }}">
                                    @if($goalMetric === 'count')
                                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    @endif
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900">Count</div>
                                    <div class="text-sm text-gray-600">Track quantity (e.g., 10 push-ups)</div>
                                </div>
                            </div>
                        </button>
                    </div>
                </div>

                @if($goalMetric === 'duration')
                    <div>
                        <label for="targetDurationMinutes" class="block text-sm font-medium text-gray-700 mb-2">Target duration (minutes)</label>
                        <input
                            type="number"
                            id="targetDurationMinutes"
                            wire:model="targetDurationMinutes"
                            min="1"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="30"
                        >
                        @error('targetDurationMinutes') 
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                @endif

                @if($goalMetric === 'count')
                    <div>
                        <label for="targetCount" class="block text-sm font-medium text-gray-700 mb-2">Target count</label>
                        <input
                            type="number"
                            id="targetCount"
                            wire:model="targetCount"
                            min="1"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="10"
                        >
                        @error('targetCount') 
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                @endif
            </div>

            <!-- Navigation -->
            <div class="flex justify-between pt-6">
                <button
                    type="button"
                    @click="$wire.backToConfig(); clearError();"
                    class="px-4 py-2 text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 transition-colors"
                >
                    Back
                </button>
                <button
                    type="submit"
                    @click="if (!validateStep3()) { $event.preventDefault(); } else { clearError(); }"
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                >
                    Create {{ $type === 'HABIT' ? 'Habit' : 'Skill' }}
                </button>
            </div>
        </form>
    @endif
</div>

<script>
function habitForm() {
    return {
        validateStep2() {
            const title = document.getElementById('title')?.value?.trim();
            if (!title) {
                this.showError('Please enter a title');
                return false;
            }
            
            // For habits, check if frequency is selected
            if (window.Livewire.find(document.querySelector('[wire\\:id]').getAttribute('wire:id')).get('type') === 'HABIT') {
                const frequency = document.getElementById('frequency')?.value;
                if (!frequency) {
                    this.showError('Please select a frequency');
                    return false;
                }
            }
            
            return true;
        },
        
        validateStep3() {
            const goalMetric = window.Livewire.find(document.querySelector('[wire\\:id]').getAttribute('wire:id')).get('goalMetric');
            
            if (goalMetric === 'duration') {
                const duration = document.getElementById('targetDurationMinutes')?.value;
                if (!duration || duration < 1) {
                    this.showError('Please enter a valid duration');
                    return false;
                }
            }
            
            if (goalMetric === 'count') {
                const count = document.getElementById('targetCount')?.value;
                if (!count || count < 1) {
                    this.showError('Please enter a valid count');
                    return false;
                }
            }
            
            return true;
        },
        
        showError(message) {
            // Remove existing error
            const existingError = document.getElementById('form-error');
            if (existingError) {
                existingError.remove();
            }
            
            // Create error element
            const errorDiv = document.createElement('div');
            errorDiv.id = 'form-error';
            errorDiv.className = 'fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
            errorDiv.innerHTML = `
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>${message}</span>
                </div>
            `;
            
            document.body.appendChild(errorDiv);
            
            // Auto-remove after 3 seconds
            setTimeout(() => {
                if (errorDiv.parentNode) {
                    errorDiv.remove();
                }
            }, 3000);
        },
        
        clearError() {
            const existingError = document.getElementById('form-error');
            if (existingError) {
                existingError.remove();
            }
        }
    }
}
</script>
