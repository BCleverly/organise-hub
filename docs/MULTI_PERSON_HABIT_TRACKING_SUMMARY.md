# Multi-Person Habit Tracking System Summary

## Overview
The OrganiseHub application now features a comprehensive multi-person habit tracking system with 9 different users, each with personalized habits and skills tailored to their specific goals and interests.

## User Profiles and Their Habits

### 👑 Admin User (admin@example.com)
**Focus: Leadership Development**

**Skills:**
- **Leadership Development** - Develop strong leadership skills including communication, decision-making, and team management

**Habits:**
- **Daily Team Check-in** (Daily) - Connect with team members daily to understand their progress and challenges
  - *Linked to: Leadership Development*

---

### 👨‍🍳 Chef Sarah (sarah@example.com)
**Focus: Culinary Excellence**

**Skills:**
- **Master Chef Skills** - Develop advanced culinary techniques and recipe creation

**Habits:**
- **Practice Knife Skills** (Daily, 15 min) - Spend 15 minutes daily practicing knife techniques
  - *Linked to: Master Chef Skills*
- **Create New Recipe** (Weekly) - Develop one new recipe each week
  - *Linked to: Master Chef Skills*

---

### 👨‍🍳 Chef Michael (michael@example.com)
**Focus: Artisan Baking**

**Skills:**
- **Artisan Baking** - Master the art of bread making and pastry creation

**Habits:**
- **Sourdough Maintenance** (Daily) - Feed and maintain sourdough starter daily
  - *Linked to: Artisan Baking*
- **Bake Bread** (Weekly, 2x) - Bake fresh bread twice a week
  - *Linked to: Artisan Baking*

---

### 👩‍🍳 Chef Emma (emma@example.com)
**Focus: Dessert Mastery**

**Skills:**
- **Dessert Mastery** - Perfect the art of creating beautiful and delicious desserts

**Habits:**
- **Practice Piping** (Daily, 20 min) - Practice cake decorating and piping techniques
  - *Linked to: Dessert Mastery*
- **Create Dessert** (Weekly) - Make one new dessert recipe each week
  - *Linked to: Dessert Mastery*

---

### 👨‍🍳 Chef David (david@example.com)
**Focus: Grilling Excellence**

**Skills:**
- **Grill Master** - Master the art of grilling and BBQ techniques

**Habits:**
- **Clean Grill** (Daily) - Clean and maintain grill after each use
  - *Linked to: Grill Master*
- **Grill Practice** (Weekly, 30 min) - Practice grilling techniques for 30 minutes
  - *Linked to: Grill Master*

---

### 🎸 Ben (ben@example.com)
**Focus: Guitar Mastery**

**Skills:**
- **Learn Guitar** - Master the guitar and play favourite songs
- **Learn "Wonderwall"** - Master the iconic Oasis song
- **Learn "Hotel California"** - Practice the famous Eagles guitar solo
- **Learn "Stairway to Heaven"** - Tackle the legendary Led Zeppelin song

**Habits:**
- **Practice Chords** (Daily, 30 min) - Work on chord transitions and finger strength
  - *Linked to: Learn Guitar*
- **Practice Scales** (Daily, 15 min) - Improve finger dexterity and music theory
  - *Linked to: Learn Guitar*
- **Learn New Song** (Weekly) - Work on learning a new song
  - *Linked to: Learn Guitar*

---

### 🇪🇸 Ana (ana@example.com)
**Focus: Spanish Language Learning**

**Skills:**
- **Learn Spanish** - Become conversational in Spanish

**Habits:**
- **Practice Vocabulary** (Daily, 10 words) - Learn 10 new words daily
  - *Linked to: Learn Spanish*
- **Listen to Spanish Podcast** (Daily, 15 min) - Improve listening comprehension
  - *Linked to: Learn Spanish*
- **Practice Speaking** (Weekly) - Have a conversation in Spanish
  - *Linked to: Learn Spanish*
- **Complete Grammar Lesson** (Weekly) - Work through one grammar concept
  - *Linked to: Learn Spanish*

---

