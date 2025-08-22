## **OrganizeHub: Comprehensive MVP Development & Validation Plan (Laravel Livewire & API)**

This plan details the steps to build your initial Minimum Viable Product (MVP) for OrganiseHub, a platform that combines core functionalities from task management, recipe organisation, and habit tracking for individuals and small groups. This version leverages a **Laravel Livewire frontend** for rapid web development, a **PHP (Laravel) backend** running on **FrankenPHP** with **Laravel Octane** for high performance, and a **relational database (e.g., PostgreSQL/MySQL/MariaDB)**. A key focus is on structuring reusable business logic via **Laravel Actions** to serve both Livewire components and future API endpoints.

### **Quick Start - Development Users**

The application comes with pre-seeded users for development and testing:

**To create test users:**
```bash
php artisan db:seed
```

**To view login credentials:**
```bash
php artisan auth:credentials
```

**Default test users:**
- **Test User**: `test@example.com` / `password`
- **Admin User**: `admin@example.com` / `password`

You can log in at: `http://your-app.test/login`

### **Passkey Authentication**

The application includes **Spatie Laravel Passkeys** for modern, secure authentication:

**Features:**
- ✅ **Passkey Login**: Users can sign in using passkeys (biometric, PIN, or security key)
- ✅ **Email/Password Fallback**: Traditional email/password authentication still available
- ✅ **Modern Security**: Uses WebAuthn standard for phishing-resistant authentication

**How it works:**
1. Users register with email/password first
2. After login, they can add passkeys to their account (future feature)
3. On subsequent logins, they can use either passkeys or email/password

**Current Implementation:**
- Passkey authentication component is integrated into the login page
- Users see both "Sign in with Passkey" and "Sign in with Email" options
- Passkey registration will be added as a user account feature

**Browser Support:**
- Chrome 67+
- Firefox 60+
- Safari 13+
- Edge 18+

### **Phase 1: Define Your Vision & MVP Scope (Pre-Development)**

This crucial phase ensures you're building the *right* product for the *right* audience.

1. **Unifying the Ideas: The Core Problem**  
   * **Problem:** Individuals and small groups often use disparate tools for managing tasks, tracking habits, and organising personal information like recipes, leading to fragmentation, context-switching, and missed opportunities.  
        * **Solution:** A single, intuitive platform that acts as a central hub, reducing friction and enhancing overall organisation and productivity.  
   * **Value Proposition:** "OrganiseHub simplifies your digital life by centralising your tasks, personal recipes, and habit tracking in one intuitive, easy-to-use platform."  
2. **Target Audience:**  
   * **Primary:** Individuals and small groups (e.g., families, roommates, small hobby clubs, freelance collaborators) seeking a simple, affordable solution to manage daily activities, personal goals, and household/shared content.  
   * **Secondary:** Those overwhelmed by feature-rich, expensive enterprise tools.  
3. **Initial MVP Focus:**  
   * To start lean and validate quickly, the MVP will primarily focus on **Task Management** and **Recipe Organisation** for the web application.  
   * **Habit Tracking** will be planned as a clear **Version 2 (V2) module**, built upon the flexible data architecture established in the MVP. This allows for focused development and faster market entry.

### **Phase 2: Design & Planning (Before Coding)**

Visualizing and structuring your product will save significant development time.

1. **User Flows:** Map out the essential user journeys for the web application.  
   * **Authentication:** User arrives \-\> Sign Up / Log In \-\> Dashboard.  
   * **Task Management:** Dashboard \-\> View Tasks \-\> Add Task \-\> Edit Task \-\> Mark Complete \-\> Delete Task.  
   * **Recipe Management:** Dashboard \-\> View Recipes \-\> Add Recipe \-\> Edit Recipe \-\> Search/Filter Recipes \-\> Delete Recipe.  
   * **Navigation:** How users switch between "Tasks" and "Recipes" modules on the web.  
2. **Wireframing (Low-Fidelity):**  
   * Sketch out the key screens: Login/Sign Up, Main Dashboard (with links to modules), Task List, Add/Edit Task Form, Recipe List, Add/Edit Recipe Form.  
   * Focus on layout, primary actions, and information hierarchy.  
   * *Tools:* Pen & Paper, Figma (for digital collaboration), Miro.  
