<div class="max-w-4xl mx-auto" x-data="recipeForm()">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Edit Recipe</h1>
                <p class="text-sm text-gray-600 mt-1">Update your recipe details</p>
            </div>
            <a href="{{ route('recipes.show', $recipe) }}" wire:navigate.hover class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </a>
        </div>

        @if (session()->has('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <p class="text-red-800">{{ session('error') }}</p>
            </div>
        @endif

        <!-- General Error Display -->
        <div x-show="errors.general" x-cloak class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
            <p class="text-red-800" x-text="errors.general"></p>
        </div>

        <!-- Save Button - Only shows when there are unsaved changes -->
        <div x-show="dirty" x-cloak class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
            <div class="flex items-center justify-between">
                <p class="text-blue-800">You have unsaved changes</p>
                <button 
                    x-on:click="saveRecipe()"
                    x-bind:disabled="saving"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors disabled:opacity-50"
                >
                    <span x-show="!saving">Save Changes</span>
                    <span x-show="saving">Saving...</span>
                </button>
            </div>
        </div>

        <form x-on:submit.prevent="saveRecipe()" class="space-y-8">
            <!-- Basic Information -->
            <div class="space-y-6">
                <h2 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">Basic Information</h2>
                
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Recipe Title *</label>
                    <input 
                        x-model="form.title"
                        x-on:input="markDirty()"
                        type="text" 
                        id="title"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Enter recipe title"
                    >
                    <div x-show="errors.title" x-text="errors.title" class="text-red-500 text-sm mt-1"></div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea 
                        x-model="form.description"
                        x-on:input="markDirty()"
                        id="description"
                        rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Brief description of the recipe"
                    ></textarea>
                    <div x-show="errors.description" x-text="errors.description" class="text-red-500 text-sm mt-1"></div>
                </div>

                <!-- Category, Difficulty, and Times -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                        <select 
                            x-model="form.category"
                            x-on:change="markDirty()"
                            id="category"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                            @foreach($categories as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        <div x-show="errors.category" x-text="errors.category" class="text-red-500 text-sm mt-1"></div>
                    </div>

                    <div>
                        <label for="difficulty" class="block text-sm font-medium text-gray-700 mb-2">Difficulty *</label>
                        <select 
                            x-model="form.difficulty"
                            x-on:change="markDirty()"
                            id="difficulty"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                            @foreach($difficulties as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        <div x-show="errors.difficulty" x-text="errors.difficulty" class="text-red-500 text-sm mt-1"></div>
                    </div>

                    <div>
                        <label for="prep_time" class="block text-sm font-medium text-gray-700 mb-2">Prep Time (minutes)</label>
                        <input 
                            x-model.number="form.prep_time"
                            x-on:input="markDirty()"
                            type="number" 
                            id="prep_time"
                            min="0"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="15"
                        >
                        <div x-show="errors.prep_time" x-text="errors.prep_time" class="text-red-500 text-sm mt-1"></div>
                    </div>

                    <div>
                        <label for="cook_time" class="block text-sm font-medium text-gray-700 mb-2">Cook Time (minutes)</label>
                        <input 
                            x-model.number="form.cook_time"
                            x-on:input="markDirty()"
                            type="number" 
                            id="cook_time"
                            min="0"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="30"
                        >
                        <div x-show="errors.cook_time" x-text="errors.cook_time" class="text-red-500 text-sm mt-1"></div>
                    </div>
                </div>

                <!-- Servings -->
                <div class="w-full md:w-1/3">
                    <label for="servings" class="block text-sm font-medium text-gray-700 mb-2">Servings</label>
                    <input 
                        x-model.number="form.servings"
                        x-on:input="markDirty()"
                        type="number" 
                        id="servings"
                        min="1"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="4"
                    >
                    <div x-show="errors.servings" x-text="errors.servings" class="text-red-500 text-sm mt-1"></div>
                </div>
            </div>

            <!-- Ingredients Section -->
            <div class="space-y-6">
                <h2 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">Ingredients</h2>
                
                <!-- Add Ingredient Form -->
                <div class="bg-gray-50 rounded-lg p-4 space-y-4">
                    <h3 class="text-md font-medium text-gray-900">Add Ingredient</h3>
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                            <input 
                                x-model="newIngredient.name"
                                type="text" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="e.g., Flour"
                                x-on:keydown.enter.prevent="addIngredient()"
                            >
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                            <input 
                                x-model="newIngredient.quantity"
                                type="text" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="2"
                                x-on:keydown.enter.prevent="addIngredient()"
                            >
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Unit</label>
                            <select 
                                x-model="newIngredient.unit"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                                <option value="">Select unit</option>
                                @foreach($commonUnits as $unit)
                                    <option value="{{ $unit }}">{{ ucfirst($unit) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Group</label>
                            <select 
                                x-model="newIngredient.group"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                                <option value="">Main Ingredients</option>
                                @foreach($commonGroups as $group)
                                    <option value="{{ $group }}">{{ $group }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                            <input 
                                x-model="newIngredient.notes"
                                type="text" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Optional notes"
                                x-on:keydown.enter.prevent="addIngredient()"
                            >
                        </div>
                    </div>
                    <button 
                        type="button"
                        x-on:click="addIngredient()"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                    >
                        Add Ingredient
                    </button>
                </div>

                <!-- Ingredients List -->
                <div x-show="form.ingredients.length > 0" class="space-y-4">
                    <h3 class="text-md font-medium text-gray-900">Ingredients List</h3>
                    
                    <!-- Group ingredients by their group -->
                    <template x-for="(group, groupName) in getGroupedIngredients()" :key="groupName">
                        <div class="space-y-2">
                            <h4 class="text-sm font-medium text-gray-700 border-b border-gray-200 pb-1" x-text="groupName"></h4>
                            <template x-for="(ingredient, index) in group" :key="ingredient.originalIndex">
                                <div class="flex items-center justify-between bg-gray-50 rounded-lg p-3 ml-4">
                                    <div class="flex-1">
                                        <span class="font-medium" x-text="ingredient.name"></span>
                                        <span x-show="ingredient.quantity || ingredient.unit" class="text-gray-600 ml-2">
                                            <span x-text="ingredient.quantity"></span>
                                            <span x-text="ingredient.unit"></span>
                                        </span>
                                        <span x-show="ingredient.notes" class="text-gray-500 text-sm ml-2" x-text="`(${ingredient.notes})`"></span>
                                    </div>
                                    <button 
                                        type="button"
                                        x-on:click="removeIngredient(ingredient.originalIndex)"
                                        class="text-red-600 hover:text-red-800 ml-2"
                                    >
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Instructions Section -->
            <div class="space-y-6">
                <h2 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">Instructions</h2>
                
                <!-- Add Instruction Form -->
                <div class="bg-gray-50 rounded-lg p-4 space-y-4">
                    <h3 class="text-md font-medium text-gray-900">Add Instruction Step</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Instruction *</label>
                            <textarea 
                                x-model="newInstruction.instruction"
                                class="w-full h-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                                placeholder="Describe this step..."
                                style="height: calc(3 * 2.5rem + 2 * 1rem);"
                            ></textarea>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Step Type</label>
                                <select 
                                    x-model="newInstruction.step_type"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                >
                                    @foreach($stepTypes as $key => $label)
                                        <option value="{{ $key }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Time (minutes)</label>
                                <input 
                                    x-model.number="newInstruction.estimated_time"
                                    type="number" 
                                    min="0"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="5"
                                >
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                                <input 
                                    x-model="newInstruction.notes"
                                    type="text" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Optional notes"
                                >
                            </div>
                        </div>
                    </div>
                    <button 
                        type="button"
                        x-on:click="addInstruction()"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                    >
                        Add Step
                    </button>
                </div>

                <!-- Instructions List -->
                <div x-show="form.instructions.length > 0" class="space-y-3">
                    <h3 class="text-md font-medium text-gray-900">Instructions List</h3>
                    <template x-for="(instruction, index) in form.instructions" :key="index">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="bg-blue-100 text-blue-800 text-sm font-medium px-2 py-1 rounded" x-text="`Step ${index + 1}`"></span>
                                        <span x-show="instruction.step_type" class="bg-gray-100 text-gray-800 text-sm px-2 py-1 rounded" x-text="getStepTypeLabel(instruction.step_type)"></span>
                                        <span x-show="instruction.estimated_time" class="bg-green-100 text-green-800 text-sm px-2 py-1 rounded" x-text="`${instruction.estimated_time}m`"></span>
                                    </div>
                                    <p class="text-gray-900" x-text="instruction.instruction"></p>
                                    <p x-show="instruction.notes" class="text-gray-600 text-sm mt-1" x-text="instruction.notes"></p>
                                </div>
                                <div class="flex items-center gap-1 ml-4">
                                    <button 
                                        x-show="index > 0"
                                        type="button"
                                        x-on:click="moveInstructionUp(index)"
                                        class="text-gray-400 hover:text-gray-600"
                                        title="Move up"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                        </svg>
                                    </button>
                                    <button 
                                        x-show="index < form.instructions.length - 1"
                                        type="button"
                                        x-on:click="moveInstructionDown(index)"
                                        class="text-gray-400 hover:text-gray-600"
                                        title="Move down"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <button 
                                        type="button"
                                        x-on:click="removeInstruction(index)"
                                        class="text-red-600 hover:text-red-800"
                                        title="Remove step"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Tags Section -->
            <div class="space-y-6">
                <h2 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">Tags</h2>
                
                <div class="space-y-4">
                    <div class="flex flex-wrap gap-2">
                        <template x-for="(tag, index) in form.tags" :key="index">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-800">
                                <span x-text="tag"></span>
                                <button 
                                    type="button"
                                    x-on:click="removeTag(index)"
                                    class="ml-2 text-blue-600 hover:text-blue-800"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </span>
                        </template>
                    </div>
                    <div class="flex gap-2">
                        <input 
                            x-model="newTag"
                            type="text" 
                            class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Add a tag"
                            x-on:keydown.enter.prevent="addTag()"
                        >
                        <button 
                            type="button"
                            x-on:click="addTag()"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                        >
                            Add
                        </button>
                    </div>
                </div>
            </div>

            <!-- Public/Private Toggle -->
            <div class="flex items-center">
                <input 
                    x-model="form.is_public"
                    x-on:change="markDirty()"
                    type="checkbox" 
                    id="is_public"
                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                >
                <label for="is_public" class="ml-2 block text-sm text-gray-700">
                    Make this recipe public (visible to other users)
                </label>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                <a 
                    href="{{ route('recipes.show', $recipe) }}" wire:navigate.hover
                    class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors"
                >
                    Cancel
                </a>
                <button 
                    type="submit"
                    x-bind:disabled="saving"
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors disabled:opacity-50"
                >
                    <span x-show="!saving">Update Recipe</span>
                    <span x-show="saving">Updating...</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function recipeForm() {
    return {
        dirty: false,
        saving: false,
        errors: {},
        
        // Form data - pre-populated with existing recipe data
        form: {
            title: @json($recipe->title),
            description: @json($recipe->description ?? ''),
            category: @json($recipe->category),
            difficulty: @json($recipe->difficulty),
            prep_time: @json($recipe->prep_time),
            cook_time: @json($recipe->cook_time),
            servings: @json($recipe->servings),
            is_public: @json($recipe->is_public),
            ingredients: @json($form->ingredients),
            instructions: @json($form->instructions),
            tags: @json($form->tags)
        },
        
        // New item forms
        newIngredient: {
            name: '',
            quantity: '',
            unit: '',
            group: '',
            notes: ''
        },
        
        newInstruction: {
            instruction: '',
            step_type: 'prep',
            estimated_time: null,
            notes: ''
        },
        
        newTag: '',
        
        // Step type labels
        stepTypes: @json($stepTypes),
        
        init() {
            // Form is already pre-populated with existing data
        },
        
        markDirty() {
            this.dirty = true;
            this.errors = {};
        },
        
        addIngredient() {
            if (!this.newIngredient.name.trim()) return;
            
            this.form.ingredients.push({
                name: this.newIngredient.name.trim(),
                quantity: this.newIngredient.quantity.trim(),
                unit: this.newIngredient.unit.trim(),
                group: this.newIngredient.group.trim(),
                notes: this.newIngredient.notes.trim()
            });
            
            // Reset form
            this.newIngredient = {
                name: '',
                quantity: '',
                unit: '',
                group: '',
                notes: ''
            };
            
            this.markDirty();
        },
        
        removeIngredient(index) {
            this.form.ingredients.splice(index, 1);
            this.markDirty();
        },
        
        getGroupedIngredients() {
            const groups = {};
            
            this.form.ingredients.forEach((ingredient, index) => {
                const groupName = ingredient.group || 'Main Ingredients';
                if (!groups[groupName]) {
                    groups[groupName] = [];
                }
                groups[groupName].push({
                    ...ingredient,
                    originalIndex: index
                });
            });
            
            return groups;
        },
        
        addInstruction() {
            if (!this.newInstruction.instruction.trim()) return;
            
            this.form.instructions.push({
                instruction: this.newInstruction.instruction.trim(),
                step_type: this.newInstruction.step_type,
                estimated_time: this.newInstruction.estimated_time,
                notes: this.newInstruction.notes.trim()
            });
            
            // Reset form
            this.newInstruction = {
                instruction: '',
                step_type: 'prep',
                estimated_time: null,
                notes: ''
            };
            
            this.markDirty();
        },
        
        removeInstruction(index) {
            this.form.instructions.splice(index, 1);
            this.markDirty();
        },
        
        moveInstructionUp(index) {
            if (index > 0) {
                const temp = this.form.instructions[index];
                this.form.instructions[index] = this.form.instructions[index - 1];
                this.form.instructions[index - 1] = temp;
                this.markDirty();
            }
        },
        
        moveInstructionDown(index) {
            if (index < this.form.instructions.length - 1) {
                const temp = this.form.instructions[index];
                this.form.instructions[index] = this.form.instructions[index + 1];
                this.form.instructions[index + 1] = temp;
                this.markDirty();
            }
        },
        
        addTag() {
            const tag = this.newTag.trim();
            if (tag && !this.form.tags.includes(tag)) {
                this.form.tags.push(tag);
                this.newTag = '';
                this.markDirty();
            }
        },
        
        removeTag(index) {
            this.form.tags.splice(index, 1);
            this.markDirty();
        },
        
        getStepTypeLabel(stepType) {
            return this.stepTypes[stepType] || stepType;
        },
        
        async saveRecipe() {
            this.saving = true;
            this.errors = {};
            
            console.log('Saving recipe with form data:', this.form);
            
            try {
                // Call Livewire save method with form data
                const result = await @this.save(this.form);
                
                console.log('Save result:', result);
                
                if (result) {
                    this.dirty = false;
                    // Redirect will be handled by Livewire
                }
            } catch (error) {
                console.error('Error saving recipe:', error);
                console.error('Error details:', JSON.stringify(error, null, 2));
                
                if (error.validationErrors) {
                    this.errors = error.validationErrors;
                } else if (error.message) {
                    // Handle validation errors from Livewire
                    this.errors = { general: error.message };
                } else if (error.detail && error.detail.message) {
                    // Handle Livewire validation errors
                    this.errors = { general: error.detail.message };
                } else {
                    this.errors = { general: 'An unexpected error occurred while saving the recipe.' };
                }
                
                console.log('Set errors to:', this.errors);
            } finally {
                this.saving = false;
            }
        }
    }
}
</script>
