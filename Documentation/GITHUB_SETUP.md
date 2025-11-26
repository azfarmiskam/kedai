# GitHub Repository Setup Guide

## Step 1: Create GitHub Repository

1. Go to [GitHub](https://github.com)
2. Click the **"+"** icon in the top right corner
3. Select **"New repository"**

### Repository Settings

**Repository Name:** `kedai` (or your preferred name)

**Description:** 
```
Multi-tenant SaaS e-commerce platform for students, startups, and SMEs. Built with Laravel.
```

**Visibility:** 
- ✅ **Public** (recommended for open-source)
- ⬜ **Private** (if you want to keep it private)

**Initialize Repository:**
- ⬜ Do NOT add README (we already have one)
- ⬜ Do NOT add .gitignore (we already have one)
- ⬜ Do NOT add license (we already have one)

Click **"Create repository"**

---

## Step 2: Connect Local Repository to GitHub

After creating the repository, GitHub will show you commands. Use these:

### Option A: If you created an empty repository

```bash
# Add GitHub as remote origin
git remote add origin https://github.com/YOUR_USERNAME/kedai.git

# Rename branch to main (optional, if you prefer main over master)
git branch -M main

# Push to GitHub
git push -u origin main
```

### Option B: If you prefer SSH

```bash
# Add GitHub as remote origin (SSH)
git remote add origin git@github.com:YOUR_USERNAME/kedai.git

# Rename branch to main (optional)
git branch -M main

# Push to GitHub
git push -u origin main
```

---

## Step 3: Verify Upload

1. Refresh your GitHub repository page
2. You should see all files uploaded
3. README.md should be displayed on the repository homepage

---

## Step 4: Configure Repository Settings (Optional but Recommended)

### Add Topics/Tags

Go to **Settings** → **General** → **Topics**

Add relevant topics:
- `laravel`
- `saas`
- `ecommerce`
- `multi-tenancy`
- `php`
- `mysql`
- `marketplace`
- `subscription-based`

### Set Up Branch Protection

Go to **Settings** → **Branches** → **Add rule**

**Branch name pattern:** `main` (or `master`)

Enable:
- ✅ Require pull request reviews before merging
- ✅ Require status checks to pass before merging
- ✅ Require branches to be up to date before merging

### Enable Issues and Discussions

Go to **Settings** → **General** → **Features**

Enable:
- ✅ Issues
- ✅ Discussions (for community Q&A)
- ✅ Projects (for project management)

---

## Step 5: Add Repository Description and Website

Go to **Settings** → **General**

**Description:**
```
🛒 Kedai - Multi-tenant SaaS e-commerce platform for students, startups, and SMEs
```

**Website:** (if you have a demo site)
```
https://kedai.demo (or leave empty for now)
```

**Topics:** (as mentioned in Step 4)

---

## Step 6: Create GitHub Actions (Optional - CI/CD)

Create `.github/workflows/laravel.yml`:

```yaml
name: Laravel CI

on:
  push:
    branches: [ main ]
  pull_request:
    branches: [ main ]

jobs:
  laravel-tests:
    runs-on: ubuntu-latest

    steps:
    - uses: actions/checkout@v3
    
    - name: Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: '8.2'
        extensions: mbstring, xml, ctype, iconv, intl, pdo_mysql
        
    - name: Copy .env
      run: php -r "file_exists('.env') || copy('.env.example', '.env');"
      
    - name: Install Dependencies
      run: composer install -q --no-ansi --no-interaction --no-scripts --no-progress --prefer-dist
      
    - name: Generate key
      run: php artisan key:generate
      
    - name: Directory Permissions
      run: chmod -R 777 storage bootstrap/cache
      
    - name: Create Database
      run: |
        mkdir -p database
        touch database/database.sqlite
        
    - name: Execute tests
      env:
        DB_CONNECTION: sqlite
        DB_DATABASE: database/database.sqlite
      run: php artisan test
```

---

## Step 7: Add Badges to README (Optional)

Add these badges to the top of your README.md:

```markdown
[![Laravel](https://img.shields.io/badge/Laravel-11.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)
[![PRs Welcome](https://img.shields.io/badge/PRs-welcome-brightgreen.svg)](CONTRIBUTING.md)
```

---

## Quick Command Reference

```bash
# Check remote
git remote -v

# Check current branch
git branch

# Check status
git status

# View commit history
git log --oneline

# Push changes
git push origin main

# Pull changes
git pull origin main

# Create new branch
git checkout -b feature/new-feature

# Switch branch
git checkout main
```

---

## Troubleshooting

### Error: "remote origin already exists"
```bash
git remote remove origin
git remote add origin https://github.com/YOUR_USERNAME/kedai.git
```

### Error: "failed to push some refs"
```bash
# Pull first, then push
git pull origin main --rebase
git push origin main
```

### Error: "Permission denied (publickey)"
```bash
# Use HTTPS instead of SSH
git remote set-url origin https://github.com/YOUR_USERNAME/kedai.git
```

---

## Next Steps After GitHub Setup

1. **Invite Collaborators** (if working in a team)
   - Go to Settings → Collaborators
   - Add team members

2. **Set Up Project Board**
   - Go to Projects → New project
   - Use "Board" template
   - Add columns: To Do, In Progress, Done

3. **Create Issues for Tasks**
   - Use Documentation/TASKS.md as reference
   - Create issues for each major task
   - Assign to team members

4. **Set Up Milestones**
   - Phase 2: Core Infrastructure
   - Phase 3: Super Admin Module
   - Phase 4: Admin Module
   - etc.

---

## Repository Structure on GitHub

```
kedai/
├── .github/
│   └── workflows/          # CI/CD workflows (optional)
├── app/                    # Laravel application
├── database/               # Migrations and seeders
├── Documentation/          # Project documentation
│   ├── PRD.md
│   ├── IMPLEMENTATION_PLAN.md
│   ├── DATABASE_SCHEMA.md
│   ├── TASKS.md
│   └── WALKTHROUGH.md
├── resources/              # Views, JS, CSS
├── routes/                 # Route definitions
├── tests/                  # Test files
├── .gitignore
├── .gitattributes
├── CONTRIBUTING.md
├── LICENSE
├── README.md
└── composer.json
```

---

## Useful GitHub Features

### GitHub Pages (for documentation)
- Go to Settings → Pages
- Source: Deploy from a branch
- Branch: main, folder: /docs (if you move Documentation to docs)

### GitHub Discussions
- Enable for community Q&A
- Categories: General, Ideas, Q&A, Show and tell

### GitHub Projects
- Kanban board for task management
- Automated workflows
- Link to issues and PRs

---

**You're all set! 🎉**

Your Kedai project is now on GitHub and ready for collaboration!