3. **UI Layout / Site Map for Clear UX** To avoid confusion and ensure a clear, easy-to-use experience, OrganiseHub will follow a modular UI layout with distinct areas for each core function.  
   * **Landing Page (/):**  
     * Publicly accessible.  
     * Highlights value proposition, key features (Tasks, Recipes), pricing.  
     * Clear calls-to-action for "Sign Up" and "Log In."  
   * **Authentication Pages (/login, /register, /forgot-password):**  
     * Standard user authentication flows.  
     * Clean, minimal design to reduce friction.  
   * **Main Dashboard (/dashboard):**  
     * The user's central hub after logging in.  
     * **NOT** where all tasks/recipes are displayed in detail.  
     * Provides an **at-a-glance summary** of each module (e.g., "5 overdue tasks," "3 new recipes this week").  
     * Features prominent, clear navigation links (buttons/cards) to access the dedicated "Tasks" and "Recipes" modules.  
     * *Future V2: Will also have a link/summary for "Habits."*  
   * **Global Navigation:**  
     * A persistent sidebar or top navigation bar that is present on all authenticated pages (Dashboard, Tasks, Recipes).  
     * Provides quick access to:  
       * Dashboard  
       * Tasks  
       * Recipes  
       * *(Future V2: Habits)*  
       * User Settings/Profile  
       * Logout  
   * **Tasks Module (/tasks):**  
     * Dedicated page for all task management.  
     * Displays a sortable/filterable list of all user's tasks.  
     * Clear "Add New Task" button.  
     * Options to edit/delete/mark complete for each task item.  
     * Responsive layout for various screen sizes.  
   * **Recipes Module (/recipes):**  
     * Dedicated page for all recipe organization.  
     * Displays a grid or list of all user's recipes.  
     * Search and filter capabilities (by category, ingredients).  
     * Clear "Add New Recipe" button.  
     * Clicking a recipe opens a detailed view (modal or dedicated page).  
     * Responsive layout.  
   * **Add/Edit Forms (Modal or Dedicated Page):**  
     * For both tasks and recipes, these forms will likely appear as modals on desktop for a smoother workflow, or dedicated full-page forms on mobile for better usability.  
   * **User Settings/Profile Page (/settings):**  
     * Allows users to update their profile information, password, etc.

This clear separation ensures users can focus on one area at a time, making the application intuitive and easy to navigate even as more features are added.

1. **Popular Habits for Improvement (for V2 Planning & Validation)** This list provides common and popular habits users might want to track, informing the design and functionality of the future Habit Tracking module. This will be crucial for validation and workflow testing.  
   * **Health & Wellness (Physical):**  
     * **Exercise Regularly:** Go for daily walks, hit the gym, do yoga, run, cycle.  
     * **Healthy Eating:** Cook more at home, eat more vegetables, reduce sugar intake, track calories/macros.  
     * **Hydration:** Drink X glasses/liters of water daily.  
     * **Sleep:** Go to bed at a consistent time, wake up at a consistent time, get 7-8 hours of sleep.  
     * **Mindful Eating:** Eat slowly, pay attention to hunger/fullness cues.  
   * **Health & Wellness (Mental & Emotional):**  
     * **Meditation/Mindfulness:** Practice daily meditation, deep breathing exercises.  
     * **Journaling:** Write in a journal daily for reflection or gratitude.  
     * **Screen Time Reduction:** Limit social media use, reduce overall screen time.  
     * **Gratitude Practice:** List things you're grateful for daily.  
     * **Connect with Nature:** Spend time outdoors daily/weekly.  
   * **Personal Development & Learning:**  
     * **Learning a New Language:** Dedicate X minutes/hours daily to language study (e.g., "Learn Latvian").  
     * **Reading:** Read X pages/minutes daily, finish a book per week/month.  
     * **Skill Practice:** Practice a musical instrument, coding, drawing, writing, or another skill for a set time.  
     * **Continuous Learning:** Watch educational videos, listen to podcasts, take online courses.  
   * **Productivity & Organization:**  
     * **Morning Routine:** Stick to a consistent morning routine.  
     * **Decluttering/Organizing:** Spend X minutes daily organizing a space.  
     * **Planning Ahead:** Plan the next day/week's tasks.  
     * **Procrastination Reduction:** Tackle the most challenging task first ("Eat the Frog").  
     * **Email Inbox Zero:** Process emails daily to keep the inbox empty.  
   * **Financial:**  
     * **Budgeting/Tracking Expenses:** Review budget, log all expenses daily/weekly.  
     * **Saving Money:** Put X amount into savings daily/weekly.  
     * **No-Spend Days:** Have designated days where no money is spent.  
   * **Relationships & Social:**  
     * **Connect with Loved Ones:** Call a friend or family member, send a thoughtful message.  
     * **Perform Random Acts of Kindness:** Do something nice for someone else.  