### 💧 Chloe (chloe@example.com)
**Focus: Wellness & Self-Care**

**Habits:**
- **Morning Meditation** (Daily, 10 min) - Start the day with 10 minutes of mindfulness
- **Drink 8 Glasses of Water** (Daily, 8 glasses) - Stay hydrated throughout the day
- **Take a Walk** (Daily) - Get some fresh air and exercise
- **Read Before Bed** (Daily, 20 min) - Read for at least 20 minutes

---

### 🧪 Test User (test@example.com)
**Focus: General Testing & Development**

**Skills:**
- **Learn guitar** - Basic guitar learning (test skill)

**Habits:**
- **meditate** (Daily) - Basic meditation habit
  - *Linked to: Learn guitar*
- Various test habits for development purposes

## System Features Demonstrated

### 1. **Multi-User Support**
- Each user has their own personalized habit dashboard
- User-specific trackables and progress tracking
- Individual login and session management

### 2. **Skill & Habit Hierarchy**
- Skills serve as parent goals with multiple component habits
- Habits can be linked to skills to show progress toward larger goals
- Progress tracking shows completion rates for both individual habits and overall skills

### 3. **Diverse Goal Types**
- **Checkbox Goals**: Simple yes/no completion (e.g., "Take a Walk")
- **Duration Goals**: Time-based tracking (e.g., "Practice Knife Skills" - 15 min)
- **Count Goals**: Quantity-based tracking (e.g., "Drink 8 Glasses of Water")

### 4. **Frequency Variations**
- **Daily Habits**: Regular daily activities (e.g., meditation, water intake)
- **Weekly Habits**: Less frequent but important activities (e.g., creating new recipes)
- **Custom Frequencies**: Flexible scheduling options

### 5. **Professional & Personal Development**
- **Professional Skills**: Leadership, culinary arts, baking, grilling
- **Personal Skills**: Language learning, music, wellness
- **Mixed Approaches**: Combining professional development with personal growth

### 6. **Progress Tracking**
- Real-time progress percentages
- Streak tracking for habit consistency
- Completion status for daily/weekly goals
- Visual progress indicators

## Technical Implementation

### Database Structure
- **Users Table**: Individual user accounts with authentication
- **Trackables Table**: Unified table for both skills and habits
- **Trackable Completions Table**: Daily completion tracking
- **User Preferences Table**: Personalized settings per user

### Key Features
- **Parent-Child Relationships**: Skills can have multiple associated habits
- **Goal Metrics**: Support for checkbox, duration, and count-based tracking
- **Frequency Management**: Daily, weekly, and custom frequency options
- **Progress Calculation**: Automatic progress percentage calculation
- **Streak Tracking**: Maintains current and longest streaks

## Usage Examples

### For Team Leaders (Admin User)
- Track leadership development through daily team interactions
- Monitor progress on communication and decision-making skills

### For Chefs (Sarah, Michael, Emma, David)
- Develop specialised culinary skills through structured practice
- Track daily and weekly cooking-related activities
- Build expertise in specific areas (knife skills, baking, desserts, grilling)

### For Language Learners (Ana)
- Structured approach to Spanish learning
- Daily vocabulary and listening practice
- Weekly speaking and grammar activities

### For Musicians (Ben)
- Guitar skill development with specific song goals
- Daily practice routines for technique improvement
- Weekly song learning targets

### For Wellness Enthusiasts (Chloe)
- Daily self-care and wellness habits
- Hydration and exercise tracking
- Mindfulness and reading routines

## Benefits of Multi-Person Habit Tracking

1. **Personalized Goals**: Each user can focus on their specific interests and career paths
2. **Structured Progress**: Skills and habits provide clear pathways to improvement
3. **Accountability**: Daily tracking encourages consistent effort
4. **Flexibility**: Support for various goal types and frequencies
5. **Scalability**: System can accommodate unlimited users and trackables
6. **Professional Development**: Supports both personal and career growth

This multi-person habit tracking system demonstrates the application's ability to support diverse user needs while maintaining a consistent and intuitive interface for habit and skill development.