1. **Database Schema Design (PostgreSQL Example):** This design emphasizes normalization and clear relationships, adhering to Laravel's conventions (e.g., user\_id for foreign keys, created\_at/updated\_at timestamps).  
   * **users table:**  
     * id (BIGINT UNSIGNED AUTO\_INCREMENT PRIMARY KEY or UUID PRIMARY KEY DEFAULT gen\_random\_uuid() for PostgreSQL) \- *UUIDs are great for distributed systems and avoid issues with sequential IDs.*  
     * name (VARCHAR(255)) \- *Optional, if you want a display name.*  
     * email (VARCHAR(255) UNIQUE NOT NULL)  
     * email\_verified\_at (TIMESTAMP NULL) \- *For email verification, good practice.*  
     * password (VARCHAR(255) NOT NULL) \- *Store hashed passwords, never plain text.*  
     * remember\_token (VARCHAR(100) NULL) \- *For "remember me" functionality.*  
     * created\_at (TIMESTAMP NULL)  
     * updated\_at (TIMESTAMP NULL)  
   * **tasks table:**  
     * id (BIGINT UNSIGNED AUTO\_INCREMENT PRIMARY KEY or UUID PRIMARY KEY DEFAULT gen\_random\_uuid())  
     * user\_id (BIGINT UNSIGNED NOT NULL REFERENCES users(id) ON DELETE CASCADE or UUID NOT NULL REFERENCES users(id) ON DELETE CASCADE) \- *Links tasks to their owner.*  
     * title (VARCHAR(255) NOT NULL)  
     * description (TEXT)  
     * due\_date (TIMESTAMP NULL)  
     * status (VARCHAR(50) NOT NULL DEFAULT 'todo') \- *e.g., 'todo', 'in-progress', 'completed'*  
     * priority (VARCHAR(50) DEFAULT 'medium') \- *e.g., 'low', 'medium', 'high'*  
     * created\_at (TIMESTAMP NULL)  
     * updated\_at (TIMESTAMP NULL)  
     * *(For future shared tasks: is\_shared BOOLEAN DEFAULT FALSE, shared\_with\_user\_id UUID REFERENCES users(id) or shared\_group\_id UUID REFERENCES groups(id))*  
   * **recipes table:**  
     * id (BIGINT UNSIGNED AUTO\_INCREMENT PRIMARY KEY or UUID PRIMARY KEY DEFAULT gen\_random\_uuid())  
     * user\_id (BIGINT UNSIGNED NOT NULL REFERENCES users(id) ON DELETE CASCADE or UUID NOT NULL REFERENCES users(id) ON DELETE CASCADE) \- *Links recipes to their owner.*  
     * title (VARCHAR(255) NOT NULL)  
     * instructions (TEXT NOT NULL)  
     * prep\_time (VARCHAR(50)) \- *e.g., '15 mins', '1 hour'*  
     * cook\_time (VARCHAR(50)) \- *e.g., '30 mins', '2 hours'*  
     * servings (INT)  
     * created\_at (TIMESTAMP NULL)  
     * updated\_at (TIMESTAMP NULL)  
   * **ingredients table:** (To avoid duplication and allow for standardized ingredient names)  
     * id (BIGINT UNSIGNED AUTO\_INCREMENT PRIMARY KEY or UUID PRIMARY KEY DEFAULT gen\_random\_uuid())  
     * name (VARCHAR(255) UNIQUE NOT NULL) \- *e.g., 'sugar', 'flour', 'salt'*  
     * created\_at (TIMESTAMP NULL)  
     * updated\_at (TIMESTAMP NULL)  
   * **recipe\_ingredient table:** (Pivot table for many-to-many relationship between recipes and ingredients)  
     * recipe\_id (BIGINT UNSIGNED NOT NULL REFERENCES recipes(id) ON DELETE CASCADE or UUID NOT NULL REFERENCES recipes(id) ON DELETE CASCADE)  
     * ingredient\_id (BIGINT UNSIGNED NOT NULL REFERENCES ingredients(id) ON DELETE CASCADE or UUID NOT NULL REFERENCES ingredients(id) ON DELETE CASCADE)  
     * quantity (VARCHAR(100) NOT NULL) \- *e.g., '1 cup', '2 tsp', '500g'*  
     * unit (VARCHAR(50)) \- *e.g., 'cup', 'tsp', 'gram', 'ml'*  
     * PRIMARY KEY (recipe\_id, ingredient\_id) \- *Composite primary key ensures unique ingredient per recipe.*  
     * created\_at (TIMESTAMP NULL)  
     * updated\_at (TIMESTAMP NULL)  
   * **categories table:** (To avoid duplication and allow for standardized category names)  
     * id (BIGINT UNSIGNED AUTO\_INCREMENT PRIMARY KEY or UUID PRIMARY KEY DEFAULT gen\_random\_uuid())  
     * name (VARCHAR(255) UNIQUE NOT NULL) \- *e.g., 'Breakfast', 'Dinner', 'Vegan', 'Gluten-Free'*  
     * created\_at (TIMESTAMP NULL)  
     * updated\_at (TIMESTAMP NULL)  
   * **recipe\_category table:** (Pivot table for many-to-many relationship between recipes and categories)  
     * recipe\_id (BIGINT UNSIGNED NOT NULL REFERENCES recipes(id) ON DELETE CASCADE or UUID NOT NULL REFERENCES recipes(id) ON DELETE CASCADE)  
     * category\_id (BIGINT UNSIGNED NOT NULL REFERENCES categories(id) ON DELETE CASCADE or UUID NOT NULL REFERENCES categories(id) ON DELETE CASCADE)  
     * PRIMARY KEY (recipe\_id, category\_id)  
     * created\_at (TIMESTAMP NULL)  
     * updated\_at (TIMESTAMP NULL)

### **Phase 3: Core MVP Development (Technical To-Do List)**

This is where the actual building happens.

1. **Backend (PHP/Laravel with FrankenPHP & Laravel Octane):**  
   * **Laravel Project Initialization:**  
     * Create a new Laravel project: composer create-project laravel/laravel organizehub-backend.  
     * Configure .env for your database connection (PostgreSQL, MySQL, or MariaDB).  
   * **Database Setup:**  
     * Ensure your chosen relational database (PostgreSQL, MySQL, or MariaDB) is installed locally and accessible.  
     * **Migrations:** Use Laravel Migrations to define and create your database tables as per the schema in Phase 2\. Run: php artisan migrate.  
     * **Seeders (Optional but Recommended):** Create seeders (php artisan make:seeder UserSeeder, php artisan make:seeder CategorySeeder) for initial dummy data to aid development: php artisan db:seed.  
   * **Laravel Octane & FrankenPHP Integration:**  
     * Install Laravel Octane: composer require laravel/octane.  
     * Install FrankenPHP: php artisan octane:install \--server=frankenphp. This will set up necessary configurations.  
     * Run the high-performance server: php artisan octane:start. This will make your Laravel application accessible via FrankenPHP.  
   * **User Authentication (Laravel Breeze/Jetstream \+ Sanctum):**  
     * For a quick start with Livewire authentication scaffolding, install **Laravel Breeze** (with Livewire stack): composer require laravel/breeze \--dev then php artisan breeze:install livewire. This sets up login, registration, password reset, etc.  
     * **Laravel Sanctum:** This is crucial for both Livewire (as an SPA) and your future mobile API. Breeze integrates Sanctum for session-based SPA authentication.  
       * Ensure App\\Models\\User uses HasApiTokens trait.  
       * Run migrations for the personal access tokens table if not already done: php artisan migrate.  
       * Configure config/sanctum.php for your frontend domain (SPA stateful domains).  
   * **Reusable Logic: Laravel Actions (Service Layer):** This is the core of code reusability.  
     * Create a dedicated App\\Actions directory (or App\\Services).  
     * **Example Action Classes:**  
       * App\\Actions\\Tasks\\CreateTask.php: Encapsulates logic for creating a task (e.g., validation, saving to DB, associating with user).  
       * App\\Actions\\Tasks\\UpdateTask.php  
       * App\\Actions\\Tasks\\DeleteTask.php  
       * App\\Actions\\Recipes\\CreateRecipe.php: Handles complex recipe creation (saving recipe, ingredients, categories).  
       * App\\Actions\\Recipes\\UpdateRecipe.php  
       * App\\Actions\\Recipes\\DeleteRecipe.php  
     * **Structure:** Each Action class should typically have a handle() or execute() method that takes validated data as input and performs the business logic. They can resolve dependencies via constructor injection. \<\!-- end list \--\>

   `// Example: App/Actions/Tasks/CreateTask.php`  
       `namespace App\Actions\Tasks;`

       `use App\Models\Task;`  
       `use App\Models\User;`  
       `use Illuminate\Support\Facades\Validator; // Or use Form Request for validation`

       `class CreateTask`  
       `{`  
           `public function handle(User $user, array $data): Task`  
           `{`  
               `// Basic validation (more comprehensive via Form Request often better)`  
               `Validator::make($data, [`  
                   `'title' => ['required', 'string', 'max:255'],`  
                   `'description' => ['nullable', 'string'],`  
                   `'due_date' => ['nullable', 'date'],`  
                   `'status' => ['required', 'string', 'in:todo,in-progress,completed'],`  
                   `'priority' => ['required', 'string', 'in:low,medium,high'],`  
               `])->validate();`

               `return $user->tasks()->create($data);`  
           `}`  
       `}`

   * **Web Frontend (Laravel Livewire Components):**  
     * Generate Livewire components for each major interactive section:  
       * php artisan make:livewire Tasks\\TaskList  
       * php artisan make:livewire Tasks\\TaskForm (for create/edit)  
       * php artisan make:livewire Recipes\\RecipeList  
       * php artisan make:livewire Recipes\\RecipeForm (for create/edit)  
     * **Livewire Logic:** Within Livewire component classes (app/Livewire/...), call the Action classes. \<\!-- end list \--\>

     `// Example: App/Livewire/Tasks/TaskForm.php`  
       `namespace App\Livewire\Tasks;`

       `use Livewire\Component;`  
       `use App\Actions\Tasks\CreateTask;`  
       `use App\Actions\Tasks\UpdateTask;`  
       `use App\Models\Task;`  
       `use Illuminate\Validation\Rule;`

       `class TaskForm extends Component`  
       `{`  
           `public ?Task $task = null;`  
           `public string $title = '';`  
           `public ?string $description = '';`  
           `public ?string $due_date = '';`  
           `public string $status = 'todo';`  
           `public string $priority = 'medium';`

           `protected function rules()`  
           `{`  
               `return [`  
                   `'title' => ['required', 'string', 'max:255'],`  
                   `'description' => ['nullable', 'string'],`  
                   `'due_date' => ['nullable', 'date'],`  
                   `'status' => ['required', 'string', Rule::in(['todo', 'in-progress', 'completed'])],`  
                   `'priority' => ['required', 'string', Rule::in(['low', 'medium', 'high'])],`  
               `];`  
           `}`

           `public function mount(?Task $task = null)`  
           `{`  
               `if ($task) {`  
                   `$this->task = $task;`  
                   `$this->fill($task->toArray());`  
               `}`  
           `}`

           `public function save(CreateTask $createTask, UpdateTask $updateTask)`  
           `{`  
               `$validated = $this->validate();`

               `if ($this->task) {`  
                   `// Update existing task`  
                   `$updateTask->handle($this->task, $validated);`  
                   `session()->flash('message', 'Task updated successfully!');`  
               `} else {`  
                   `// Create new task`  
                   `$createTask->handle(auth()->user(), $validated);`  
                   `session()->flash('message', 'Task created successfully!');`  
                   `$this->reset(['title', 'description', 'due_date', 'status', 'priority']); // Clear form`  
               `}`

               `$this->dispatch('task-saved'); // Emit event for TaskList to refresh`  
           `}`

           `public function render()`  
           `{`  
               `return view('livewire.tasks.task-form');`  
           `}`  
       `}`

     * **Blade Views (resources/views/livewire/...):** Implement the frontend HTML using Blade, binding inputs to Livewire properties (wire:model) and actions (wire:click, wire:submit). Utilize Tailwind CSS for styling.  
     * **Alpine.js (Optional):** For minor client-side UI enhancements (e.g., toggling modals, simple animations) without full React.  
   * **API Backend (Dedicated API Controllers):**  
     * Define API routes in routes/api.php. These routes will be exposed for your future mobile app.  
     * **API Contracts (Data Structure & Validation)** These contracts define the expected JSON payload structure for your API endpoints. These will directly inform the validation rules within your Laravel Form Requests (StoreXRequest, UpdateXRequest).  
       * **Task Resource**  
         * **Create Task (POST /api/v1/tasks)**  
           * **Required Fields:**  
             * title: (string) The title of the task. Max 255 characters.  
             * status: (string) The current status of the task. Allowed values: todo, in-progress, completed.  
           * **Optional Fields:**  
             * description: (string, nullable) A detailed description of the task.  
             * due\_date: (date/datetime string, nullable) The date by which the task is due. Format: YYYY-MM-DD or YYYY-MM-DD HH:MM:SS.  
             * priority: (string, nullable) The priority level of the task. Allowed values: low, medium, high.  
         * **Update Task (PUT/PATCH /api/v1/tasks/{id})**  
           * **Required Fields:** (None for PATCH, typically all for PUT for full resource replacement)  
             * *(For PATCH, all fields are optional for partial updates)*  
           * **Optional Fields (all fields):**  
             * title: (string) Max 255 characters.  
             * description: (string, nullable)  
             * due\_date: (date/datetime string, nullable)  
             * status: (string) Allowed values: todo, in-progress, completed.  
             * priority: (string) Allowed values: low, medium, high.  
       * **Recipe Resource**  
         * **Create Recipe (POST /api/v1/recipes)**  
           * **Required Fields:**  
             * title: (string) The name of the recipe. Max 255 characters.  
             * instructions: (string) Detailed cooking instructions.  
             * ingredients: (array of objects) Each object must have:  
               * name: (string) Name of the ingredient.  
               * quantity: (string) e.g., "1 cup", "2 tbsp".  
               * unit: (string, optional) e.g., "cup", "tbsp", "gram".  
             * categories: (array of strings) Names of categories (e.g., "Dinner", "Vegan"). Max 50 characters per category name.  
           * **Optional Fields:**  
             * prep\_time: (string, nullable) Estimated preparation time (e.g., "15 mins", "1 hour"). Max 50 characters.  
             * cook\_time: (string, nullable) Estimated cooking time (e.g., "30 mins", "2 hours"). Max 50 characters.  
             * servings: (integer, nullable) Number of servings the recipe yields. Min 1\.  
         * **Update Recipe (PUT/PATCH /api/v1/recipes/{id})**  
           * **Required Fields:** (None for PATCH)  
           * **Optional Fields (all fields):**  
             * title: (string) Max 255 characters.  
             * instructions: (string)  
             * ingredients: (array of objects) Same structure as Create. Will typically replace all existing ingredients.  
             * categories: (array of strings) Same structure as Create. Will typically replace all existing categories.  
             * prep\_time: (string, nullable)  
             * cook\_time: (string, nullable)  
             * servings: (integer, nullable)  
       * **Habit Resource (Future V2)**  
         * **Create Habit (POST /api/v1/habits)**  
           * **Required Fields:**  
             * name: (string) The name of the habit (e.g., "Drink Water"). Max 255 characters.  
             * frequency\_type: (string) How often the habit should be tracked. Allowed values: daily, weekly, monthly, custom.  
           * **Optional Fields:**  
             * description: (string, nullable) A description of the habit.  
             * target\_value: (integer/float, nullable, conditional) The target for measurable habits (e.g., 8 for "glasses of water"). Required if unit is provided.  
             * unit: (string, nullable, conditional) Unit for target\_value (e.g., "glasses", "pages"). Required if target\_value is provided.  
             * start\_date: (date string, nullable) When the habit tracking begins. Format: YYYY-MM-DD.  
             * end\_date: (date string, nullable) When the habit tracking ends. Format: YYYY-MM-DD.  
         * **Update Habit (PUT/PATCH /api/v1/habits/{id})**  
           * **Required Fields:** (None for PATCH)  
           * **Optional Fields (all fields):**  
             * name: (string) Max 255 characters.  
             * description: (string, nullable)  
             * frequency\_type: (string) Allowed values: daily, weekly, monthly, custom.  
             * target\_value: (integer/float, nullable)  
             * unit: (string, nullable)  
             * start\_date: (date string, nullable)  
             * end\_date: (date string, nullable)  
     * **API Controllers (app/Http/Controllers/Api/...):** Create separate controllers specifically for API endpoints.  
       * php artisan make:controller Api/V1/TaskController \--api  
       * php artisan make:controller Api/V1/RecipeController \--api  
       * *(Future V2: php artisan make:controller Api/V1/HabitController \--api)*  
     * **Controller Logic:** These API controllers will primarily handle request validation (using Laravel Form Requests for robust validation, informed by the contracts above) and then *call the same Action classes* that your Livewire components use. They will return JSON responses. \<\!-- end list \--\>

     `// Example: App/Http/Controllers/Api/V1/TaskController.php`  
       `namespace App\Http\Controllers\Api\V1;`

       `use App\Http\Controllers\Controller;`  
       `use App\Http\Requests\Api\V1\StoreTaskRequest; // Create this Form Request`  
       `use App\Http\Requests\Api\V1\UpdateTaskRequest; // Create this Form Request`  
       `use App\Actions\Tasks\CreateTask;`  
       `use App\Actions\Tasks\UpdateTask;`  
       `use App\Actions\Tasks\DeleteTask;`  
       `use App\Models\Task;`  
       `use Illuminate\Http\Request;`  
       `use Illuminate\Http\JsonResponse;`

       `class TaskController extends Controller`  
       `{`  
           `public function __construct()`  
           `{`  
               `// Apply Sanctum middleware to protect these routes`  
               `$this->middleware('auth:sanctum');`  
           `}`

           `public function index(Request $request): JsonResponse`  
           `{`  
               `// Ensure tasks are scoped to the authenticated user`  
               `$tasks = $request->user()->tasks()->get();`  
               `return response()->json($tasks);`  
           `}`

           `public function store(StoreTaskRequest $request, CreateTask $createTask): JsonResponse`  
           `{`  
               `$task = $createTask->handle($request->user(), $request->validated());`  
               `return response()->json($task, 201);`  
           `}`

           `public function show(Task $task): JsonResponse`  
           `{`  
               `// Use Laravel's policy-based authorization or ensure user owns task`  
               `$this->authorize('view', $task); // Assuming you have a TaskPolicy`  
               `return response()->json($task);`  
           `}`

           `public function update(UpdateTaskRequest $request, Task $task, UpdateTask $updateTask): JsonResponse`  
           `{`  
               `$this->authorize('update', $task); // Assuming you have a TaskPolicy`  
               `$updatedTask = $updateTask->handle($task, $request->validated());`  
               `return response()->json($updatedTask);`  
           `}`

           `public function destroy(Task $task, DeleteTask $deleteTask): JsonResponse`  
           `{`  
               `$this->authorize('delete', $task); // Assuming you have a TaskPolicy`  
               `$deleteTask->handle($task);`  
               `return response()->json(null, 204);`  
           `}`  
       `}`

     * **Authentication for API:** Laravel Sanctum provides token-based authentication for APIs. For the mobile app, users would exchange credentials for an API token (auth/token or similar endpoint), which is then sent with subsequent requests in the Authorization: Bearer \<token\> header.  
     * **CORS Configuration:** Configure config/cors.php to allow requests from your future mobile app domain/origin.

### **Phase 4: Deployment & Testing**

Get your application live and ensure it's robust.

1. **Hosting Setup:**  
   * **Unified Deployment:** Deploy your entire Laravel application (which includes both Livewire frontend and API backend) to a single server or PaaS (e.g., a VPS like DigitalOcean Droplet, AWS EC2, Heroku, Render, or a specialized Laravel hosting like Laravel Forge/Cloud).  
   * **FrankenPHP Deployment:** Configure your deployment environment to run Laravel via FrankenPHP (e.g., using Docker or direct installation as outlined in FrankenPHP docs).  
   * **Database Hosting:** Set up a managed database service (e.g., AWS RDS PostgreSQL/MySQL, DigitalOcean Managed PostgreSQL/MySQL, Render PostgreSQL/MySQL). Configure your Laravel backend to connect to this remote database.  
   * **Domain Configuration:** Set up your domain to point to your server, ensuring both web (Livewire) and API routes are accessible.  
2. **Functional Testing:**  
   * Test all web application features (CRUD for Tasks and Recipes) through the Livewire interface.  
   * Test user registration, login, and logout for the web.  
   * Manually test API endpoints (using Postman, Insomnia, or curl) for CRUD operations on Tasks and Recipes, verifying token-based authentication for protected routes.  
   * Verify data persistence across sessions.  
   * Verify data validation works correctly on both Livewire forms and direct API calls, aligning with the defined **API contracts**.  
3. **User Experience Testing:**  
   * Test the web application on various devices (mobile phone, tablet, desktop) and browsers.  
   * Check for responsiveness, ease of navigation, and clarity of UI elements.  
   * Ensure all interactive elements have appropriate touch target sizes.  
   * Monitor performance with Laravel Octane and FrankenPHP – ensure faster response times for Livewire requests.

### **Phase 5: Validation & Iteration**

This is the continuous cycle of improving your product based on real-world feedback.

1. **Pre-Development Validation (Crucial for initial idea):**  
   * **User Interviews/Surveys:** Talk to 10-20 potential target users. Ask them about their current methods for managing tasks, recipes, and habits. What are their pain points? What do they wish existed? Would they pay a small fee for a solution that addresses these?  
   * **Landing Page with Email Capture:** Create a simple one-page website describing OrganizeHub's core value proposition (Tasks \+ Recipes). Include a clear call-to-action to "Join the Waitlist" or "Get Early Access" by entering an email. This gauges real interest before significant development.  
2. **Post-MVP Launch Validation:**  
   * **Beta Program:** Invite a small group of your target audience (from your waitlist or network) to use the MVP web application. Provide clear instructions on how to give feedback (e.g., a dedicated Slack channel, a simple feedback form).  
   * **Direct User Feedback:**  
     * **In-app Feedback:** Implement a discreet "Feedback" button or modal within the app.  
     * **Support Channels:** Be accessible via email or a simple chat widget.  
     * **Scheduled Interviews:** Conduct follow-up interviews with beta users to understand their experience, what they love, and what they struggle with.  
   * **Usage Analytics:** Integrate a simple analytics tool (e.g., Google Analytics – be mindful of privacy) to track:  
     * User sign-ups and retention for the web app.  
     * Most used features (Tasks vs. Recipes).  
     * Feature engagement (e.g., how often tasks are completed, how many recipes are added).  
     * Common drop-off points in user flows.  
   * **Iterate Based on Feedback:**  
     * Regularly review collected feedback and analytics.  
     * Prioritize bug fixes and new features based on impact and user demand for the web.  
     * When ready, leverage the existing API structure and Action classes to build out the mobile app. Plan for V2 features like **Habit Tracking** to be integrated into both the web (Livewire) and mobile (API) platforms.

By following this comprehensive plan, leveraging your Laravel proficiency with Livewire, FrankenPHP, Octane, and a well-structured Action layer, you'll build a valuable MVP, gather crucial insights, and be well-positioned to iterate and grow OrganizeHub effectively across multiple platforms.